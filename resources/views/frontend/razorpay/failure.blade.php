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
                 {{-- @if(isset($data['message']))
                <div>
                  <h1>{{ $data['message'] }}</h1>

                </div>
            @endif 
             @if(isset($data['failure']))
                <div>
                  <h2>{{ $data['failure']['description']}}</h2>
                  <h3>Payment ID: {{ $data['meta']['payment_id']}}</h3>
                   <h3>Order ID: {{ $data['meta']['order_id']}}</h3>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection --}}

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
              <h1 class="half_background">Payment Failed
              </h1>
              <p>Oh No! Guess something went wrong, lets try again. for queries or complains feel free to contact our team.</p>
              <div class="support-flex">
               <i class="ti ti-mail"></i>
               <span>support@anxialtech.com</span>
              </div>
              <a href="{{route('userdashboard')}}" class="homelink">Take me home</a>
          </div>
          </div>
          </div>
          <script>
            $(document).ready(function(){
            
        setTimeout(function(){ window.location = {{route('userdashboard')}}; }, 3000);
                });
        
               
        
        </script>
@include('layouts.frontend.footer')

@stack('pagescripts')

</body>
</html>

