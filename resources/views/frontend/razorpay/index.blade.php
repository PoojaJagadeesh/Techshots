<!DOCTYPE html>
<html lang="en">

    <head>
        @include('layouts.frontend.header')

    </head>

    <body id="page-top">

        @stack('feedshared')

        <!-- Page Wrapper -->
        <div id="wrapper">

            <div class="premium-bg">
                <div class="premium-content">
                    <img src="{{ asset('images/premium-image.png')}}" alt="">
                    <h1 class="half_background">Get the most from
                    </h1>
                    <h1 class="half_background">techshots.</h1>
                    <div class="premium-particle">

                        <div class="premium-column">
                            <div class="row">
                                @forelse ($data['plans'] as $item)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="@if($item->slug == 'trial-plan') pricing-card @else premium-card @endif">
                                            <h1 class="cardh1">{{ $item->title }}</h1>
                                            <ul>
                                                @php
                                                    $lists = explode(',', $item->description);
                                                @endphp
                                                @forelse ($lists as $list)
                                                <li>{{ str_replace('"','', $list) }}</li>
                                                @empty

                                                @endforelse

                                            </ul>
                                            @if ($item->slug == "premium-plan")
                                                <div class="premium-bill">
                                                    <p>&#8377;{{ $item->price + 300 }}</p>
                                                    <p class="bill price_div">&#8377;{{ $item->price }}</p>
                                                    <p class="bill-month"> /billed month</p>
                                                </div>
                                                @cannot('checkplan','App\Models\User')
                                                    <div class="promo-code">
                                                        <a href="javascript:void(0);">Have a coupon?</a>

                                                        <form action="{{route('applypromo')}}" id="validate_form" method="post">
                                                            @csrf
                                                            <div class="coupon-block">
                                                                {!! Form::hidden('plan', $item->id, []) !!}
                                                                <input type="text" placeholder="Enter Promo Code" name="promocode" id="promocode">
                                                                <button type="submit" class="promo_validate_btn"><i class="ti ti-check"></i></button>
                                                                <p class="error promo_error">
                                                                </p>
                                                                <p class="success promo_success">
                                                                </p>
                                                            </div>
                                                        </form>

                                                    </div>
                                                    {!! Form::open(['route' => 'razorpay.confirm']) !!}
                                                    {!! Form::hidden('plan_id', $item->id, []) !!}
                                                    {!! Form::hidden('name', $item->title, []) !!}
                                                    {!! Form::hidden('price', $item->price, []) !!}
                                                    {!! Form::hidden('validity', $item->allowable_days, []) !!}
                                                    {!! Form::hidden('promo', '', ['id' => 'promo_field']) !!}

                                                    <button class="active-free premiumbg" type="submit">Activate</button>
                                                    {!! Form::close() !!}
                                                @else
                                                <button class="active-free premiumbg" type="button" disabled="disabled">Active</button>
                                                @endcannot

                                            @else
                                                <h1 class="cardh1 text-center marginh1">Free Forever</h1>
                                                <a class="active-free">Active</a>
                                            @endif
                                        </div>
                                    </div>
                                @empty

                                @endforelse




                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <a href="{{route('userdashboard')}}">Maybe Later, Take me home</a>
                        <p>Term and Conditions apply Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et </p>
                      </div>
                </div>
            </div>
            @include('layouts.frontend.footer')
            <script>
                $(document).ready(function(){
                    $(function(){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    });

                    $(document).on('submit', '#validate_form',function(e){
                        e.preventDefault();
                        var data = $(this).serialize()
                        let route = $(this).attr('action')

                        const response = $.post(route, data)

                        response.then( (data) => {
                            console.log(data)
                            $('.promo_error').html('')
                            $('.promo_success').html(data.message)
                            $('.price_div').html('₹'+data.data.amount)
                            $('#promo_field').val(data.data.code)

                        }).catch( (err) => {
                            var error = JSON.parse(err.responseText);
                            // console.log(error)
                            $('.promo_success').html('')
                            $('.promo_error').html(error.message)
                        })
                    })
                })

            </script>
            @stack('pagescripts')

    </body>
</html>
