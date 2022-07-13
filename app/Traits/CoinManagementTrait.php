<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User_acquired_coins;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CouponResource;

trait CoinManagementTrait {
    protected $data;

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function __construct(){
        $this->data=[];
    }

    public function grant_initial_coins_to_user(Request $request){

        DB::beginTransaction();
        try{
        $response = $this->generateCoin();
          DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $this->data['status']=false;
            $this->data['message']=$e->getMessage();
            $this->data['data']=null;
            $this->data['code']=403;
            $response=$this->data;
           }
        return  $response;
    }

    public  function generateCoin($type=0){
        if($type === 0){ // 0 stands for default coins generated when user uses an app once a day
            if(!$this->check_current_token()){
                $common_setting=fetch_common_settings();
                $daily_allowable_coins=isset($common_setting->daily_allowable_coins) ? $common_setting->daily_allowable_coins:5;

                $user_coin=auth()->user()->own_coins()->create([
                   'nums'  => $daily_allowable_coins,
                    'type' => $type,
                ]);
                $this->addToUserActivecoin($daily_allowable_coins);


                $this->data['status']=true;
                $this->data['message']='Initial coins created !.';
                $this->data['data']=$user_coin;
                $this->data['code']=200;
                $response=$this->data; return $response;
            }else{
                $this->data['status']=false;
                $this->data['message']='Not allowed to create initial coins now';
                $this->data['data']=null;
                $this->data['code']=403;
                $response=$this->data; return $response;
            }
        }

    }

    public  function check_current_token(){
        $latest_coin=auth()->user()->own_coins()->whereType(0)->latest()->first();  // type 0 stands for regular token
        if(isset($latest_coin) && ($latest_coin->created_at->format('Y-m-d') == date('Y-m-d'))){ // checking any coin added to user today
            return true;
        }else{
            return false;
        }
    }



    public function retrieve_remainingUserCoins(){
       // $remaining_coins=auth()->user()->total_remaining_unused_coins();
       $common_setting  = fetch_common_settings();
       $remaining_coins = auth()->user()->active_coins_num();

        $this->data['status']               = true;
        $this->data['message']              = 'Remaining coins count.';
        $this->data['data']                 = $remaining_coins;
        $this->data['n_coins']              = $common_setting->n_coins ?? null;
        $this->data['amount_per_n_coins']   = $common_setting->amount_per_n_coins ?? null;
        $this->data['currency']             = $common_setting->currency ?? null;
        $this->data['code']                 = 200;

        $response                           = $this->data;
        return response()->json($response,$response['code']);
    }

    public function show_activeCouponLists(){    // listing the all the coupons
        $activeCouponLists=Coupon::get();
        return CouponResource::collection($activeCouponLists);
    }

    public function show_reedemedCouponLists(){   // listing the coupons reedemed by the user
        $total_reedemed_coupons=auth()->user()->list_reedemed_coupons;
        return CouponResource::collection($total_reedemed_coupons);
    }


    /* starting  old code logic for reedem coin as coupon */
    public function processReedemCoupon(Request $request){
        $params=[];
        $validator =Validator::make($request->all(),
          ['coupon_id'=>'required|exists:coupons,id,deleted_at,NULL'],
          [
            'coupon_id.required' => 'Coupon id is required.',
            'coupon_id.exists'=>'Invalid coupon id.',
          ]);
          if($validator->fails()){
            $this->data['status'] = false;
            $this->data['message'] = 'Invalid attempt occured.';
            $this->data['data'] = null;
            $this->data['code'] = 403;
            $this->data['error']['errors'] = $validator->errors();
            $response=$this->data;
            return $response;
          }else{
            DB::beginTransaction();

            try{
              $params['coupon'] = (int)$request->input('coupon_id');
              $data = $this->checkCouponPossibility($params);
              DB::commit();
              $this->data['status'] = $data['status'];
              $this->data['code'] = $data['code'];
              $this->data['data']= $data['data'];
              $this->data['error']=null;
              $response=$this->data;
              return $response;
            }catch(\Exception $e){
                DB::rollback();
                $this->data['status']=false;
                $this->data['code']=401;
                $this->data['data']=null;
                $this->data['error']['message']='Error while generating the payment response.';
                $this->data['error']['errors']=$e->getMessage();
                $response=$this->data;
                return $response;
              }

          }

    }

    public function checkCouponPossibility(array $params){
        $data=[];
        $coupon_data=Coupon::find($params['coupon']);
        if(($coupon_amount=$coupon_data->equivalent_coins) && (auth()->user()->total_remaining_unused_coins() >= $coupon_data->equivalent_coins)){
            $rows=auth()->user()->own_coins()->where('is_used',0)->orderBy('nums','DESC')->get()->toArray();
            $result=perform_coin_reduction($rows,$coupon_amount);

            $this->modifyCoinUseStatus(($result['rows_to_be_affected'] ?$result['rows_to_be_affected']:[]));
            $this->modifyCoinCount(($result['updated_row_coin'] ?$result['updated_row_coin']:[]));

            $data['status']=true;
            $data['message']="Success.";
            $data['code']=200;
            $data['data']=$result;
        }else{
            $data['status']=false;
            $data['message']="Seems you have not enough coins to reedem this offer.";
            $data['code']=403;
            $data['data']=null;
        }
        return $data;

    }

    public function modifyCoinUseStatus(array $rowAffctd){
        if(auth()->user()
         ->own_coins()->whereIn('id', $rowAffctd)->update(['is_used' => 1])
        )  // making status of used coins as 1
        return true;
    }

