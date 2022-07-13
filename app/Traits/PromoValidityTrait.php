<?php

namespace App\Traits;

use App\Models\Plan;
use App\Models\PromoCode;

trait PromoValidityTrait{

    public function validateCode($promo, $plan)
    {
        $plan   = Plan::find($plan);
        $promo  = PromoCode::where('code', $promo)->first();
       

        $error          = 0;

        if(isset($promo) && !empty($promo))
        {
           if($promo->validity == 1)
           {
           
            
               if((date('Y-m-d',strtotime($promo->to))) < date('Y-m-d'))
               {
                $error++; 
               }
                if((date('Y-m-d',strtotime($promo->from))) > date('Y-m-d')){
                    $error++;
                }
           }
          
               if($promo->count_usage <= $promo->user_usage_count)
               {
                   $error++;
               }
          

        }
        else{
            $error++;
        }
       

        if($error > 0)
        {
            return false;
        }
        return true;
    }

}
