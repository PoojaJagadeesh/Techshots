<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscoverResource extends JsonResource
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
            'heading'   => $this->heading,
            'tag'      => $this->tag,
            'link' => $this->link,
            'img'     => config('app.url').'/storage/'.$this->images->img,
        ];
    }
}
