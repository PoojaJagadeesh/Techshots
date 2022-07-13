<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_active_coin extends Model
{
    use HasFactory;

    protected $fillable=['user_id','active_coin_nums'];

    public function user_data(){
        return $this->belongsTo(User::class,'user_id','id');  
    }
}
