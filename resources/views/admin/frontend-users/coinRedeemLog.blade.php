@extends('layouts.app')


@section('title', 'User Activity Log')

@section('page', 'User Activity Log')


@section('content')


<div class="container">
    <div class="row">
        <div class="col-lg-12 ">
           <h5> User's coin reedem log</h5>
        </div>
    </div>
    <div class="row">
    <div class="card  mb-4 mlb-4">

        <div class="card-body">
            <div class="table-responsive">
            <table class="table" id="coin-reedem-log" width="100%" cellspacing="0">
                <thead>
                    <th>Sl.No</th>
                    <th>Coin Reedem Type</th>
                    <th>Number Of Coins Reedemed</th>
                    <th>Coupon Card Title (If reedem as coupon)</th>
                    <th>Reedemed Cash (If reedem as cash)</th>
                    <th>Reedemed at</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>

</div>


    </div>
@endsection
@push('page-scripts')
    <script>
    $(function(){
        $.ajaxSetup({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        var table1 = $('#coin-reedem-log').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: "{{ route('front-end-users.show_coin_reedem_log') }}",
            type: "GET",
            data: function (d) {
                d.uid = '{!! $user->id !!}';
            },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'type', name: 'type'},
                {data: 'coin_nums_reedemed', name: 'coin_nums_reedemed'},
                {data: 'coupon_card_title', name: 'coupon_card_title'},
                {data: 'reedemed_cash', name: 'reedemed_cash'},
                {data: 'reedemed_at', name: 'reedemed_at'},
            ]
        });


    });

    </script>
@endpush
