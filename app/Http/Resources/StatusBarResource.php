<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusBarResource extends JsonResource
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
            'heading'   => $this->heading,
            'content'   => $this->content,
            'year'      => $this->year,
            'display_date' => $date->format('d M Y'),
            'thumb_img'     => config('app.url').'/storage/'.$this->images->thumb_img,
            'bg_img'    => config('app.url').'/storage/'.$this->images->bg_img,
            'day_of_display'=> $this->day_of_display,
            // 'thumb_img'     => config('app.url').'/public/storage/'.$this->images->thumb_img,
            // 'bg_img'    => config('app.url').'/public/storage/'.$this->images->bg_img
        ];
    }
}
