@extends('layouts.app')


@section('title', 'User Lists')

@section('page', 'User Lists')


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
        ajax: "{{ route('front-end-users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'is_premium', name: 'is_premium'},
            {data: 'action', name: 'action', orderable: true, searchable: true },
        ] ,
        "fnDrawCallback": function(){
            $('.activation_toggle').on("click",function(){
                var act=($(this).prop('checked') === true ? 1:0);
                var uID=$(this).data('sid');
                if(confirm('Do you want to inactivate this user ?')){
                    $url='{{ route("front-end-users.inactivate",":uid") }}';
                    $url=$url.replace(':uid',uID);
                    $.ajax({
                        'url':$url,
                        'type':'POST',
                        'data':{ 'uid':uID,'status':act ,'_token':'{{ csrf_token() }}'},
                        'dataType':'JSON',
                        success: function(reponse){
                         if(reponse.status === 'success')
                         table.draw();
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });

            $('.statrash').on("click",function(){
                $statsID=$(this).data('sid');
                if(confirm('Are you sure want to delete this ?')){
                     $url='{{ route("front-end-users.destroy",":id") }}';
                    $url=$url.replace(':id',$statsID);
                    $.ajax({
                        'url':$url,
                        'type':'DELETE',
                        'data':{ 'statsid':$statsID, '_token':'{{ csrf_token() }}' },
                        'dataType':'JSON',
                        success: function(reponse){
                         if(reponse.status === 'success')
                         table.draw();
                        },
                        error: function (xhr) {
                         console.log(xhr.responseText);
                        }
                    });
                }

            });
        },
    });

    });
    </script>
@endpush
