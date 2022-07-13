<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id', 'user_id','amount','premium_payments','order_id', 'plan_id', 'status'
    ];
}
