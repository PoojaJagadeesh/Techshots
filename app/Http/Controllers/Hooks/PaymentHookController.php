<?php

namespace App\Http\Controllers\Hooks;

use App\Http\Controllers\Controller;
use App\Models\Hook;
use App\Models\Plan;
use App\Models\PremiumPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentHookController extends Controller
{

    public function payment(Request $request)
    {
        $api = new Api( config('services')['razorpay']['api_key'], config('services')['razorpay']['api_secret']);

        $webhookSecret      = 'my_hook_secret';
        $webhookSignature   = $request->header('X-Razorpay-Signature');
        $payload            = $request->getContent();

        try {
            $api->utility->verifyWebhookSignature($payload, $webhookSignature, $webhookSecret);

            $data   = $request->payload['payment']['entity'];

            $user   = User::find($data['notes']['user_id']);
            $plan   = Plan::find($data['notes']['plan']);

            $id     = $data['id'];

            PremiumPayment::updateOrCreate(
                                ['payment_id' => $id, 'user_id' => $user->id],
                                [
                                    'plan_id'   => $plan->id,
                                    'order_id'  => $data['order_id'],
                                    'amount'    => $data['amount']/100,
                                    'status'    => ($data['status'] == "captured") ? $data['status'] : null
                                ]
                            );


            $isExists = $user->plans()->where('payment_id', $id)->first();
            $user->plans()->where('payment_id', '!=', $id)->update(['status' => 1]);


            if(!$isExists){

                $user->plans()->attach($plan->id,['status' => 0,'created_at' => now(), 'payment_id' => $id]);
            }

        } catch (\Throwable $th) {
            $da = $th->getMessage();
            Hook::create(['response' => $da]);
        }

    }

}
