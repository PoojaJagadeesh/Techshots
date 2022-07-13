

 @foreach ($data['news'] as $news)
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 @if($news->is_premium==1) @guest overlay @endguest @auth @can('checkplan','App\\Models\User') less  @endcan @cannot('checkplan','App\\Models\User') overlay @endcannot @endauth @else less @endif" id="less_{{ $news->id }}">

        <div class="story-card">
            @if($news->is_premium==1)
                <div class="premium-icon">
                <img src="{{ asset('images/premium.svg')}}" alt="">
                </div>
            @endif
            <img class="imghome" src="{{ asset('storage/'.$news->images->img) }}" alt="story">
            <p class="storyheadingp ">{{strlen($news->heading) > 75 ? substr($news->heading,0,75)." ..." : $news->heading}}</p>
            <p class="storyp">
                @if ($news->is_premium == 1)
                    {{str_word_count($news->description) > 30 ?  substr($news->description,0,200)." ..." : $news->description }}
                    <a href='javascript:void(0);' class='readmore'>
                        @if(str_word_count($news->description) > 30 ) Readmore @endif
                    </a>
                @else
                    {{str_word_count($news->description) > 60 ?  substr($news->description,0,350)." ..." : $news->description }}
                    <a href='javascript:void(0);' class='readmore'>
                    @if(str_word_count($news->description) > 60 ) Readmore @endif
                    </a>
                @endif

            </p>


            <div class="storyflex">
                <p class="datep">{{ date('d M Y',strtotime($news->display_date)) }}</p>
                <div class="share-bookmark" data-id="{{ $news->id }}" data-user="@guest guest @endguest" @auth data-userid={{ auth()->user()->id }} @endauth>
                    <p class="countspan">{{ $news->claps }}</p>
                    <img src="{{ asset('images/clap.svg')}}" class="claps pointer">
                    <i class="ti ti-share pointer" data-share="{{ config('app.url') }}?id={{ $news->id }}&news=true"></i>
                    <i class="ti ti-bookmark pointer" style="color:@if($news->favourite_flag==1)#ff0000 @else #718398 @endif" id='Path_5'></i>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 more" id="more_{{ $news->id }}" style="display:none">
        <div class="story-card">
            @if($news->is_premium==1)
                <div class="premium-icon">
                <img src="{{ asset('images/premium.svg')}}" alt="">
                </div>
            @endif
            <img class="imghome" src="{{ asset('storage/'.$news->images->img) }}" alt="story">
            <p class="storyheadingp">{{$news->heading}}</p>
            <p class="storyp">{{$news->description }}<a href='javascript:void(0);' class='readless'> Readless</a> </p>

            <div class="storyflex">
            <p class="datep">{{ date('d M Y',strtotime($news->display_date)) }}</p>
            <div class="share-bookmark" data-id="{{ $news->id }}" data-user="@guest guest @endguest" @auth data-userid={{ auth()->user()->id }} @endauth>
                <p class="countspan">{{ $news->claps }}</p>
                <img src="{{ asset('images/clap.svg')}}" class="claps pointer">
                <i class="ti ti-share"></i>
                <i class="ti ti-bookmark" stroke="@if($news->favourite_flag==1)#ff0000 @else #718398 @endif"></i>
            </div>
            </div>
        </div>
    </div>
@endforeach
