<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'mobile',
        'referral_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    public function getJWTIdentifier()

    {

    return $this->getKey();

    }

    public function getJWTCustomClaims()

    {

    return [];

    }
    public function profileImage()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    public function news(){
        return $this->belongsToMany(News::class,'user_favourite_news','user_id','news_id');
    }

    public function plans(){
        return $this->belongsToMany(Plan::class,'user_subscribed_plans','user_id','plan_id')->withPivot(['status','created_at'])->withTimestamps();
        // return $this->belongsToMany(Plan::class,'user_subscribed_plans','user_id','plan_id')->where('status', 0)->withPivot('status');
    }

    public function checkExpiredPlans(){
        return $this->plans()->where('status', 0);
    }

    public function checkPrime(){
        return $this->plans()->where('status', 0)->where('slug', 'premium-plan');
    }

    public function containPlanStatus($plan_id = null, $status = null){
        return $this->plans->contains(function ($val, $key) use ($plan_id, $status) {
            return $val->pivot->plan_id == $plan_id && $val->pivot->status == $status;
        });
    }

    public function own_coins(){
        return $this->hasMany(User_acquired_coins::class,'user_id','id');
    }

    public function own_unused_coins(){
        return $this->own_coins()->where('is_used',0);
    }

    public function total_remaining_unused_coins(){
        return $this->own_unused_coins()->sum('nums'); // picking number of coins which is not usttilized bt user
    }

    public function active_coins(){
        return $this->hasOne(User_active_coin::class,'user_id','id');
    }

    public function active_coins_num(){
        return isset($this->active_coins->active_coin_nums)?$this->active_coins->active_coin_nums:0;
    }


    public function coin_reedem_trans(){
        return $this->hasMany(User_coin_reedem_transaction::class,'user_id','id');
    }

    public function list_reedemed_coupons(){
        return $this->belongsToMany(Coupon::class,'user_coin_reedem_transactions','user_id','coupon_id')->withPivot('type')->orderBy('created_at');
    }

    public function all_gained_scratches(){
        return $this->hasMany(User_scratch_cart::class,'user_id','id');
    }

    public function scratches_with_gift(){
        return $this->all_gained_scratches()->where('is_gift_granted',1)->whereNotNull('scratch_card_id');
    }
    public function user_link(){
        return $this->hasOne(Userlink::class,'user_id','id');
    }

    public function referedUsers()
    {
        return $this->hasMany(User::class, 'referral_id', 'id');
    }

    public function referedBy()
    {
        return $this->belongsTo(User::class, 'referral_id', 'id');
    }







}
