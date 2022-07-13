<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scratch_coin extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['equivalent_coins'];

    public function scratch_cards(){
       return $this->morphOne(Scratch_card::class,'scratchable');
    }
}
