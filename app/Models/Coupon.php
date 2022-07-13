<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'equivalent_coins', 'code', 'validity'];
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
