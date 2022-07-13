{{-- @extends('layouts.frontend.app')
<!-- Content Wrapper -->
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
<div class="container">
    <div class="container-fluid">
        <div class="col-md-12">  
            <div class="align-items-center justify-content-between mb-4">
                <h1 class="homeheading pt-5">Premium Subscription</h1><br>
                
                 <div class="card card-default">
                            <div class="card-header">
                              <h4>  Razorpay Techshot </h4>
                            </div>
                            
            @if(isset($data['message']))
                <div>
                  <h3>{{ $data['message'] }}</h3>
     
                </div>
            @endif
              @if(isset($data['plan']))
                <div>
                  <h3>You have successfully subscribed the premium plan for {{ $data['plan']->allowable_days }} days</h3>
     
                </div>
            @endif
 
        </div>
    </div>
</div>
</div>
@endsection --}}
<!DOCTYPE html>
<html lang="en">

    <head>
        @include('layouts.frontend.header')
    </head>

    <body id="page-top">

        @stack('feedshared')

        <!-- Page Wrapper -->
        <div id="wrapper">
<div class="payment-bg">
  <div class="payment-content">
    <img src="{{asset('images/premium-image.png')}}" alt="" class="imgbg">
    <img src="{{asset('images/logo.svg')}}" alt="" class="imglogo">
    <div class="container">
      <h1 class="bgpurchase">Purchase Successful
      </h1>
      <p>You will be redirected to Home in 10s</p>
      <a href="{{route('userdashboard')}}" class="premiumlink">Take me to premium</a>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    window.setTimeout(function () {
        location.href = "{{route('userdashboard')}}";
    }, 5000);

     

</script>
@include('layouts.frontend.footer')

@stack('pagescripts')

</body>
</html>
