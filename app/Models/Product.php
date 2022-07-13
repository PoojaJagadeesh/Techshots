<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['heading', 'description', 'display_date', 'actual_price','discount_price','button_label','product_link'];

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
