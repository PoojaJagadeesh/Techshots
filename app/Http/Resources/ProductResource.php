<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = Carbon::parse($this->display_date);
        return [
            'id'        => $this->id,
            'heading'   => $this->heading,
            'description' => $this->description,
            'product_link'  => $this->product_link,
            'actual_price' => $this->actual_price,
            'discount_price' => $this->discount_price,
            'button_label' => $this->button_label,
            'display_date' => $date->format('d M Y'),
            'img'     => config('app.url').'/storage/'.$this->images->img,    
        ];
    }
}
