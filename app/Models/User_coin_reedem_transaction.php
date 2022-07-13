<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_coin_reedem_transaction extends Model
{
    use HasFactory;
    
    protected $fillable=['user_id','type','coupon_id','coins_reedemed','instant_coins','amount','status'];

    public function coupon_data(){
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }
}
