@extends('layouts.app')


@section('title', 'Infographics')

@section('page', 'Infographics')
@section('button')
    <a href="{{ route('infoGraphics.create')}}" class="anchorcss">
        <div class="sidebar-card" >Add Infographics</div>
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
                                <th>Image</th>
                                <th>Alt Text</th>
                                <th>Action</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('page-scripts')
    <script>
    $(function(){
        var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('infoGraphics.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'img', name: 'img', render: function( data, type, full, meta ) {
                        return "<img src=\"" + data + "\" height=\"50\"/>";
                    }},
            {data: 'alt_text', name: 'alt_text'},
            // {data: 'year', name: 'year'},
            // {data: 'display_year', name: 'display_year'},

            {data: 'action', name: 'action', orderable: true, searchable: true
            },
        ] ,"fnDrawCallback": function(){
            $('.newtrash').on("click",function(){
                $statsID=$(this).data('sid');
                if(confirm('Are you sure want to delete this ?')){
                    $url='{{ route("infoGraphics.destroy",":id") }}';
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

