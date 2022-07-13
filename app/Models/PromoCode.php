<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'code_name','code','discount_percentage', 'plan_id','validity','from','to','reusable','count_usage','status','prefix','user_usage_count'
    ];
}
