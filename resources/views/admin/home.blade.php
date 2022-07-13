@extends('layouts.app')

@section('title', 'Dashboard')

@section('page', 'Home')

@section('content')

        <!-- Dashboard -->
    <div class="flex-container">
        <div class="flex-item-left">
            <h1 class="mtp dashheading">Dashboard</h1>
            <p class="pfont">Welcome Back!</p>
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-12">
            <h4 class="quickfont mt-2">Quick stats</h4>
        </div>
    </div>
    <!-- Stats Section -->
    <section>
        <div class="row mlb-4">
            <div class="col-md-3 col-sm-3 col-xl-3 mb-4 mt-4  ">
                <h5 class="bookfont ">Total Users</h5>
                <h1 class="numfont">{{ $data['users'] }}</h1>
            </div>
            <div class="col-md-3 col-sm-3 col-xl-3 mb-4 mt-4 ">
                <h5 class="bookfont ">Pending Approval</h5>
                <h1 class="numfont1">120</h1>
            </div>
            <div class="col-md-3 col-sm-3 col-xl-3 mb-4 mt-4 ">
                <h5 class="bookfont ">Prime Users</h5>
                <h1 class="numfont">
                    {{ count($data['prime']) }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trending-up " width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke=" #2ec114" fill="#2ec114" stroke-linecap="round" stroke-linejoin="round">
                        <path  stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <polyline style="fill: #2ec114;" points="3 17 9 11 13 15 21 7" />
                        <polyline style="fill: #2ec114;" points="14 7 21 7 21 14" />
                    </svg>
                </h1>
            </div>
            <div class="col-md-3 col-sm-3 col-xl-3 mb-4 mt-4 ">
                <h5 class="bookfont ">Total Purchase</h5>
                <h1 class="numfont">
                    46
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trending-up " width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke=" #2ec114" fill="#2ec114" stroke-linecap="round" stroke-linejoin="round">
                        <path  stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <polyline style="fill: #2ec114;" points="3 17 9 11 13 15 21 7" />
                        <polyline style="fill: #2ec114;" points="14 7 21 7 21 14" />
                    </svg>
                </h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Stats Section Ends-->
    <hr>

    <!-- Contacts Section -->
    <section>
        <div class="row">
            <div class="col-lg-12 ">
                <h5 class="sideheading mt-4 mb-4"> Prime Members</h5>
            </div>
        </div>
        <div class="row mlb-4">

            @forelse ($data['prime'] as $item)
            @if($item['plans']!=[])
                <div class="col-md-4 col-sm-4 col-xl-4 mb-3">
                    <img src="http://via.placeholder.com/50" class="rounded-circle float-left">
                    <div class="float-left ptc plc">
                        <h5 class="contactheading ">{{ $item['name'] }}</h5>
                        <p class="contactp mtnc">{{ $item['email'] }}</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-8 col-sm-8 col-xl-8 mb-3">
                    <p class="contactp1 ml-3 mt-3">12 days left</p>
                </div>
                <div class="clearfix"></div>
                @endif
            @empty
                NO Prime users yet.
            @endforelse
        </div>
    </section>
    <!-- Contact Section Ends-->


@endsection
