<?php

namespace App\Traits;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;

trait ShareableTrait
{
    public function getShareUrl($type = 'link',$id="",$premium=false)
    {

        // $url = $this->{Arr::get($this->shareOptions, 'url')} ? $this->{Arr::get($this->shareOptions, '')} : url()->current();
        $url    = route('newslink',$id);

          //  $url.='?code'.auth()->user()->user_link->link;

        //$url.='?code='+auth()->user()->
        if ($type == 'facebook') {
            $query = urldecode(http_build_query([
                // 'app_id' => env('FACEBOOK_APP_ID'),
                'href' => $url,
                'display' => 'page',
                'title' => urlencode($this->{Arr::get($this->shareOptions, 'columns.title')})
            ]));

            return 'https://www.facebook.com/dialog/share?' . $query;
        }

        if ($type == 'twitter') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'text' => urlencode(Str::limit($this->{Arr::get($this->shareOptions, 'columns.title')}, 120))
            ]));

            return 'https://twitter.com/intent/tweet?' . $query;
        }

        if ($type == 'whatsapp') {
            $query = urldecode(http_build_query([
                'text' => urlencode($this->{Arr::get($this->shareOptions, 'columns.title')} . ' ' . $url)
            ]));

            return 'https://wa.me/?' . $query;
        }

        if ($type == 'linkedin') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'summary' => urlencode($this->{Arr::get($this->shareOptions, 'columns.title')})
            ]));

            return 'https://www.linkedin.com/shareArticle?mini=true&' . $query;
        }

        if ($type == 'pinterest') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'description' => urlencode($this->{Arr::get($this->shareOptions, 'columns.title')})
            ]));

            return 'https://pinterest.com/pin/create/button/?media=&' . $query;
        }

        if ($type == 'google') {
            $query = urldecode(http_build_query([
                'url' => $url,
            ]));

            return 'https://plus.google.com/share?' . $query;
        }
        if($type=='link'){

            // $query = urldecode(http_build_query([
            //     'url' => $url.'/'.$id,
            // ]));
            $url=URL::to('/');

            if($id!=""){
            $url    .= '?id='.$id.'&news=true';
           // $url.='?code='.auth()->user()->user_link->link;
            if($premium){
                $url.='&premium=true';
            }

        }
        // }else{
        //    // $url='?code='.auth()->user()->user_link->link;
        // }
             return $url;

        }
    }
}
