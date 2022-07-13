@extends('layouts.app')


@section('title', 'User Activity Log')

@section('page', 'User Activity Log')


@section('content')
<div class="container">


    <div class="row">
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


        var table2 = $('#scratch-attempt-log').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url: "{{ route('front-end-users.show_scratch_attempts') }}",
        type: "GET",
        data: function (d) {
                d.user_entity = '{!! $data['user_data']['id'] !!}';
            },
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'gift_type', name: 'gift_type'},
            {data: 'coin_nums', name: 'coin_nums'},
            {data: 'offer_title', name: 'offer_title'},
            {data: 'is_scratched', name: 'is_scratched'},
        ]
        });

    });

    </script>
@endpush
