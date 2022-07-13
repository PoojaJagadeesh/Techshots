<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoreBoard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['alt_text'];


    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
