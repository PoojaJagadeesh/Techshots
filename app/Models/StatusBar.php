<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusBar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['heading', 'content', 'year', 'display_date'];

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
