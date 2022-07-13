@extends('layouts.frontend.app')

@section('title', 'Home')

<!-- Content Wrapper -->
@section('content')

    <div id="overlay">
        <div id="overtext">
            <button id="close" class="btn btn default btn-sm float-right">Close</button>
            <div class="premium-container" id="text">
                <div class="premium">
                <a href="{{ route('razorpay') }}"> <img src="{{ asset("images/premium.png")}}" class="img-fluidlogo"></a>
                </div>
            </div>
        </div>
    </div>

    @if($data['sharable'])
        @push('feedshared')
            <div class="feed-shared">
                <div class="content-block">
                    <div class="logo"><a href="index.php"><img src="{{asset('images/logo.svg')}}" alt=""></a></div>
                    <div
                        class="story-card
                                @if($data['shared_news']->is_premium==1)
                                    @guest overlay @endguest
                                    @auth
                                        @can('checkplan','App\\Models\User') less
                                        @endcan
                                        @cannot('checkplan','App\\Models\User') overlay
                                        @endcannot
                                    @endauth
                                @else less
                                @endif"
                        id="less_{{ $data['shared_news']->id }}"
                    >
                        <img class="imghome" src="{{ asset('storage/'.$data['shared_news']->images->img) }}" alt="story">
                        <p class="storyheadingp ">{{$data['shared_news']->heading}}</p>
                        <p class="storyp">
                            @if ($data['shared_news']->is_premium == 1)
                                @auth
                                    @can('checkplan','App\\Models\User')
                                        {{ $data['shared_news']->description }}
                                    @elsecan()
                                        {{str_word_count($data['shared_news']->description) > 30 ?  substr($data['shared_news']->description,0,200)." ..." : $data['shared_news']->description }}
                                        @if(str_word_count($data['shared_news']->description) > 30 )
                                            <a href='javascript:void(0);' class='readmore_shared'>
                                                Readmore
                                            </a>
                                        @endif
                                    @endcan
                                @else
                                    {{str_word_count($data['shared_news']->description) > 30 ?  substr($data['shared_news']->description,0,200)." ..." : $data['shared_news']->description }}
                                    @if(str_word_count($data['shared_news']->description) > 30 )
                                        <a href='javascript:void(0);' class='readmore_shared'>
                                            Readmore
                                        </a>
                                    @endif
                                @endauth

                            @else
                                {{str_word_count($data['shared_news']->description) > 60 ?  substr($data['shared_news']->description,0,350)." ..." : $data['shared_news']->description }}
                                @if(str_word_count($data['shared_news']->description) > 60 )
                                    <a href='javascript:void(0);' class='readmore_shared'>
                                        Readmore
                                    </a>
                                @endif
                            @endif

                        </p>
                        <div class="storyflex">
                            <p class="datep">{{ date('d M Y',strtotime($data['shared_news']->display_date)) }}</p>
                        </div>
                    </div>
                </div>

            </div>
        @endpush

    @endif
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column tech-feed">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="feed" >
                    <h1 class="homeheading">Tech Feed</h1>
                    <a class="profile-link" href="@if(Auth::user()){{ route('profile') }} @else {{ route('premiumlogin')}} @endif">
                        <img src="{{ asset('images/profile-icon.svg')}}" alt="">
                    </a>
                </div>
                <!-- Content Row -->
                    <div id="stories" class="storiesWrapper">

                    </div>


                <!-- Color System -->
                <div class="coldiv">
                    <div class="row infinit_Data">

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
                                    <div class="copyTxt"></div>

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
                                            <i class="ti ti-share pointer" data-share="{{ config('app.url') }}?id={{ $news->id }}&news=true"></i>
                                            <i class="ti ti-bookmark pointer" style="color:@if($news->favourite_flag==1)#ff0000 @else #718398 @endif" id='Path_5'></i>
                                        </div>
                                        <div class="clear"></div>
                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                    <div class="ajax-load text-center" style="display:none">
                        <p><img src="">Loading More News...</p>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->




    <div id="msg">
    </div>
