@extends('layouts.app')


@section('title', 'Promo Codes')

@section('page', 'Promo Codes')

@section('button')
    <a href="{{ route('promocode.create')}}" class="anchorcss">
        <div class="sidebar-card" >Add Promocode</div>
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
                        <th>Code</th>
                        <th>Validity</th>
                        <th>Reusable</th>
                        <th>Action</th>
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
        var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('promocode.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'code_name', name: 'Title'},
            {data: 'code', name: 'Code'},
            {data: 'validity', name: 'Validity'},
            {data: 'reusable', name: 'Reusable'},
            {data: 'action', name: 'action', orderable: true, searchable: true
            },
        ] ,
         search: {
        "regex": true
    },
        "fnDrawCallback": function(){
            $('.newtrash').on("click",function(){
                $statsID=$(this).data('sid');
                if(confirm('Are you sure want to delete this ?')){
                    $url='{{ route("promocode.destroy",":id") }}';
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

