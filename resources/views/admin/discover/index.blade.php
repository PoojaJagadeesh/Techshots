@extends('layouts.app')


@section('title', 'Discover')

@section('page', 'Discover')
@section('button')
    <a href="{{ route('discover.create')}}" class="anchorcss">
        <div class="sidebar-card" >Add Discover</div>
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
                        <th>Heading</th>
                        <th>Tag</th>
                        <th>Link</th>
                        <th>Image</th>
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
        ajax: "{{ route('discover.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'heading', name: 'heading'},
            {data: 'tag', name: 'tag'},
            {data: 'link_url', name: 'link_url'},
            {data: 'img', name: 'img', render: function( data, type, full, meta ) {
                        return "<img src=\"" + data + "\" height=\"50\"/>";
                    }
            },
            {data: 'action', name: 'action', orderable: true, searchable: true
            },
        ] ,
        "fnDrawCallback": function(){
            $('.statrash').on("click",function(){
                $statsID=$(this).data('sid');
                if(confirm('Are you sure want to delete this ?')){
                     $url='{{ route("discover.destroy",":id") }}';
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
