<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserScratchCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $is_user_premium = auth()->user()->cannot('checkplan','App\Models\User') ? 0:1;
        return [
           'id' => $this->id,
           'is_gift_granted' => ($this->is_gift_granted) ? true:false,
           'scratch_card_id' =>  $this->scratch_card_id ?? null,
           'is_scratched'  => ($this->is_scratched === 1) ?? false,
           'type'  =>   $this->card_info['type'] ?? null,
           'scratch_card_title' => $this->card_info['scratch_card_title'] ?? null,
           'description' => $this->card_info['description'] ?? null,
           'equivalent_coins' =>  $this->card_info['equivalent_coins'] ?? null,
           'offer_title' =>  $this->card_info['offer_title'] ?? null, 
           'offer_thumb_img' =>  $this->card_info['offer_thumb_img'] ?? null, 
           'offer_code' =>  $this->card_info['offer_code'] ?? null, 
           'offer_valid_date' =>  $this->card_info['valid_date'] ?? null, 
           'is_user_premium' => $is_user_premium,
        ];
    }
}
