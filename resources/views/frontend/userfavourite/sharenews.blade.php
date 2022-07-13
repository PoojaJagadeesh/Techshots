@extends('layouts.frontend.app')
<!-- Content Wrapper -->
@section('content')

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column premium-news">
  <!-- Main Content -->
  <div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
      @if (isset($_GET['premium'])) 
      @can('checkplan','App\\Models\User')
      <!-- Page Heading -->
      <div class="main-news">
        <h1 class="homeheading">{{ $data['news']->heading }}</h1>
        <p class="news-heading">Premium News</p>
        <div class="premium-share">
          <p class="sharep">5min Read</p>
          <div class="shareicons">
            <p>1.2k</p>
            <img src="images/clap-after.svg" alt="">
            <i class="ti ti-share"></i>
            <i class="ti ti-bookmark"></i>
          </div>
        </div>
        <div class="premium-news-img">
          <img src="{{ asset('storage/'.$data['news']->images->img) }}" alt="">
        </div>
        <div class="premium-newsp">
        <p>
          {{($data['news']->description)? $data['news']->description :"" }}
          </p>
        </div>
        <div class="premium-share">
          <p class="sharep">5min Read</p>
          <div class="shareicons">
            <p>1.2k</p>
            <img src="{{ asset('images/claps.svg')}}" alt="">
            <i class="ti ti-share"></i>
            <i class="ti ti-bookmark"></i>
          </div>
        </div>
        <div class="premium-tag">
          <a class="tag bg-tag-1"> {{($data['news']->tag)? $data['news']->tag :"" }}</a>
       
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  @endcan
  @cannot('checkplan','App\\Models\User')
       
  <div id="overlay">
   <div id="overtext"> 
     <button id="close" class="btn btn default btn-sm float-right">Close</button>
     <div class="premium-container" id="text">
       <div class="premium">
         <a href="@if(auth()->user()){{ route('razorpay') }}@else{{ route('premiumlogin')}}@endif"> <img src="{{ asset("images/premium.png")}}" class="img-fluidlogo"></a>
       </div>
     </div>
   </div>
 </div>

</div>
</div>
@endcannot
@else 
  <!-- Page Heading -->
  <div class="main-news">
    <h1 class="homeheading">{{ $data['news']->heading }}</h1>
    <p class="news-heading">News</p>
    <div class="premium-share">
      <p class="sharep">5min Read</p>
      <div class="shareicons">
        <p>1.2k</p>
        <img src="images/clap-after.svg" alt="">
        <i class="ti ti-share"></i>
        <i class="ti ti-bookmark"></i>
      </div>
    </div>
    <div class="premium-news-img">
      <img src="{{ asset('storage/'.$data['news']->images->img) }}" alt="">
    </div>
    <div class="premium-newsp">
      <p>
        {{($data['news']->description)? $data['news']->description :"" }}
      </p>
    </div>
    <div class="premium-share">
      <p class="sharep">5min Read</p>
      <div class="shareicons">
        <p>1.2k</p>
        <img src="{{ asset('images/claps.svg')}}" alt="">
        <i class="ti ti-share"></i>
        <i class="ti ti-bookmark"></i>
      </div>
    </div>
    <div class="premium-tag">
      <a class="tag bg-tag"> {{($data['news']->tag)? $data['news']->tag :"" }}</a>
      
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>

@endif

  <!-- End of Main Content -->
  <footer>
    &copy; Techshots Original Content
  </footer>

</div>
<!-- End of Content Wrapper -->




@endsection
@push('pagescripts')
<style>
#overlay {
  position: fixed; /* Sit on top of the page content */
  display: none; /* Hidden by default */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.9
  ); /* Black background with opacity */
  z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}
#text{
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 50px;
  color: white;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
}
</style>
    
<script>


    if (window.location.href.indexOf("premium") > -1) {
      $('#overlay').show();
    }

</script>
@endpush