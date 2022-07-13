@extends('layouts.app')


@section('title', 'User Activity Log')

@section('page', 'User Activity Log')


@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <a class="btn btn-outline-primary btn-sm float-right" href="{{ route('front-end-users.index')}}">User Lists</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">

                <div class="row mb-3">
                    <div class="col-lg-6 col-md-6  col-sm-6 py-2">
                       <div class="card bg-warning text-white">
                          <div class="card-body bg-warning">
                             <div class="rotate">
                                <i class="fa fa-coins fa-4x"></i>
                             </div>
                             <h6 class="cardh6">{{ __('Remaining Active Coins') }}</h6>
                             <h1 class="display-4">{!! $data['remaining_active_coins'] ?? 0; !!}</h1>
                             {{-- <h2>Total Gifted Coins : {!! $data['coin_gifted']['nums'] ?? 0; !!}</h2>
                             <h2>Total Scratched Coins : {!! $data['coin_scratched']['nums'] ?? 0; !!}</h2> --}}
                          </div>
                       </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 py-2">
                        <div class="row no-gutters">
                        <div class="col-md-12">
                            <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class=""><i class="fa fa-user"></i>&nbsp;{{ __('User Details') }}</h5>
                            </div>
                            <div class="card-body">
                                {{-- <p>Name </p>
                                <p> : </p>
                                <p>{!! isset($data['user_data'])?$data['user_data']['name']:'' !!}</p> --}}


                                <table class="table m-b-0 customer_table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>:</strong></td>
                                            <td class="align-right">{!! isset($data['user_data'])?$data['user_data']['name']:'' !!}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td><strong>:</strong></td>
                                            <td class="align-right">{!! isset($data['user_data'])?$data['user_data']['email']:'' !!}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Premium User ?</strong></td>
                                            <td><strong>:</strong></td>
                                            <td class="align-right">{!! ($data['is_premium']) ? 'Yes':'No' !!}</td>
                                        </tr>
                                        @if($data['is_premium'])
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td><strong>:</strong></td>
                                            <td class="align-right">{!! ($data['premium_status']) ? '<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Expired</span>' !!}</td>
                                        </tr>
                                          @isset($data['premium_type'])
                                           <tr>
                                            <td><strong>Plan Type</strong></td>
                                            <td><strong>:</strong></td>
                                            <td class="align-right">{!! $data['premium_type']['title'] ?? null !!}</td>
                                          </tr>
                                          <tr>
                                            <td><strong>Expire On</strong></td>
                                            <td><strong>:</strong></td>
                                            <td class="align-right">{!! $data['premium_type']->pivot->created_at->addDays($data['premium_type']->allowable_days)->format("F j, Y") !!}</td>
                                          </tr>
                                          @endisset
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>

                 </div>


            </div>
        </div>
    </div>
</div>

 <div class="container">
    <div class="row">
        <div class="col-lg-12 ">
           <h5> User's coin Gains</h5>
        </div>
    </div>
    <div class="row">
    <div class="card col-lg-12 ">

        <div class="card-body">
            <div class="table-responsive">
            <table class="table" id="coin-gain-log" width="100%" cellspacing="0">
                <thead>
                    <th>Sl.No</th>
                    <th>Number Of Coins</th>
                    <th>Type</th>
                    <th>Obtained at</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

</div>


  {{--  <div class="row">
        <div class="col-lg-12 ">
           <h5> User's scratch attempts</h5>
        </div>
    </div>
    <div class="card  mb-4 mlb-4">

        <div class="card-body">
            <div class="table-responsive">
            <table class="table" id="scratch-attempt-log" width="100%" cellspacing="0">
                <thead>
                    <th>Sl.No</th>
                    <th>Gift type</th>
                    <th>Number of coins(If coin if the gift)</th>
                    <th>Title of offer card(If offer is the gift)</th>
                    <th>Is scratched</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div> --}}
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

        var table1 = $('#coin-gain-log').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: "{{ route('front-end-users.premium_user_activity',['uid'=>$data['user_data']['id']]) }}",
            type: "GET",
            data: function (d) {
                d.user_entity = '{!! $data['user_data']['id'] !!}';
            },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nums', name: 'Number of Coins'},
                {data: 'type', name: 'Type'},
                {data: 'created_at', name: 'Created at'},
            ]
        });
     

    });

    </script>
@endpush
