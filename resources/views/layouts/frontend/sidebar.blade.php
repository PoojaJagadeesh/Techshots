    <!-- Sidebar -->
    <ul class="navbar-nav sidebar ">
        <!-- Sidebar - Logo -->
        <a class="logo" href="{{ route('userdashboard') }}">
        <img src="{{ asset('images/logo.svg') }}" >
        </a>
        <!-- Menu -->
        <div class="menu-container">
            <a class="sidebar-home bgfeed" href="{{ route('userdashboard') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-home"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Feed</p>
                </div>
            </a>
            <a class="sidebar-home bginfo " href="{{ route('userinfographics') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-chart-bar"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Infographics</p>
                </div>
            </a>
            <a class="sidebar-home bgdisc " href="{{ route('userdiscover') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-compass"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Discover</p>
                </div>
            </a>
            <a class="sidebar-home bgscore " href="{{ route('product') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-building-store"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Store</p>
                </div>
            </a>
            <a class="sidebar-home bgpremium" href="{{ route('premiumarticle') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-star"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Premium</p>
                </div>
            </a>
        </div>
        <div class="sidebar-bottom">
            <!-- Invite Card Starts -->
            <a class="invite-card" href="@if(Auth::user()){{ route('profile') }} @else {{ route('premiumlogin')}} @endif">
                <div class="invite-card-img">
                    <img src="{{ asset('images/invite.svg') }}" alt="">
                </div>
                <div class="invite-friends">
                    <h3>
                        Invite Friends
                    </h3>
                    <p>Exclusive rewards for every invite.</p>
                </div>
            </a>
            <!-- Invite Card Ends -->
            <!-- Premium Badge Starts -->
            @cannot('checkplan','App\Models\User')
            <a class="premium-card" href="@auth{{ route('razorpay') }}@else{{ route('premiumlogin')}}@endauth">
                <div class="premium-card-img">
                    <img src="{{ asset('images/premium-badge.svg') }}" alt="">
                </div>
                <div class="premium-join">
                    <h3>
                        Join Premium
                    </h3>
                    <p>Enjoy Premium Features for less than a coffee !</p>
                </div>
            </a>
            @endcannot
            <!-- Premium Badge Ends -->
             <!-- Term and conditions and Privacy Policy Starts -->
        <div class="term-privacy">
        <a href="{{route('terms')}}">Terms & conditions</a>
        <p>|</p>
        <a href="{{route('privacy')}}">Privacy Policy </a>
        <i class="ti ti-dots-vertical" id="dotsdesk"></i>
        </div>
        </div>

    </ul>
    <!-- End of Sidebar -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="ti ti-x"></i></a>
        <a class="logo" href="{{ route('userdashboard') }}">
        <img src="{{ asset('images/logo.svg') }}" >
        </a>
        <div class="menu-container">
            <a class="sidebar-home bgfeed" href="{{ route('userdashboard') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-home"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Feed</p>
                </div>
            </a>
            <a class="sidebar-home bginfo " href="{{ route('userinfographics') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-chart-bar"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Infographics</p>
                </div>
            </a>
            <a class="sidebar-home bgdisc " href="{{ route('userdiscover') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-compass"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Discover</p>
                </div>
            </a>
            <a class="sidebar-home bgscore " href="{{ route('product') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-building-store"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Store</p>
                </div>
            </a>
            <a class="sidebar-home bgpremium" href="{{ route('premiumarticle') }}">
                <div class="flex-item-leftbtn ">
                    <i class="ti ti-star"></i>
                </div>
                <div class="flex-item-rightbtn ">
                    <p>Premium</p>
                </div>
            </a>
        </div>
        <div class="sidebar-bottom">
            <!-- Invite Card Starts -->
            <a class="invite-card" href="@if(Auth::user()){{ route('profile') }} @else {{ route('premiumlogin')}} @endif">
                <div class="invite-card-img">
                    <img src="{{ asset('images/invite.svg') }}" alt="">
                </div>
                <div class="invite-friends">
                    <h3>
                        Invite Friends
                    </h3>
                    <p>Exclusive rewards for every invite.</p>
                </div>
            </a>
            <!-- Invite Card Ends -->
            <!-- Premium Badge Starts -->
            @cannot('checkplan','App\Models\User')
            <a class="premium-card" href="@if(auth()->user()){{ route('razorpay') }}@else{{ route('premiumlogin')}}@endif">
                <div class="premium-card-img">
                    <img src="{{ asset('images/premium-badge.svg') }}" alt="">
                </div>
                <div class="premium-join">
                    <h3>
                        Join Premium
                    </h3>
                    <p>Enjoy Premium Features for less than a coffee !</p>
                </div>
            </a>
            @endcannot
       <!-- Term and conditions and Privacy Policy Starts -->
    <div class="term-privacy">
        <a href="{{route('terms')}}">Terms & conditions</a>
        <p>|</p>
        <a href="{{route('privacy')}}">Privacy Policy </a>
        <i class="ti ti-dots-vertical" id="dotsmob"></i>
        </div>
        <div class="menulinkmob">
      <ul>
        <li> <a href="{{route('terms')}}">Terms & conditions</a></li>
        <li><a href="{{route('privacy')}}">Privacy Policy </a></li>
        <li><a href="{{route('policy')}}">Refund Policy</a></li>
        
      </ul>
    </div>
      </div>
    </div>
    
    <div class="menulink">
      <ul>
        <li> <a href="{{route('terms')}}">Terms & conditions</a></li>
        <li><a href="{{route('privacy')}}">Privacy Policy </a></li>
        <li><a href="{{route('policy')}}">Refund Policy</a></li>
      </ul>
    </div>
    <div class="mobMenu">
        <span class="menuBtn" onclick="openNav()"><img src="{{ asset('images/mob-menu.svg')}}" alt=""></span>
        <a href="{{route('userdashboard')}}" class="logo"><img src="{{ asset('images/logo-black.svg')}}" alt=""></a>
        <a class="profile-link" href="@if(Auth::user()){{ route('profile') }} @else {{ route('premiumlogin')}} @endif">
            <img src="{{ asset('images/profile-icon.svg')}}" alt="">
        </a>
      </div>
    <!-- Sidebar Profile -->
