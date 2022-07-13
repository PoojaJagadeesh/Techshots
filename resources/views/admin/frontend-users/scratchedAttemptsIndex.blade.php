@extends('layouts.app')


@section('title', 'Scratched Attempt User Lists')

@section('page', 'Scratched Attempt User Lists')


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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Is Premium User</th>
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
        ajax: "{{ route('front-end-users.scratchindex') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'is_premium', name: 'is_premium'},
            {data: 'action', name: 'action', orderable: true, searchable: true },
        ] ,
        "fnDrawCallback": function(){
        }
    });

    });
    </script>
@endpush
