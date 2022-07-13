<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
        $is_user_premium = auth()->user()->cannot('checkplan','App\Models\User') ? 0:1;
        return [
            'id'        => $this->id,
            'heading'   => $this->heading,
            'description'   => preg_replace( "/(\r|\n)/", "", $this->description),
            'tag'      => $this->tag,
            'display_date' => $date->format('d M Y'),
            'img'     => config('app.url').'/storage/'.$this->images->img,
            'is_premium' => ($this->is_premium == 1) ? 1:0,
            'is_user_premium' => $is_user_premium,
            'favourite_flag' => $this->favourite_flag ,
            'claps' => $this->claps,
           // 'favourite_flag' =>($this->favourite_flag == 1) ? 1:0,
            // 'img'     => config('app.url').'/public/storage/'.$this->images->img,
        ];
    }
}
