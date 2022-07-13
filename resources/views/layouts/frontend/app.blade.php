<!DOCTYPE html>
<html lang="en">

    <head>
        @include('layouts.frontend.header')
    </head>

    <body id="page-top">
        <div class="preloader-wrap">
            <div class="loader-container">
              <div class="loader-logo">
                <span class="icon"><img src="images/test-1.png" alt=""></span>
                <span class="text"><img src="images/logo-text.svg" alt=""></span>
              </div>
            </div>
          </div>
        @stack('feedshared')

        <!-- Page Wrapper -->
        <div id="wrapper">
            {{-- sidebar --}}
            @include('layouts.frontend.sidebar')
            <!-- End of Sidebar -->

            @yield('content')


            @include('layouts.frontend.footer')
            @stack('pagescripts')
            <script>
                // Lodder
                var width = 100,
                    perfData = window.performance.timing, // The PerformanceTiming interface represents timing-related performance information for the given page.
                    EstimatedTime = -(perfData.loadEventEnd - perfData.navigationStart),
                    time = parseInt((EstimatedTime/1000)%60)*100;
                // Loadbar Animation
                $(".loaded").animate({
                  height: width + "%"
                }, time);
                // Fading Out Loadbar on Finised
                setTimeout(function(){
                  $('.preloader-wrap').fadeOut(300);
                }, time);
                </script>
    </body>
</html>
