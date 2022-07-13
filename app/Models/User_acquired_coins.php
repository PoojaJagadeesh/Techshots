<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_acquired_coins extends Model
{
    use HasFactory;

    protected $fillable=['user_id','nums','type','is_used',];

    public function own_coins(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
