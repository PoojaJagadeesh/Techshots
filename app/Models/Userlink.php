<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userlink extends Model
{
    use HasFactory;
    protected $table = 'user_links';
    protected $fillable = ['user_id', 'link'];

    public function user_data(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
