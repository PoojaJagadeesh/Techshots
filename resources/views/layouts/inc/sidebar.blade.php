

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                <img src="{{ asset('images/logo-black.svg')}}" width="150" class="imgabs">
                </a>
                <a class="nav-link mt-5" href="{{ route('admin.dashboard')}}"  >
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed @if(request()->is('admin/front-end-users/*') || request()->is('admin/front-end-users')) active @endif" href="#" data-toggle="collapse" data-target="#userePages" aria-expanded="false" aria-controls="userePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>

                </a>
                <div class="collapse @if(request()->is('admin/front-end-users/*') || request()->is('admin/front-end-users')) show @endif" id="userePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('front-end-users.index')}}" >
                        Users List
                        </a>
                        <a class="nav-link collapsed" href="{{ route('front-end-users.coinindex')}}" >
                           User Coins
                            </a>
                        <a class="nav-link collapsed" href="{{ route('front-end-users.scratchindex')}}" >
                        Scratch Attempts
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/statusBar/*') || request()->is('admin/statusBar')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar" aria-hidden="true"></i></div>
                    Status Bar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/statusBar/*') || request()->is('admin/statusBar')) show @endif" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('statusBar.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('statusBar.create')}}" >
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/news/*') || request()->is('admin/news')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages1" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="far fa-newspaper"></i></div>
                    News
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/news/*') || request()->is('admin/news')) show @endif" id="collapsePages1" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('news.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('news.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/discover/*') || request()->is('admin/discover')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="far fa-compass"></i></div>
                    Discover
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/discover/*') || request()->is('admin/discover')) show @endif" id="collapsePages2" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('discover.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('discover.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/scoreBoard/*') || request()->is('admin/scoreBoard')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-sort-numeric-up-alt"></i></div>
                    Scoreboard
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/scoreBoard/*') || request()->is('admin/scoreBoard')) show @endif" id="collapsePages3" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('scoreBoard.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('scoreBoard.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/infoGraphics/*') || request()->is('admin/infoGraphics')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                    Infographics
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/InfoGraphics/*') || request()->is('admin/InfoGraphics')) show @endif" id="collapsePages4" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('infoGraphics.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('infoGraphics.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/plans/*') || request()->is('admin/plans')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages5" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="far fa-sticky-note"></i></div>
                    Plans
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/plans/*') || request()->is('admin/plans')) show @endif" id="collapsePages5" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('plans.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('plans.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/coupons/*') || request()->is('admin/coupons')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages6" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-tag"></i></div>
                    Coupons
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/coupons/*') || request()->is('admin/coupons')) show @endif" id="collapsePages6" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('coupons.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('coupons.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/products/*') || request()->is('admin/products')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages7" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                    Product
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/products/*') || request()->is('admin/products')) show @endif" id="collapsePages7" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('products.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('products.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/scratchCard/*') || request()->is('admin/scratchCard')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages8" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                    Scratch Cards
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/scratchCard/*') || request()->is('admin/scratchCard')) show @endif" id="collapsePages8" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('scratchCard.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('scratchCard.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed @if(request()->is('admin/promocode/*') || request()->is('admin/promocode')) active @endif" href="#" data-toggle="collapse" data-target="#collapsePages9" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-tenge"></i></div>
                    Promo Codes
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if(request()->is('admin/promocode/*') || request()->is('admin/promocode')) show @endif" id="collapsePages9" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('promocode.index')}}" >
                        View
                        </a>
                        <a class="nav-link collapsed" href="{{ route('promocode.create')}}">
                        Create
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#bbc5d5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                <path d="M7 12h14l-3 -3m0 6l3 -3" />
            </svg>
            <span class="mlo-4">
                <a href="{{ route('admin.logout') }}" class="text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </span>
        </div>
    </nav>
</div>


