<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scratch_coin;
use App\Models\Scratch_offer;
use Carbon\Carbon;

class Scratch_card extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['description','scratch_title'];

    public function scratchable()
    {
        return $this->morphTo();
    }

    public function scopePreventExpiredCards($query){
        return $query->whereHasMorph('scratchable', [Scratch_coin::class, Scratch_offer::class], function($q,$type){
             if($type === Scratch_offer::class) $q->whereDate('scratch_offers.validity','>=',Carbon::today()->toDateString());
        });
    }
}
