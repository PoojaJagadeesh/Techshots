<!DOCTYPE html>
<html lang="en">

    <head>
        @include('layouts.frontend.header')
    </head>

    <body id="page-top">

        @stack('feedshared')

        <!-- Page Wrapper -->
        <div id="wrapper">

            <div class="premium-bg review-plan">
                <div class="premium-content">
                  <img src="images/premium-image.png" alt="">
                  <h1 class="half_background">Lets confirm your</h1>
                  <h1 class="half_background">purchase.</h1>
                  <div class="premium-particle">
                    <div class="premium-column">
                                <div class="premium-card">
                                    <h1 class="cardh1">{{ $data['plan']->title }}</h1>
                                    <ul>
                                        <li>Unlimited Tech Stories & Updates </li>
                                        <li>Limited Ads</li>
                                        <li>Access on all devices</li>
                                        <li>Exclusive and High-quality contents</li>
                                        <li>Explore Unlimited Topics</li>
                                        <li>Access Exclusive Stories</li>
                                        <li>Featured Contents</li>
                                        <li>Stories based on your interests</li>
                                        <li>Cancel Premium Anytime</li>
                                    </ul>
                                    <div class="premium-bill">
                                        <p>&#8377;{{ $data['plan']->price + 300 }}</p>
                                        <p class="bill">&#8377;{{ $data['plan']->price }}</p>
                                        <p class="bill-month"> /billed month</p>
                                    </div>
                                    @if($data['promo_code']!=null)
                                    <div class="promo-code">
                                        <p>Coupon Code Applied</p>
                                        <span class="code">{{$data['promo_code']}}</span>
                                      </div>
                                      @endif
                                    {{-- @dd(config('services.razorpay')) --}}
                                    <form method="POST" action="https://api.razorpay.com/v1/checkout/embedded">
                                        <input type="hidden" name="key_id" value="{{ config('services.razorpay')['api_key'] }}">
                                        <input type="hidden" name="order_id" value="{{ $data['order']->id }}">
                                        <input type="hidden" name="name" value="Techshots">
                                        <input type="hidden" name="description" value="">
                                        <input type="hidden" name="image" value="{{ asset('images/newllogo.jpg') }}">
                                        <input type="hidden" name="prefill[name]" value="{{ $data['user']->name }}">
                                        <input type="hidden" name="prefill[contact]" value="{{ $data['user']->phone ?? '000000000000' }}">
                                        <input type="hidden" name="prefill[email]" value="{{ $data['user']->email }}">
                                        <input type="hidden" name="notes[plan]" value="{{ $data['plan']->id }}">
                                        <input type="hidden" name="notes[user_id]" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="callback_url" value="{{ route('payment') }}">
                                        <input type="hidden" name="cancel_url" value="{{ route('razorpay') }}">
                                        <button class="active-free premiumbg" type="submit">Confirm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    
                        <div class="footer">
                          <a href="{{route('userdashboard')}}">Maybe Later, Take me home</a>
                          <p>Term and Conditions apply Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et </p>
                        </div>
                      </div>
                    </div>
    </body>
</html>
