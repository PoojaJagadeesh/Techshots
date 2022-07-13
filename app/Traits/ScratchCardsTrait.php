<?php
  
namespace App\Traits;

use App\Http\Resources\UserScratchCartResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User_scratch_cart;
use App\Models\Scratch_card;
use App\Models\Scratch_coin;
use App\Models\Scratch_offer;
use App\Models\User_success_scratch_log;

trait ScratchCardsTrait {
    protected $data;

    protected static  $NEW_USERLUCK = 1;
    protected static  $REGULAR_USERLUCK = 3;

    public function __construct(){
        $this->data=[];
    }

    public function initiate_new_scratchAndFetch(){
        DB::beginTransaction();
        try{
            $data=$this->performUserScratchOccurness();
            $this->data['status']=true;
            $this->data['message']='Scratch card created.';
            $this->data['data']=$data;
            $this->data['code']=200;
            $response=$this->data;
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

    protected function performUserScratchOccurness(){
        if(count(auth()->user()->scratches_with_gift)){
            $userscratch_chanceGap =  self::$REGULAR_USERLUCK;
        }else{
            $userscratch_chanceGap =  self::$NEW_USERLUCK;
        }

        $data= $this->createScratchForUser($userscratch_chanceGap);
        return $data;
        //  $sting="Your chance gap is ".$this->chooseRandomInRange($userscratch_chanceGap)." random chance is ".mt_rand(1, $userscratch_chanceGap);
        // dd($sting);
    }

    protected function chooseRandomInRange($max, $min= 1){
      return mt_rand($min, $max);
    }

    protected function createScratchForUser(int $userchanceGap){
        $arr= []; 
        if($this->chooseRandomInRange($userchanceGap) ===  mt_rand(1, $userchanceGap) && !$this->exist_achieve_gift_OnLastScratch()){
           $arr=  $this->generate_giftScratchArray();
        }else{
           $arr=  $this->generate_non_giftScratchArray();
        }
        // $scratch_cart =  User_scratch_cart::create($arr);
        $scratch_cart =  auth()->user()->all_gained_scratches()->create($arr);
        $response =  User_scratch_cart::select('*')->with('scratch_card_info')
          ->whereId($scratch_cart->id)
          ->withscratchinfos()->first();
          
        return new UserScratchCartResource($response);
    }

    protected function exist_achieve_gift_OnLastScratch(){   
        $last_scratch =   auth()->user()->all_gained_scratches->last(); // picking user's last scratch
        return (isset($last_scratch) && ($last_scratch->is_gift_granted == 1) && ($last_scratch->scratch_card_id != null)) ? true:false;
    }

    protected function generate_giftScratchArray() :array{
        $arr=[];
        $crd=Scratch_card::PreventExpiredCards()->inRandomOrder()->first();
        if(isset($crd)){
            $arr['user_id']=  auth()->user()->id;
            $arr['is_gift_granted'] =  1; // coin or offer granted
            $arr['scratch_card_id'] =  $crd->id; // scratch card id
            $arr['is_scratched'] =  0; // not scratched */
        }
        else{
          $arr=$this->generate_non_giftScratchArray();
        }
        return $arr;
    }


    protected function generate_non_giftScratchArray() :array{
        $arr=[];
        $arr['user_id']=  auth()->user()->id;
        $arr['is_gift_granted'] =  0; // coin or offer granted
        $arr['scratch_card_id'] =  null; // scratch card null
        $arr['is_scratched'] =  0; // not scratched   
        return $arr;
    }




    protected function scratch_theCard(Request $request){
        $params=[];
        $validator =Validator::make($request->all(),
          ['scratch_entity'=>'required|exists:user_scratch_carts,id'],
          [
            'scratch_entity.required' => 'Scratch card id is required.',
            'scratch_entity.exists'=>'Invalid Scratch card id.',
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
                $params['scratch_entity'] =  (int)$request->input('scratch_entity');
                $data=  $this->check_andGrantGiftIfDeserved($params);
               
              DB::commit();
              $this->data['status'] = $data['status'];
              $this->data['code'] = $data['code'];
              $this->data['data']= $data['data'];
              $this->data['error']= $data['error'];
              $response=$this->data;
              return $response; 
            }catch(\Exception $e){
                DB::rollback();
                $this->data['status']=false;
                $this->data['code']=401;
                $this->data['data']=null;
                $this->data['error']['message']='Error while scratching.';
                $this->data['error']['errors']=$e->getMessage();
                $response=$this->data;
                return $response; 
              }

          }
    }



    public function check_andGrantGiftIfDeserved(array $params){
        $scratch_entity =  auth()->user()->all_gained_scratches;
        $deserved_Scratchdata =   $scratch_entity->whereIn('id',(array)$params['scratch_entity'])->first();
        if(!$deserved_Scratchdata || $deserved_Scratchdata->is_scratched === 1){
            $this->data['status']=   false;
            $this->data['message']=  'Invalid attempt occured.';
            $this->data['code']=  403;
            $this->data['data']=  null;
            $this->data['error']['message']=  'Seems user does not own this scratch entity.';
            $response=$this->data;
        }
        else{

          switch(true){
            case ($deserved_Scratchdata->is_gift_granted != 1 && $deserved_Scratchdata->scratch_card_id == null):
              $response=  $this->sendUserBetterLuckNexttimeResponse($deserved_Scratchdata);
              break;
            case ($deserved_Scratchdata->is_gift_granted === 1 && $deserved_Scratchdata->scratch_card_id != null):
              $response=  $this->sendUserDesiredGiftResponse($deserved_Scratchdata);
              break;
            default :
            $response=  $this->sendUserBetterLuckNexttimeResponse($deserved_Scratchdata);
              break;        
          }

        }
        return $response; 
    }

    public function sendUserBetterLuckNexttimeResponse(User_scratch_cart $deserved){  // sending better luck next time response
         $data =  $deserved;
         $data->is_scratched=  true;  // the scratch entity is scratched.
         $data->save(); 

            $this->data['status']=   true;
            $this->data['message']=  'Sorry Better Luck Next Time !.';
            $this->data['code'] =  200;
           // $this->data['data'] =  new UserScratchCartResource(User_scratch_cart::find($data->id));  
            $this->data['data']=  null;
            $this->data['error']=  null;

            $response=  $this->data;
            return $response;
    }

    public function sendUserDesiredGiftResponse(User_scratch_cart $deserved){  // sending gift response to user
        $data=  $deserved;
        $data->is_scratched=  true;  // the scratch entity is scratched.
        $data->save(); 
        $scratch_card=  Scratch_card::with('scratchable')->find($data->scratch_card_id); 

      if($scratch_card->scratchable_type  === Scratch_coin::class){
        $type= 1; 
        $coins= $scratch_card->scratchable->equivalent_coins;
        $this->addToUserActivecoin($coins); // if coin is the gift add coin values to respect tables
        $this->addToSuccessScratchLog($scratch_card, $deserved, $type); // create a success log if gift is granted

          $this->data['status']=   true;
          $this->data['message']=  'Success.';
          $this->data['code']=  200;
          $this->data['data']=  new UserScratchCartResource(User_scratch_cart::find($data->id)); 
          // $this->data['data']=  [
          //   'coin_data' => [
          //     'gift_type' => 'coin',
          //    'scratch_card_title' =>  $scratch_card->scratch_title,
          //    'description' => $scratch_card->description,
          //    'equivalent_coins' => $scratch_card->scratchable->equivalent_coins,
          //   ]
          // ];
          $this->data['error']=  null;

          $response=  $this->data;
       }
       else if($scratch_card->scratchable_type  === Scratch_offer::class){
        $type= 0;
        $this->addToSuccessScratchLog($scratch_card, $deserved, $type); // create a success log if gift is granted

          $this->data['status']=   true;
          $this->data['message']=  'Success.';
          $this->data['code']=  200;
          $this->data['data']= new UserScratchCartResource(User_scratch_cart::find($data->id)); 
          // $this->data['data']=  [
          //   'offer_data' => [
          //   'gift_type' => 'offer',
          //   'scratch_card_title' =>  $scratch_card->scratch_title,
          //   'description' => $scratch_card->description,
          //   'offer_title' => $scratch_card->scratchable->title,
          //   'offer_thumb_img' => config('app.url').'/storage/'.$scratch_card->scratchable->images->thumb_img,
          //   'offer_code' => $scratch_card->scratchable->code,
          //   ]  
          // ];
          $this->data['error']=  null;

          $response=  $this->data;
       }
        
       return $response;
  
    }


    public function addToUserActivecoin($incomcoins=null){
      $user_coin=auth()->user()->own_coins()->create([   // inserting gifted coin values to 
        'nums'  => $incomcoins,
         'type' => 1, // type value is 1, since its scratch gift
     ]);

      $activeCoin=auth()->user()->active_coins();
      if($dat=auth()->user()->active_coins){
          $updated_active_coins=($dat->active_coin_nums + $incomcoins);
         $activeCoin->update(['active_coin_nums'=>$updated_active_coins]);
      }else{
         $activeCoin->create(['active_coin_nums'=>$incomcoins]);
      }
     return true;
   }

   public function addToSuccessScratchLog(Scratch_card  $scratch_card, User_scratch_cart $scr_cart, $type=null){
     $makeLog=   User_success_scratch_log::create([
       'user_id' => auth()->user()->id,
       'cart_id' => $scr_cart->id,
       'scratch_card_id' => $scratch_card->id,
       'scratch_type' => $type,
     ]);

     return true;  
   }



   public function showexpecting_andGiftedScratches(){
    $list_data =   auth()->user()->all_gained_scratches()
    ->where(function($q){
      $q->where('is_scratched','!=',1)
      ->orWhere(function($q){
          $q->where('is_scratched','=',1)
            ->where('is_gift_granted','=',1)
            ->whereNotNull('scratch_card_id');
        });
     })
    ->get();

    return UserScratchCartResource::collection($list_data);


    //  $list_data =   auth()->user()->all_gained_scratches()
    //  ->where('is_scratched','!=',1)
    //  ->orWhere(function($q){
    //     $q->where('is_scratched','=',1)
    //       ->where('is_gift_granted','=',1)
    //       ->whereNotNull('scratch_card_id');
    //   })
    //  ->get();

    //  return UserScratchCartResource::collection($list_data);
  }

  public function popUpTheCard(Request $request){
    $scratch_entity =  auth()->user()->all_gained_scratches;
    
    $data =['data'=>[]];
        if( $request->has('scratch_entity') && ($scratch= $scratch_entity->whereIn('id',(array)$request->input('scratch_entity'))->first()) ){
            return new UserScratchCartResource($scratch);
        }
        return response()->json($data,200);
  }

}