<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scratch_offer extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['title','code','validity'];

    public function scratch_cards(){
      return  $this->morphOne(Scratch_card::class,'scratchable');
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
