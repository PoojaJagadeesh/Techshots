@extends('layouts.frontend.app')
@section('title', 'Score')

<!-- Content Wrapper -->
@section('content')
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">



    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
        <div class="align-items-center justify-content-between mb-4">
            <h1 class="homeheading pt-5">Scoreboard</h1>

        </div>
        <div id="transcroller-body" class="rowinfo aos-all" style="overflow-y: hidden !important;">


            @foreach (array_chunk ($data['score'] ,4)  as $infoarr)

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
    <!-- /.container-fluid -->

@endsection
@push('pagescripts')

<script src="{{ asset('dist/aos.js') }}"></script>
<script>
  AOS.init({
    easing: 'ease-in-out-sine'
  });
</script>
@endpush
