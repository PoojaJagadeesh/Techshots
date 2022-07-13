<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discover extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['heading', 'link', 'tag'];


    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
