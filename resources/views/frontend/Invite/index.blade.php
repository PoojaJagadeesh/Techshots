<!DOCTYPE html>
<html lang="en">

<header>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    {{-- <link rel="shortcut icon" type="images/ico" href="{{ asset('images/favicon.svg')}}"> --}}

    <!-- For Facebook -->
    <meta property="og:title" content="Techshots" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="images/logo.png" />
    <meta property="og:description" content="Techshots helps you to stay updated on tech news and tech events around us in a short time. Invite your friends to Techshots and earn exclusive and exciting rewards. Visit:{{ config('app.url') }}/invite?link={{ request('link') }}" />
    <title>Techshots | Invite</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</header>



<div class="premium-bg">

  <div class="premium-content">
    <img src="images/premium-image.png" alt="">
    <h1 class="half_background">Get the most from
    </h1>
    <h1 class="half_background">techshots.</h1>
    <div class="premium-particle">
      <div class="premium-column">
        <div class="row">

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="premium-card">
              <h3 class="cardh1">{{$data['user']['name']}} is Invited you to join Techsots</h3>
              <ul>
                <li>Limited Ads</li>
                <li>Access on all devices</li>
                <li>Exclusive and High-quality contents</li>
                <li>Explore Unlimited Topics</li>
                <li>Access Exclusive Stories</li>
                <li>Featured Contents</li>
                <li>Stories based on your interests</li>
                <li>Cancel Premium Anytime</li>
              </ul>

              {!! Form::open(['route' => 'premiumlogin']) !!}
              {!! Form::hidden('referal_link', request()->link, []) !!}
              @method('get')
              <button type="submit" class="active-free premiumbg">Join Now</button>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>

<script src="{{ asset('js/userapp.js') }}"></script>

</body>
</html>
