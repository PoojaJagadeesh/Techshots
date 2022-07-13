@extends('layouts.frontend.app')

@section('title', 'Info')

<!-- Content Wrapper -->
@section('content')


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column info">
  <!-- Main Content -->
  <div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <div>
        <h1 class="homeheading">Infographics</h1>
      </div>
      <!-- Pop Up Image Gallery -->
<div class="lightbox">
  <div class="filter"></div>
  <div class="arrowr"></div>
  <div class="arrowl"></div>
  <div class="closeimg"></div>
</div>
      <section class="masonry">
        @forelse ($data['info'] as $info)

            <img src="{{asset('storage/'.$info['images']['img'])}}">

        @empty
            <p>No Infographics</p>
        @endforelse

    </section>
    </div>

  </div>
  <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->



{{--
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">



    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
        <div class="align-items-center justify-content-between mb-4">
            <h1 class="homeheading pt-5">Infographics</h1>

        </div>
        <div id="transcroller-body" class="rowinfo aos-all" style="overflow-y: hidden !important;">


            @foreach (array_chunk ($data['info'] ,4)  as $infoarr)

              <div class="column">
                @foreach ($infoarr as $info)


                <div data-aos="fade-up">

                    <img src="{{asset('storage/'.$info['images']['img'])}}" style="width:100%">
                </div>

                @endforeach
            </div>
            @endforeach






    </div>



</div>
    <!-- /.container-fluid --> --}}

@endsection
@push('pagescripts')

{{-- <script src="{{ asset('js/aos.js') }}"></script>
<script>
  AOS.init({
    easing: 'ease-in-out-sine'
  });
</script> --}}
@endpush
