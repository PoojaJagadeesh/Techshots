<!DOCTYPE html>
<html lang="en">

    <head>
        @include('layouts.frontend.header')
    </head>

    <body id="page-top">

        @stack('feedshared')

        <!-- Page Wrapper -->
        <div id="wrapper">

        <!-- Page Wrapper -->

<div class="notfound-bg">
    <div class="notfound-content">
      <img src="{{asset('images/logo.svg')}}" alt="">
    </div>
    <div class="container">
      <h1 class="half_background">419- Lost in Cyberspace
      </h1>
      <p>It looks like your session expired. Please check the URL and try again. </p>
      <p>you will be automatically redirected to home page in 10s</p>
      <a href="{{route('userdashboard')}}" class="homelink">Take Me home</a>
    </div>

  </div>


  @include('layouts.frontend.footer')
  @stack('pagescripts')

</body>
</html>
