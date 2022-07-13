<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_success_scratch_log extends Model
{
    use HasFactory;

    protected $fillable= ['user_id','cart_id','scratch_card_id','scratch_type','status'];
}
