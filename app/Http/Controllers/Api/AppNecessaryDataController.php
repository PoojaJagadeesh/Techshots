<?php

namespace App\Http\Controllers\Api;

use Auth;
use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Models\PremiumPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Traits\CoinManagementTrait;
use App\Http\Controllers\Controller;
use App\Models\Planpayment_response;
use App\Http\Resources\PlanCollection;
use Illuminate\Support\Facades\Validator;

class AppNecessaryDataController extends Controller
{
  use CoinManagementTrait;

   public function __construct()
    {
      //  $this->middleware('checkSubscription')->only(['make_reedem_coupon']);
      $this->middleware('can:checkplan,App\Models\User')->only(['make_reedem_coupon']);
    }

    public function profile(){
      $datastruct = []; $response = [];
      $user = auth()->user();
      $datastruct['user_id'] = $user->id ?? null;
      $datastruct['name'] = $user->name ?? null;
      $datastruct['email'] = $user->email ?? null;
      $datastruct['is_user_prime_or_not'] = auth()->user()->can('checkplan','App\Models\User') ?? false ;
      $datastruct['available_coins'] = auth()->user()->active_coins_num();

      $response['data'] =  $datastruct;
      $response['error'] = null;
      $response['message'] = 'success';
      $response['code']  = 200;
      return response()->json($response,$response['code']);

    }

    public function plans(){
        $plans=Plan::get();
        return PlanCollection::collection($plans);
    }

    public function addPaymentreponses(Request $request)
    {
        $validator = Validator::make($request->all(),
						[
							'order_id'      => 'required|string',
							'payment_id'    => 'required|string',
							'plan_id'       => 'required|integer',
							'status'        => 'required'
						],
						[
							'order_id.required' => 'Order id is required!',
							'payment_id'        => 'Payment id is required',
							'plan_id.required'  => 'Plan is required!',
							'status'            => 'required'
					]);
		if($validator->fails())
		{
			$response['status'] 	= false;
			$response['code'] 		= 401;
			$response['err']['message'] = 'Validation failed.';
			$response['err']['errors'] = $validator->errors();
			$response['data'] 		= null;

		}else{

            DB::beginTransaction();

            try{
                $api = new Api(config('services')['razorpay']['api_key'], config('services')['razorpay']['api_secret']);

				$data 	= $validator->validated();

                $payment    = $api->payment->fetch($data['payment_id']);


              	$payresponse 	= Planpayment_response::create([
									'order_id'  => $data['order_id'],
									'user_id'   => Auth::user()->id,
									'plan_id'   => $data['plan_id'],
									'status'    => ($data['status'] == 1) ? 1 : 0, // 1 stands for success payment
								]);

                $plan 			= Plan::find($data['plan_id']);

                $isExists = auth()->user()->plans()->where('payment_id', $data['payment_id'])->first();

                auth()->user()->plans()->where('payment_id', '!=', $data['payment_id'])->update(['status' => 1]);
                if(!$isExists)
                {
                    auth()->user()->plans()->attach($plan->id,['status' => 0,'payment_id' => $data['payment_id']]);
                }


            PremiumPayment::updateOrCreate(
                ['payment_id' => $payment->id, 'user_id' => auth()->user()->id],
                [
                    'plan_id'   => $plan->id,
                    'order_id'  => $data['order_id'],
                    'amount'    => $payment->amount/100,
                    'status'    => ($payment->status == "captured") ? $payment->status : null
                ]
            );

               DB::commit();
               $response['status']=true;
               $response['code']=200;
               $response['err']=null;
               $response['data']=$payresponse;

            }catch(\Exception $e){
               DB::rollback();

               $response['status']=false;
               $response['code']=401;
               $response['err']['message']='Error while generating the payment response.';
               $response['err']['errors']=$e->getMessage();
               $response['data']=null;
            }

          }
          return response()->json($response,$response['code']);
    }

   public function add_initialcoins(Request $request){
       $response=$this->grant_initial_coins_to_user($request);
       return response()->json($response,$response['code']);
     }

     public function reedem_coin_asCoupon(Request $request){  // old method for reedem as coupon
      $response=$this->processReedemCoupon($request);
      return response()->json($response,$response['code']);
     }

     public function make_reedem_coupon(Request $request){
       $response=$this->reedemCouponasCoin($request);
       return response()->json($response,$response['code']);

     }

}
