@extends('layouts.app')


@section('title', 'Plans')

@section('page', 'Plans')

@section('button')
    <a href="{{ route('plans.create')}}" class="anchorcss">
        <div class="sidebar-card" >Add Plan</div>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 ">
            @include('layouts.inc.messages')
        </div>
    </div>

    <div class="card mb-4 mlb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <th>Sl.No</th>
                        <th>Title</th>
                        <th>Allowable Days</th>
                        <th>Price($)</th>
                        <th>Action</th>
                    </thead>
                    <tbody></tbody>
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
        var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('plans.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'allowable_days', name: 'allowable_days'},
            {data: 'price', name: 'price'},
            {data: 'action', name: 'action', orderable: true, searchable: true
            },
        ] ,
        "fnDrawCallback": function(){
        },
    });
    });
    </script>
@endpush
