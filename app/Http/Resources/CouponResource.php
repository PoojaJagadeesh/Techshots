<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->user();
        $remaining_coins = $user->active_coins_num();
        $is_user_prime = $user->can('checkplan','App\Models\User') ?? false;
        return [
            'id'        => $this->id,
            'title'   => $this->title,
            'description'   => $this->description,
            'equivalent_coins'      => $this->equivalent_coins,
            'remaining_coins'  => $remaining_coins,
            'offer_code'  =>  $this->code,
            'validity_date' => $this->validity,
            'thumb_img'     => config('app.url').'/storage/'.$this->images->thumb_img,
            'is_user_prime' => $is_user_prime,
        ];
    }
}
