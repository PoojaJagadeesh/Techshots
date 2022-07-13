@extends('layouts.frontend.app')

@section('title', 'Profile')
<!-- Content Wrapper -->
@section('content')
<div id="content-wrapper" class="d-flex flex-column profile-content">
	<!-- Main Content -->
	<!-- Begin Page Content -->
	<!-- Page Heading -->
	<div class="profile">
		<div id="content">
			<div class="container-fluid">
				<div class="profile-details">
					<h1 class="homeheading">Profile</h1>
					<div class="coinbg">
						<img src="images/coin.svg" alt="">
						<p>{{ $data['coin'] }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="content">
		<div class="container-fluid">
			<!-- Profile details Starts -->
			@if(Auth::user())
			<!-- Profile View -->
			<div class="profile-view">
				<div class="profile-desc">
					<div class="img-container">
						<img src="{{(Auth::user() && Auth::user()->profileImage) ? asset('storage/'.Auth::user()->profileImage()->img):'https://via.placeholder.com/50'}}" alt="">
					</div>
					<p>{{ auth()->user()->name ?? '' }}  </p>
					@can('checkplan','App\Models\User')
					<img src="images/premium.svg" alt="">
					@endcan
				</div>
				<div class="icon-logout">
					<span class="border-logout"></span>
					<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti ti-logout"></i></a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</div>
			</div>
			@else
			<div class="profile-view">
				<div class="profile-desc">
					<div class="img-container">
						<img src="https://via.placeholder.com/50" alt="">
					</div>
					<p>Guest </p>
					@can('checkplan','App\Models\User')
					<img src="images/premium.svg" alt="">
					@endcan
				</div>
			</div>
			@endif
			<!-- /Profile View -->
			<div class="user-details">
				<p>Email ID</p>
				<p class="flex-left">{{ auth()->user()->email ?? '' }}</p>
			</div>
			<div class="user-details">
				<p>Password</p>
				<a class="flex-left" href="{{route('changepasswordshow')}}">Change Password</a>
			</div>

			<div class="user-details mbuser">


				<p>Invite Your Friend</p>
				@if(isset($data['invite_link']))

                    @php
                        $link = urlencode($data['invite_link']);
                    @endphp
				<div class="social-media flex-left">
					<a href="https://www.facebook.com/sharer/sharer.php?u={{ $link }}&t=Techshots helps you to stay updated on tech news and tech events around us in a short time. Invite your friends to Techshots and earn exclusive and exciting rewards. Visit:{{ $data['invite_link'] }}" target="_blank" title="Share on Facebook" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,
					scrollbars=yes,height=600,width=600');return false;">
					<img src="images/facebook.svg" alt=""></a>

					<a href="https://twitter.com/share?url={{ $data['invite_link'] }}/&text=Techshots helps you to stay updated on tech news and tech events around us in a short time. Invite your friends to Techshots and earn exclusive and exciting rewards. Visit:" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,
						height=300,width=600');return false;" target="_blank" title="Share on Twitter">
					<img src="images/twitter.svg" alt="">
					</a>
					<div class="tooltipcopy">
						<i class="ti ti-copy" id="linktext" data-link="{{ $data['invite_link'] }}" onclick="myFunction()" onmouseout="outFunc()"></i>
						<span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
					</div>
				</div>
				@endif
			</div>

			<div class="user-link">
				<a class="selected" id="invites">Invites</a>
				<a id="bookmarks" >Bookmarks</a>
				<a id="coupons">Coupons</a>
			</div>
				<div id="inviteList">
					@forelse($data['refered'] as $ref)
						<div class="invite-list-row">
				  			<div class="name">{{$ref->name}}
								@if($ref->checkPrime()->count() > 0)
                                    <span class="premium-icon">
                                        <img src="{{ asset('images/premium.svg')}}" alt="">
                                    </span>
								@endif
							</div>
				  			<div class="email">{{$ref->email}}</div>
						</div>

				@empty
				<div class="placeholder-text">
					<span><i class="ti ti-mood-sad"></i></span>
					<p>No Invited Users</p>
				  </div>
				@endforelse
			</div>


			<div id="bookmarkList">
				<div class="row">
			@forelse ($data['fav_news'] as $news)

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

			@empty
			<div class="placeholder-text">
			  <span><i class="ti ti-mood-sad"></i></span>
			  <p>No Favourite news.</p>
			</div>
			@endforelse
		</div>
	</div>
			<div id="coupon-display">
				Scratched Cards
				<div class="row">

					@forelse ($data['scratch_card'] as $card)
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="coupon">
							<div class="coupon-img">
								<img src="{{ $card->card_info['offer_thumb_img'] }}" alt="">
							</div>
							<p>{{ $card->card_info['offer_title'] }}</p>
							<div class="coupon-code">{{ $card->card_info['offer_code'] }}</div>
						</div>
					</div>
					@empty
					<div class="placeholder-text">
						<span><i class="ti ti-mood-sad"></i></span>
						<p>No Scratched Cards</p>
					  </div>
					@endforelse
				</div>

				Coupons


				@forelse ($data['coupon'] as $card)
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="coupon">
						<div class="coupon-img">
							<img src="{{$card['thumb_img']}}" alt="">
						</div>
						<p>{{ $card['title'] }}</p>
						<div class="coupon-code">{{ $card['offer_code'] }}</div>
					</div>
				</div>
				@empty
				<div class="placeholder-text">
					<span><i class="ti ti-mood-sad"></i></span>
					<p>No Coupons</p>
				  </div>
				@endforelse
			</div>
			</div>
		</div>
	</div>
		<!-- /.container-fluid -->
	</div>
	<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
@endsection

@push('pagescripts')
    <style>
      .ti.ti-copy{
          cursor: pointer;
      }
      #overlay {
        position: fixed; /* Sit on top of the page content */
        display: none; /* Hidden by default */
        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.9
        ); /* Black background with opacity */
        z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer; /* Add a pointer on hover */
        }
        #text{
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 50px;
        color: white;
        transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        }
    </style>
    <script>
        function myFunction() {
            var copyText = "Techshots helps you to stay updated on tech news and tech events around us in a short time.\nvisit: "+$('#linktext').data('link')+".\nInvite your friends to Techshots and earn exclusive and exciting rewards";
            // console.log(copyText)
            document.addEventListener('copy', function(e) {
                e.preventDefault();
                e.clipboardData.setData('text/plain', copyText);
            }, true);

            document.execCommand('copy');
            // console.log('copied text : ', copyText);

            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copied";
        }

        function outFunc() {
            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copy to clipboard";
        }


        $(document).ready(function(){


			$("#coupons").click(function() {
                $("#inviteList").fadeOut();
                $("#bookmarkList").fadeOut();
                $("#coupon-display").fadeIn();
                $(this).addClass("selected");
                $(".user-link a").not(this).removeClass("selected");

            });
            $("#bookmarks").click(function() {
                $("#coupon-display").fadeOut();
                $("#inviteList").fadeOut();
                $("#bookmarkList").fadeIn();
                $(this).addClass("selected");
                $(".user-link a").not(this).removeClass("selected");
            });
            $("#invites").click(function() {
                $("#coupon-display").fadeOut();
                $("#bookmarkList").fadeOut();
                $("#inviteList").fadeIn();
                $(this).addClass("selected");
                $(".user-link a").not(this).removeClass("selected");
            });


            $('.less').on("click", function(){

                var id=parseInt($(this).prop("id").split('_')[1]);
                $(this).hide();
                $('#more_'+id).show();
            });

            $('.readmore').on("click", function(){

                $div=$(this).parent().parent().parent();

                if($div.hasClass('less')){
                    var id=parseInt($div.prop("id").split('_')[1]);
                    $div.hide();
                    $('#more_'+id).show();
                }
            });

            $('.overlay').on("click", function(){

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
        });

    </script>
@endpush
