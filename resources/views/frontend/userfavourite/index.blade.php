@extends('layouts.frontend.app')
<!-- Content Wrapper -->


@section('content')
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column tech-feed">
  <!-- Main Content -->
  <div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="feed" >
        <h1 class="homeheading">Bookmarked News</h1>
        <a class="profile-link" href="@if(Auth::user()){{ route('profile') }} @else {{ route('premiumlogin')}} @endif">
          <img src="{{ asset('images/profile-icon.svg')}}" alt="">
        </a>
      </div>
      <!-- Content Row -->
     
      
      <!-- Color System -->
      <div class="coldiv">
      <div class="row ">
       
     
  
        @forelse ($data['news'] as $news)
          
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 @if($news->is_premium==1) @guest overlay @endguest @auth @can('checkplan','App\\Models\User') less  @endcan @cannot('checkplan','App\\Models\User') overlay @endcannot @endauth @else less @endif" id="less_{{ $news->id }}">
          <div class="story-card">
            @if($news->is_premium==1)
            <div class="premium-icon">
              <img src="{{ asset('images/premium.svg')}}" alt="">
            </div>
            @endif
            <img class="imghome" src="{{ asset('storage/'.$news->images->img) }}" alt="story">
            <p class="storyheadingp ">{{strlen($news->heading) > 75 ? substr($news->heading,0,75)." ..." : $news->heading}}</p>
            <p class="storyp">{{strlen($news->description) > 150 ?  substr($news->description,0,150)." ..." : $news->description }} <a href='javascript:void(0);' class='readmore'> Readmore</a></p>


            <div class="storyflex">
              <p class="datep">{{ date('d M Y',strtotime($news->display_date)) }}</p>
              <div class="share-bookmark" data-id="{{ $news->id }}" data-user="@guest guest @endguest" @auth data-userid={{ auth()->user()->id }} @endauth>
                <p class="countspan">{{ $news->claps }}</p>
                <img src="{{ asset('images/clap.svg')}}" class="claps">
                <i class="ti ti-share"></i>
                <i class="ti ti-bookmark" style="color:@if($news->favourite_flag==1)#ff0000 @else #718398 @endif" id='Path_5'></i>
              </div>
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
                <img src="{{ asset('images/clap.svg')}}" class="claps">
                <i class="ti ti-share"></i>
                <i class="ti ti-bookmark" style="color:@if($news->favourite_flag==1)#ff0000 @else #718398 @endif" id='Path_5'></i>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="placeholder-text">
          <span><i class="ti ti-mood-sad"></i></span>
          <p>No Favourite news.</p>
        </div>
        @endforelse
       <div id="overlay">
        <div id="overtext"> 
          <button id="close" class="btn btn default btn-sm float-right">Close</button>
          <div class="premium-container" id="text">
            <div class="premium">
              <a href="@if(auth()->user()){{ route('razorpay') }}@else{{ route('premiumlogin')}}@endif"> <img src="{{ asset("images/premium.png")}}" class="img-fluidlogo"></a>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
@endsection
@push('pagescripts')
<style>
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
  {{-- <script>
          
    $.ajax({
        type:'GET',
        url:'{{ route('getstatus') }}',
       
        success:function(data){
           var url = window.location.origin;
          // console.log();
         
          if(data.status=="success"){
         
           var arr=[];
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
  stories: arr,
  }); 
         $.each(data.stories, function( key, value ) { 
  
  $.each(value, function(k,v){
  var obj = {};  
  obj=Zuck.buildTimelineItem(
  key,url+'/storage/'+v.images['thumb_img'],key,"",timestamp(),[[key+k,"photo","3",url+'/storage/'+v.images['bg_img'], false,
        false,
        timestamp(),]]
  ); 
  arr.push(obj);
  
  
  })
  
  });
  stories.update(arr);
  
  }
        }
        }); 
  
  
  </script> --}}
  <script>
     $(function() {
      var print = function(msg) {
        alert(msg);
      };
      var setInvisible = function(elem) {
        elem.css("visibility", "hidden");
      };
      var setVisible = function(elem) {
        elem.css("visibility", "visible");
      };
      var elem = $("#stories");
      var items = elem.children();
      // Inserting Buttons
      elem.prepend(
        '<div id="right-button" style="visibility: hidden;"><a href="javascript:void(0);"><img src="images/prev.svg"></a></div>'
      );
      elem.append('  <div id="left-button"><a href="javascript:void(0);"><img src="images/next.svg"></a></div>');
      // Inserting Inner
      items.wrapAll('<div id="inner" />');
      // Inserting Outer
      // debugger;
      elem.find("#inner").wrap('<div id="outer"/>');
      var outer = $("#outer");
      var updateUI = function() {
        var maxWidth = outer.outerWidth(true);
        var actualWidth = 0;
        $.each($("#inner >"), function(i, item) {
          actualWidth += $(item).outerWidth(true);
        });
        if (actualWidth <= maxWidth) {
          setVisible($("#left-button"));
        }
      };
      updateUI();
      $("#right-button").click(function() {
        var leftPos = outer.scrollLeft();
        outer.animate({
            scrollLeft: leftPos - 200,
          },
          800,
          function() {
            debugger;
            if ($("#outer").scrollLeft() <= 0) {
              setInvisible($("#right-button"));
            }
          }
        );
      });
      $("#left-button").click(function() {
        setVisible($("#right-button"));
        var leftPos = outer.scrollLeft();
        outer.animate({
            scrollLeft: leftPos + 200,
          },
          800
        );
      });
      $(window).resize(function() {
        updateUI();
      });
    });
  </script>
       
  <script>
   $('.ti-bookmark').on("click", function(){
  var div=$(this).parent();
  var h=div.parent().parent().parent();
  console.log(div.parent().parent().parent());
  if(div.data("user")==" guest "){
          window.location.href = '{{route('premiumlogin')}}';
        }
  
  //$('#Path_5').attr("stroke","#ff0000");
  
  if(div.data("user")!=" guest "){
   
                      $.ajax({
                          type:'POST',
                          url:'{{ route('addfav') }}',
                         data:{"news_id":div.data("id")},
                          success:function(data){
                            console.log(data)
                            if(data.status==1){
                        div.find('#Path_5').attr("style","color:#ff0000");
                    }else{
                        div.find('#Path_5').attr("style","color:#718398");
                    }
                    h.hide();
                          }
                     
                
                          });
  
  }
  
  }); 
   $('.ti-share').on("click", function(){
   
  var div=$(this).parent();
  console.log(div);
  
  //$('#Path_5').attr("stroke","#ff0000");
  
  if(div.data("user")!="guest"){
    
                       
                      $.ajax({
                          type:'POST',
                          url:'{{ route('share') }}',
                         data:{"id":div.data("id"),"type":"link"},
                          success:function(data){
                            console.log(data)
                          // window.location.href =data.link;
                          }
                          });
  
  }
  
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
  
  $('.claps').on('click', function(){
  $div=$(this).parent();
  
                    
                      $.ajax({
                          type:'GET',
                          url:'{{ route('clapping') }}',
                         data:{"id":$div.data("id")},
                          success:function(data){
                            console.log(data)
                          $div.find('.countspan').html(abbrNum(data.count,2));
                          $div.find('img').attr('src', "{{ asset('images/clap-after.svg')}}");
                          }
                          });
  
  })
  </script>
  @endpush