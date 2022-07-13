<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

if(!function_exists('fetch_common_settings')){
    function fetch_common_settings(){
      $common_settings=DB::table('common_settings')->first();
      return $common_settings;
    }
}

if(!function_exists('perform_coin_reduction')){
  function perform_coin_reduction(array $rows,$coupon_amount=0){
    $data=[]; $rows_to_be_affected=[]; $sum=0; $updated_row_coin=[];
    foreach($rows as $k=>$row){
      $sum+=$row['nums'];
      switch(true){
        case ($sum == $coupon_amount):
          $rows_to_be_affected[] = $row['id'];
          $updated_row_coin=[];
            break 2;  /* Exit the switch and the for. */

        case ($sum > $coupon_amount):
          $updated_row_coin['coin_id'] = $row['id'];
          $updated_row_coin['coin_value'] = ($sum) - ($coupon_amount);
            break 2;  /* Exit the switch and the for. */

        case ($sum < $coupon_amount):
            $rows_to_be_affected[] = $row['id'];
            break;

        default :
             break 2;  /* Exit the switch and the for. */

      }
    }
    $data['rows_to_be_affected']=($sum < $coupon_amount) ?[]:$rows_to_be_affected;
  // $data['rows_to_be_affected']=$rows_to_be_affected;
    $data['updated_row_coin']=$updated_row_coin;
    $data['coupon_amount']= $coupon_amount;
    $data['sum']= $sum;
    return $data;
  }
}

if(!function_exists('generate_lilnk_id')){
    function generate_lilnk_id(){
        $link  = Str::random(15);
        $isAvailable    = DB::table('user_links')->where('link', $link)->count();
        return ($isAvailable) ? generate_lilnk_id() : $link;
    }
}
