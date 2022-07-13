<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Plan;

class checkUserSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user=Auth::user();
        $plan=$user->checkExpiredPlans;

        // if(auth()->user()->checkExpiredPlans()->exists()){
        //     return response()->json(['message'=>'has plans','data'=>auth()->user()->checkExpiredPlans],200);  
        // }else{
        //     return response()->json(['message'=>'has no plans','data'=>auth()->user()->id],200);  
        // }

        // return response()->json(['data'=>$plan],200);
        if(isset($plan[0]) && ($plan[0] instanceof Plan) && ($plan[0]->allowable_days)){
            $initial_plan       = $plan[0];
            $days_limit         = $initial_plan->allowable_days ;
            $purchased_date     = $initial_plan->pivot->created_at;

             if($purchased_date->addDays($days_limit) <= \Carbon\Carbon::now()){
                $plan[0]->pivot->status=1; $plan[0]->pivot->save();
             }
        }
        return $next($request);
    }
}
