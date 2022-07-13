<?php

namespace App\Http\Controllers\Frontend\Razorpay;

use Session;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use App\Models\PremiumPayment;
use App\Traits\PromoValidityTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Planpayment_response;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    use PromoValidityTrait;

    public function index()
    {
        // dd($user);
        if(auth()->user()->can('checkplan', User::class)){
            return redirect()->intended(route('userdashboard'));
        }

        $data['plans']   =   Plan::get();
        return view('frontend.razorpay.index',compact(['data']));
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'plan_id'   => 'required',
            'name'      => 'required',
            'price'     => 'required',
            'validity'  => 'required',
        ]);


        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        $data['plan'] = Plan::findOrFail($validated['plan_id']);
        $data['user'] = auth()->user();
        $data['promo_code']=$request->promo;

        $price        = $data['plan']->price;

        if($request->promo && $request->promo != '' && $this->validateCode($request->promo, $validated['plan_id']))
        {
            $promo                      = PromoCode::where('code',$request->promo)->first();
            $promo->user_usage_count    = $promo->user_usage_count+1;
            $promo->save();

            $price        = $data['plan']->price - (($data['plan']->price * $promo->discount_percentage)/100);
            $data['plan']->price = $price;
        }

        // dd($data['plan']);

        $order  = $api->order->create([
                'receipt'         => 'order_rcptid_11',
                'amount'          => $price * 100, // amount in the smallest currency unit
                'currency'        => 'INR',
            ]);
            // dd($order);
        $data['order']  = $order;

        return view('frontend.razorpay._confirm',compact('data'));
    }

    public function createOrder(Request $request)
    {

        if($request->ajax() && auth()->user()->cannot('checkplan',User::class)){
            $input = $request->all();
            //dd($input);
            if($input['amount']!=0){
                $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
                if($input['promocode']!=""){
                    $this->promoValidation($input['promocode']);

                }
                $amount=($input['amount']) ? $input['amount'] :env('PREMIUM_FEE');
                $order  = $api->order->create([
                    'receipt'         => 'premium_pay'.$input['user_id'],
                    'amount'          => $amount*100, // amount in the smallest currency unit
                    'currency'        => 'INR',// <a href="/docs/payment-gateway/payments/international-payments/#supported-currencies" target="_blank">See the list of supported currencies</a>.)
                ]);
                $order_array=$order->toArray();
                $insert=[
                    "order_id"=>$order_array['id'],
                    "plan_id"=>$input['plan_id'],
                    "user_id" =>auth()->user()->id,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
                ];
                PremiumPayment::insert($insert);
                //   \Session::put('success', 'Order successful');

                return response()->json(['status' =>'success','message' => 'Order successful',"order"=> $order_array['id'],"discounted"=>$amount, "promo"=>$input['promocode'],"plan"=>"1" ]);
            }else{
                if($input['plan_id']==1){
                   if(!auth()->user()->can('checkTrialUsed','App\Models\User')){
                    auth()->user()->plans()->attach($input['plan_id'],['status' => 0,'created_at'=>Carbon::now()]);
                    return response()->json(['status' =>'success','message' => 'Trial Plan subscribed',"plan"=>"0"]);
                   }else{
                    return response()->json(['status' =>'success','message' => 'You have already subscribed trial pack',"plan"=>"0"]);
                   }
                }


            }
        }
        else{
            return response()->json(['status' =>'failed','message'=> 'Order failed']);
        }

    }

    public function payment(Request $request)
    {

        $input = $request->all();
        $data['status']     = 0;
        $api = new Api(config('services')['razorpay']['api_key'], config('services')['razorpay']['api_secret']);

        if(isset($input["razorpay_payment_id"]))
        {

            $payment    = $api->payment->fetch($request->razorpay_payment_id);
            $user       = User::findOrFail($payment->notes['user_id']);
            $plan       = Plan::findOrFail($payment->notes['plan']);

            DB::beginTransaction();
            try {
                Auth::login($user);

                if($payment){
                    $data['status']=1;
                }

                $isExists = $user->plans()->where('payment_id', $payment->id)->first();
                $user->plans()->where('payment_id', '!=', $payment->id)->update(['status' => 1]);

                if(!$isExists)
                {
                    $user->plans()->attach($plan->id,['status' => 0,'payment_id' => $payment->id]);
                }


                PremiumPayment::updateOrCreate(
                    ['payment_id' => $payment->id, 'user_id' => $user->id],
                    [
                        'plan_id'   => $plan->id,
                        'order_id'  => $payment->order_id,
                        'amount'    => $payment->amount/100,
                        'status'    => ($payment->status == "captured") ? $payment->status : null
                    ]
                );

                $payresponse = Planpayment_response::create([
                            'user_id'   => $user->id,
                            'status'    => $data['status'], // 1 stands for success payment
                        ]);

               $data['message'] = "Payment Success";
               $data['plan']    = $plan;

               DB::commit();
               return view('frontend.razorpay.success',compact(['data']));
            } catch (\Throwable $th) {
                DB::rollBack();
                // dd($th->getMessage());
                $data['message']    = $th->getMessage();
                $data['failure']    = 'error';
                $data['meta']       = json_decode(json_decode(json_encode($input['error']['metadata']), true),true);
                return view('frontend.razorpay.failure',compact(['data']));
            }
        }else{
            DB::rollBack();
            $data['message']    = "Payment Failed";
            $data['failure']    = $input['error'];
            $data['meta']       = json_decode(json_decode(json_encode($input['error']['metadata']), true),true);
            return view('frontend.razorpay.failure',compact(['data']));
        }


        // return response()->json(['success' => 'Payment successful']);
    }

    public function trialPlanSubscription(){

    }

    public function promoValidation(Request $request)
    {

        $promo_request  = $request->validate([
            'plan'  => 'required|exists:plans,id',
            'promocode' => 'required'
        ]);

        $check = $this->validateCode($promo_request['promocode'], $promo_request['plan']);

        if ($check)
        {

            $promo              = PromoCode::where('code',$promo_request['promocode'])->first();
            $plan               = Plan::find($promo_request['plan']);
            $discountAmount     = $plan->price - (($plan->price * $promo->discount_percentage)/100);

            return response()->json([
                'message'   => 'Promo code applied',
                'status'    => true,
                'data'      => [
                    'amount' => $discountAmount,
                    'code'  => $promo_request['promocode']
                ]
            ]);
        } else {
            return response()->json([
                'message'   => 'Promo code not valid',
                'status'    => false,
                'data'      => null
            ], 400);
        }


    }

    // public function promoApplication(Request $request){
    //     $promo_request=$request->all();
    //     $this->promoValidation($promo_request['promocode']);
    //     if($promo[0]['discount_percentage']){

    //     }
    //     $input['amount']= ($input['amount']-($input['amount'] * ($promo[0]['discount_percentage']/100)));
    //     return view('auth.frontend.razorpay.index',compact(['data']));
    // }

}
