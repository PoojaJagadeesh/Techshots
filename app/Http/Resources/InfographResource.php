<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfographResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'alt_text'   => $this->alt_text,
            'img'       => ($this->images) ?config('app.url').'/storage/'.$this->images->img : '',
            'thumb_img'     => ($this->images) ?config('app.url').'/storage/'.$this->images->thumb_img : '',
            // 'img'     => config('app.url').'/public/storage/'.$this->images->img,
        ];
    }
}
