<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'allowable_days', 'price', 'description'];

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
