<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoGraphicCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'alt_text'  =>  $this->alt_text,
            'img'       => ($this->images) ?config('app.url').'/storage/'.$this->images->img : '',
            'thumb_img'     => ($this->images->thumb_img)
                                ? config('app.url').'/storage/'.$this->images->thumb_img
                                : (($this->images) ? config('app.url').'/storage/'.$this->images->img : ''),
        ];
    }
}
