<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class User_scratch_cart extends Model
{
    use HasFactory;

    protected $fillable= ['user_id','is_gift_granted','scratch_card_id','is_scratched'];

    protected $appends = ['card_info'];

    protected $casts = [
        'card_info' => 'array'
    ]; 

    public function scopeWithScratchInfos($query){
        // $query->addSelect(['scratch_status' => DB::raw('CASE WHEN scratch_card_id IS NULL THEN 0 ELSE (select ) END AS scratch_status')
        // ]);
      //  return $query->selectRaw('CASE WHEN scratch_card_id IS NULL THEN 0 ELSE 1 END AS scratch_status');  
    }

    public function getCardInfoAttribute(){
        $card_core=  $this->scratch_card_info;   
        return (isset($card_core)) ? [
            'type' => $card_core->scratchable_type === Scratch_coin::class ? 'coin' : ($card_core->scratchable_type === Scratch_offer::class ? 'offer' : 'NIL'),
            'scratch_card_title' => ($card_core->scratch_title ?? null),
            'description' =>  ($card_core->description ?? null), 
            'equivalent_coins' =>  ($card_core->scratchable->equivalent_coins ?? null),
            'offer_title' =>  ($card_core->scratchable->title ?? null),
            'offer_thumb_img' => isset($card_core->scratchable->images->thumb_img) ? config('app.url').'/storage/'.$card_core->scratchable->images->thumb_img : null,
            'offer_code' => ($card_core->scratchable->code ?? null),
            'valid_date' => ($card_core->scratchable->validity ?? null),
        ] 
       
        : null;  
    }

    public function user_details(){
        return $this->belongsTo(User::class,'user_id','id');  
    }

    public function scratch_card_info(){
        return $this->belongsTo(Scratch_card::class,'scratch_card_id','id'); 
    }
    public function scopeGiftedOffers($query){
    return $query->where('is_scratched',1)->whereHas('scratch_card_info',function($q){
       return  $q->whereHasMorph('scratchable', [Scratch_offer::class]);
    });

    }

    
}
