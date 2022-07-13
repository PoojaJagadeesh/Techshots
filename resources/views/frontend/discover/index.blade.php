@extends('layouts.frontend.app')

@section('title', 'Discover')

<!-- Content Wrapper -->
@section('content')

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
  <!-- Main Content -->
  <div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <div>
        <h1 class="homeheading">Discover</h1>
      </div>
      <div class="masonry discover">
@forelse($data['discover'] as $dis)
        <div class="discover-card"><a class="productbuy" @if($dis['link']) href="{{ $dis['link'] }}" target="_blank" @else href="javascript:void(0)" @endif>
          <div class="discover-imgcontainer">
          <img src="{{asset('storage/'.$dis['images']['img'])}}">
          <div class="discover-content">
           <span class="category1">{{$dis['tag']}} </span>
           <p>{{$dis['heading']}}</p>
          </div>
          </div>
        </a>
        </div>
        @empty
        <p>No Discoveries yet</p>
        @endforelse
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->





{{-- <!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
  <!-- Main Content -->
    <div id="content">
    <!-- Begin Page Content -->
        <div class="container-fluid">

      <!-- Page Heading -->
        <div class="align-items-center justify-content-between mb-4">
            <h1 class="homeheading pt-5">Discover</h1>
            </div>
        <div id="transcroller-body" class="rowinfo aos-all" style="overflow-y: hidden !important">


            @foreach (array_chunk ($data['discover'] ,4)  as $disarr)

              <div class="column">
                @foreach ($disarr as $dis)


                <div data-aos="fade-up">

                    <img src="{{asset('storage/'.$dis['images']['img'])}}" style="width:100%">
                </div>

                @endforeach
            </div>
            @endforeach
        </div>





    </div>


</div> --}}

@endsection
@push('pagescripts')

<script src="{{ asset('dist/aos.js') }}"></script>
<script>
  AOS.init({
    easing: 'ease-in-out-sine'
  });
</script>
@endpush