@endsection



@push('pagescripts')

    <style>
         .copyOverlay {
            position: fixed;
            top: 33px;
            z-index: 10;
            left: 50%;
            background: rgba(0,0,0,0.8);
            padding: 10px 40px;
            border-radius: 5px;
            color: #fff;
        }
        .copyTxt {
            text-align: right;
            margin-right: 37px;
        }
    </style>


    <script>

         $.ajax({
            type:'GET',
            url:'{{ route('getstatus') }}',

            success:function(data){
                var url = window.location.origin;
                if(data.status=="success"){
                    var itemdata = [];
                    $.each(data.stories, function( key, value ) {
                            var obj = {};
                            obj = Zuck.buildTimelineItem(
                                        "item"+key,url+"/storage/"+value.images.thumb_img,value.heading,"",timestamp(),[[value.year,"5","",url+"/storage/"+value.images.bg_img,"3",url+"/storage/"+value.images.bg_img, false,
                                        false,
                                        timestamp(),]]
                                    );
                            itemdata.push(obj);
                    });
                        console.log(itemdata)

                    var currentSkin = getCurrentSkin();
                    var stories = new Zuck("stories", {
                        backNative: true,
                        previousTap: true,
                        skin: currentSkin["name"],
                        autoFullScreen: currentSkin["params"]["autoFullScreen"],
                        avatars: currentSkin["params"]["avatars"],
                        paginationArrows: currentSkin["params"]["paginationArrows"],
                        list: currentSkin["params"]["list"],
                        cubeEffect: currentSkin["params"]["cubeEffect"],
                        localStorage: true,
                        stories: itemdata,
                    });

                    var elem = $('#stories');
                    var items = elem.children();
                    // console.log(status)
                    // Inserting Buttons
                    elem.prepend(
                        '<div id="right-button" style="visibility: hidden;"><a href="javascript:void(0);"><img src="images/prev.svg"></a></div>'
                    );
                    elem.append('<div id="left-button"><a href="javascript:void(0);"><img src="images/next.svg"></a></div>');
                    // Inserting Inner
                    items.wrapAll('<div id="inner" />');
                    // Inserting Outer
                    // debugger;
                    elem.find("#inner").wrap('<div id="outer"/>');

                    var outer = $("#outer");

                    var setInvisible = function (elem) {
                        elem.css("visibility", "hidden");
                    };
                    var setVisible = function (elem) {
                        elem.css("visibility", "visible");
                    };


                    var updateUI = function () {
                        var maxWidth = outer.outerWidth(true);
                        var actualWidth = 0;
                        $.each($("#inner >"), function (i, item) {
                            actualWidth += $(item).outerWidth(true);
                        });
                        if (actualWidth <= maxWidth) {
                            setVisible($("#left-button"));
                        }
                    };

                    updateUI();

                    $("#right-button").click(function () {
                        var leftPos = outer.scrollLeft();
                        outer.animate({
                                scrollLeft: leftPos - 200,
                            },
                            800,
                            function () {
                                debugger;
                                if ($("#outer").scrollLeft() <= 0) {
                                    setInvisible($("#right-button"));
                                }
                            }
                        );
                    });
                    $("#left-button").click(function () {
                        setVisible($("#right-button"));
                        var leftPos = outer.scrollLeft();
                        outer.animate({
                                scrollLeft: leftPos + 200,
                            },
                            800
                        );
                    });
                    $(window).resize(function () {
                        updateUI();
                    });


                }
            }
        });



        $(document).on("click",'.ti-bookmark', function(){
            var div=$(this).parent();
            //$('#Path_5').attr("stroke","#ff0000");
            if(div.data("user")==" guest "){
            window.location.href = '{{route('premiumlogin')}}';
            }
            if(div.data("user")!=" guest ")
            {
                $.ajax({
                    type:'POST',
                    url:'{{ route('addfav') }}',
                    data:{"news_id":div.data("id")},
                    success:function(data){
                        console.log(data)
                        if(data.status==1){
                            div.find('#Path_5').attr("style","color:#ff0000");
                            $('#msg').html("<div class='copyOverlay'>Bookmarked</div>");
                            setTimeout(function(){
                                $('.copyOverlay').remove();
                            }, 3000);
                        }else{
                            // $('.copyTxt').html('Bookmarked').fadeOut(400);
                            div.find('#Path_5').attr("style","color:#718398");
                        }
                    }
                });
            }

        });

        $(document).on("click",'.ti-share', function(){
            var link = $(this).data('share');
            console.log(link)
            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', link);
                e.preventDefault();
            }, true);

            if(document.execCommand('copy')){
                $('#msg').html("<div class='copyOverlay'>Copied</div>");
            }
            setTimeout(function(){
                $('.copyOverlay').remove();
            }, 3000);
        });

        // $('.readmore_shared').on("click", function(){
        //     $div=$(this).parent().parent();
        //     console.log($div)
        //     if($div.hasClass('less')){
        //         var id=parseInt($div.prop("id").split('_')[1]);
        //         $div.hide();
        //         $('#more_share'+id).show();
        //     }
        // });


        $('.readmore').on("click", function(){
            $div=$(this).parent().parent().parent();
            console.log($div)
            if($div.hasClass('less')){
                var id=parseInt($div.prop("id").split('_')[1]);
                $div.hide();
                $('#more_'+id).show();
            }
        });

        $(document).on('click','.overlay', function(){
            $("#overlay").show();
        });

        $('.readless').on("click", function(){
            $div=$(this).parent().parent().parent();
            var id=parseInt($div.prop("id").split('_')[1]);
            $div.hide();
            $('#less_'+id).show();
        });

        $('#overlay').on('click', function(){
            $('#overlay').hide();
        })

        $('#close').on('click', function(){
            $('#overlay').hide();
        })

        function abbrNum(number, decPlaces) {
            // 2 decimal places => 100, 3 => 1000, etc
            decPlaces = Math.pow(10,decPlaces);
            // Enumerate number abbreviations
            var abbrev = [ "k", "m", "b", "t" ];
            // Go through the array backwards, so we do the largest first
            for (var i=abbrev.length-1; i>=0; i--) {
                // Convert array index to "1000", "1000000", etc
                var size = Math.pow(10,(i+1)*3);
                // If the number is bigger or equal do the abbreviation
                if(size <= number) {
                    // Here, we multiply by decPlaces, round, and then divide by decPlaces.
                    // This gives us nice rounding to a particular decimal place.
                    number = Math.round(number*decPlaces/size)/decPlaces;
                    // Handle special case where we round up to the next abbreviation
                    if((number == 1000) && (i < abbrev.length - 1)) {
                        number = 1;
                        i++;
                    }
                    // Add the letter for the abbreviation
                    number += abbrev[i];
                    // We are done... stop
                    break;
                }
            }
            return number;
        }

        $(document).on('click','.claps', function(){
            $div=$(this).parent();
            var i = $div.find('.countspan').html();
            $div.find('.countspan').html(Number(i) + 1);
            $div.find('img').attr('src', "{{ asset('images/clap-after.svg')}}");
                $.ajax({
                    type:'GET',
                    url:'{{ route('clapping') }}',
                    data:{"id":$div.data("id")},
                    success:function(data){
                        // $div.find('.countspan').html(abbrNum(data.count,2));
                        // $div.find('img').attr('src', "{{ asset('images/clap-after.svg')}}");
                    }
                });
        })



        // infinite scroll

        var page = 1;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                page++;
                loadMoreData(page);
            }
        });


        function loadMoreData(page){
        $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data)
                {
                    if(data.html === ""){
                        $('.ajax-load').html("No more records found");
                        return;
                    }
                    $('.ajax-load').hide();
                    $(".infinit_Data").append(data.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    alert('server not responding...');
                });
        }

    </script>

@endpush
