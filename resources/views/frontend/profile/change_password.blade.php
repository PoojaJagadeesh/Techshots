@extends('layouts.frontend.app')
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
          <h1 class="homeheading">Change Password</h1>
          <div class="coinbg">
            <img src="images/coin.svg" alt="">
            <p>1025</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="content">
    <div class="container-fluid">
      <!-- Profile details Starts -->
      <!-- Profile View -->
      <div class="profile-view">
        <div class="profile-desc">
          <div class="img-container">
            <img src="images/person.jpg" alt="">
          </div>
          <p>{{ auth()->user()->name ?? '' }}</p>
          <img src="images/premium.svg" alt="">
        </div>
        <div class="icon-logout">
          <span class="border-logout"></span>
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti ti-logout"></i></a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
          
        </div>
      </div>
      <!-- /Profile View -->
      <div class="user-details">
        <p>Email ID</p>
        <p class="flex-left">{{ auth()->user()->email ?? '' }}</p>
      </div>
      <form method="POST" action={{route('changepassword')}}>
        @csrf
 
  <div class="form-group">
    <input type="password" class="form-control" id="n_password" placeholder="New Password" name="password">
    @if ($errors->has('password'))
    {{ $errors->first('password', ':message') }}
@endif
  </div>
  <div class="form-group">
    <input type="password" class="form-control" id="co_password" placeholder="Confirm Password" name="password_confirmation">
    @if ($errors->has('password_confirmation'))
    {{ $errors->first('password_confirmation', ':message') }}
@endif
  </div>
 
  <button type="submit" class="btn btn-submit">Submit</button>
</form>
      
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->


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

<script>
  function myFunction() {
    var copyText = document.getElementById("linktext");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    
    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copied: " + copyText.value;
  }
  
  function outFunc() {
    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copy to clipboard";
  }
  </script>
  <script>
  $(document).ready(function(){
    $("#coupons").click(function(){
      $("#coupon-display").fadeIn();
      document.getElementById("coupons").style.color="#7A54FC";
      document.getElementById("bookmark").style.color="#718398";
     
    });
    $("#bookmark").click(function(){
      $("#coupon-display").fadeOut();
      document.getElementById("bookmark").style.color="#7A54FC";
      document.getElementById("coupons").style.color="#718398";
    });
  });
  </script>

<script>
{{-- $('.less').on("click", function(){

var id=parseInt($(this).prop("id").split('_')[1]);
$(this).hide();
$('#more_'+id).show();
}); --}}
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

</script>
@endpush