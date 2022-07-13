<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planpayment_response extends Model
{
    use HasFactory;
    protected $fillable=['order_id','user_id','plan_id','status'];
}
