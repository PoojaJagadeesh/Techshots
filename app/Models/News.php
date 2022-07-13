<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use App\Traits\ShareableTrait;

class News extends Model
{
    use HasFactory, SoftDeletes,ShareableTrait;

    protected $fillable = ['heading', 'description', 'tag', 'display_date', 'is_favourite','is_premium','order_num','claps'];
    protected $appends = ['favourite_flag'];
    protected $shareOptions = [
        'columns' => [
            'title' => 'heading'
          
        ],
        'url' => 'url'
    ];

   public function scopeFilterNews($query){
    if(auth()->user()->cannot('checkplan','App\Models\User')){
       return $query->whereNull('is_premium');
      }
    }
   
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function users_con(){
        return $this->belongsToMany(User::class,'user_favourite_news','news_id','user_id');
      }

    public function getFavouriteFlagAttribute(){
        if(Auth::user()){
            return ($this->users_con->contains(Auth::user()->id)) ? 1:0;
        }
        return null;
       
        //return ($this->users_con()->where('id',Auth::user()->id)->exists()) ? 1 : 0;
    }
    // public function getUrlAttribute($id,$type="link")
    //     {
    // return echo route('newslink');
    //     }
}