    public function modifyCoinCount(array $upRWcn){
        if(isset($upRWcn['coin_id']) && isset($upRWcn['coin_value'])){
            auth()->user()
            ->own_coins()->where('id', $upRWcn['coin_id'])->update(['nums' => $upRWcn['coin_value']]);  // changing the count of an acquired coin
            return true;
        }
    }

    /*   closing old code logic for reedem coin as coupon */


    public function reedemCouponasCoin(Request $request){
        $params=[];
        $validator =Validator::make($request->all(),
          ['coupon_id'=>'required|exists:coupons,id,deleted_at,NULL'],
          [
            'coupon_id.required' => 'Coupon id is required.',
            'coupon_id.exists'=>'Invalid coupon id.',
          ]);
          if($validator->fails()){
            $this->data['status']           = false;
            $this->data['message']          = 'Invalid attempt occured.';
            $this->data['data']             = null;
            $this->data['code']             = 403;
            $this->data['error']['errors']  = $validator->errors();
            $response=$this->data;
            return $response;
          }else{
            DB::beginTransaction();

            try{
              $params['coupon'] = (int)$request->input('coupon_id');
              $data             =  $this->checkReedemPossibility($params);
              DB::commit();
              $this->data['status']     = $data['status'];
              $this->data['code']       = $data['code'];
              $this->data['message']    = $data['message'];
              $this->data['data']       = $data['data'];
              $this->data['error']      = null;
              $response=$this->data;
              return $response;
            }catch(\Exception $e){
                DB::rollback();
                $this->data['status']=false;
                $this->data['code']=401;
                $this->data['message'] = 'Error while reedem.';
                $this->data['data']=null;
                $this->data['error']['message']='Error while reedem.';
                $this->data['error']['errors']=$e->getMessage();
                $response=$this->data;
                return $response;
              }

          }

    }

    public function checkReedemPossibility(array $params){
        $data=[];
        $coupon_data=Coupon::find($params['coupon']);
        if(($coupon_amount=$coupon_data->equivalent_coins) && (auth()->user()->active_coins_num() >= $coupon_data->equivalent_coins)){
            $couponID=$coupon_data->id;
            $this->reductUserActivecoin($coupon_amount,$couponID);

            $data['status']=true;
            $data['message']="Success.";
            $data['code']=200;
            $data['data']=new CouponResource($coupon_data);
            //$data['data']=auth()->user()->active_coins();
        }else{
            $data['status']=false;
            $data['message']="Seems you have not enough coins to reedem this offer.";
            $data['code']=403;
            $data['data']=null;
        }
        return $data;

    }


    public function addToUserActivecoin($incomcoins=null){
        $activeCoin=auth()->user()->active_coins();
        if($dat=auth()->user()->active_coins){
            $updated_active_coins=($dat->active_coin_nums + $incomcoins);
           $activeCoin->update(['active_coin_nums'=>$updated_active_coins]);
        }else{
           $activeCoin->create(['active_coin_nums'=>$incomcoins]);
        }
       return true;
    }

    public function reductUserActivecoin($incomcoins=null,$couponID=null){
        $activeCoin=auth()->user()->active_coins(); $transArr=[];
        $transArr['coupon_id']=  $couponID;
        if($dat=auth()->user()->active_coins){
            switch(true){
                case (($dat->active_coin_nums - $incomcoins) < 0):
                    $transArr['instant_coins']=$dat->active_coin_nums;
                    $transArr['coins_reedemed']=$incomcoins;
                    $updated_active_coins = $dat->active_coin_nums;
                    break;

                case(($dat->active_coin_nums - $incomcoins) >= 0):
                    $transArr['instant_coins']=$dat->active_coin_nums;
                    $transArr['coins_reedemed']=$incomcoins;
                     $updated_active_coins = ($dat->active_coin_nums - $incomcoins);
                    break;

                default:
                    $transArr['instant_coins']=0;
                    $transArr['coins_reedemed']=0;
                    $updated_active_coins = 0;
                   break;
                 }
                $activeCoin->update(['active_coin_nums'=>$updated_active_coins]);
            }
            else{
                $transArr['instant_coins']=0;
                $transArr['coins_reedemed']=0;
                $activeCoin->create(['active_coin_nums'=>0]);
               }
               $this->addReedemTransaction($transArr,$type=0); // 0 stands for coupon reedem type
       return true;
    }

    public function addReedemTransaction(array $transArr,$type=0){
        $arr=[];
        switch($type){
            case 0:  // coupon reedem
                $arr['type']=$type;
                $arr['coupon_id']=isset($transArr['coupon_id']) ?$transArr['coupon_id']:null;
                $arr['coins_reedemed']=isset($transArr['coins_reedemed']) ?$transArr['coins_reedemed']:0;
                $arr['instant_coins']=isset($transArr['instant_coins']) ?$transArr['instant_coins']:0;
                break;
            case 1:  // cash reedem
                $arr['type']=$type;
                $arr['coupon_id']=isset($transArr['coupon_id']) ?$transArr['coupon_id']:null;
                $arr['coins_reedemed']=isset($transArr['coins_reedemed']) ?$transArr['coins_reedemed']:0;
                $arr['amount']=isset($transArr['amount']) ?$transArr['amount']:0;
        }
        auth()->user()->coin_reedem_trans()->create($arr);
        return true;

    }


}
