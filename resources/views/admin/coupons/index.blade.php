@extends('layouts.app')


@section('title', 'Coupons')

@section('page', 'Coupons')
@section('button')
    <a href="{{ route('coupons.create')}}" class="anchorcss">
        <div class="sidebar-card" >Add Coupon</div>
    </a>
@endsection

@section('content')

    <div class="card mb-4 mlb-4">
        <div class="row">
            <div class="col-lg-12 ">
                @include('layouts.inc.messages')
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <th>Sl.No</th>
                        <th>Title</th>
                        <th>Thumb image</th>
                        <th>Number of coins</th>
                        <th>Created On</th>
                        <th>Valid Date</th>
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
        ajax: "{{ route('coupons.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'thumb_img', name: 'thumb_img', render: function( data, type, full, meta ) {
                        return "<img src=\"" + data + "\" height=\"50\"/>";
                    }
            },
            {data: 'num_coins', name: 'num_coins'},
            {data: 'created_on', name: 'created_on'},
            {data: 'valid_date', name: 'valid_date'},
            {data: 'action', name: 'action', orderable: true, searchable: true
            },
        ] ,
        "fnDrawCallback": function(){
            $('.statrash').on("click",function(){
                $statsID=$(this).data('sid');
                if(confirm('Are you sure want to delete this ?')){
                     $url='{{ route("coupons.destroy",":id") }}';
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
