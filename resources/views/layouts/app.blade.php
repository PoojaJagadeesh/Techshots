<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.inc.header')
</head>
<body class="sb-nav-fixed">


    <div id="layoutSidenav">
        <!-- sidebar starts -->
        @include('layouts.inc.sidebar')
        <!-- sidebar ends -->
        <div id="layoutSidenav_content">
            <!-- Main Section All Contents -->
            <main>
                <div class="container-fluid">

                    <div class="flex-container">
                        <div class="flex-item-left">
                           <h1 class="mtp dashheading">@yield('page')</h1>
                        </div>
                        <div class="flex-item-right">
                            @yield('button')
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-12"></div>
                    </div>

                    <section>
                        @yield('content')
                    </section>

                </div>
            </main>
        </div>


    </div>


    @include('layouts.inc.scripts')
    @stack('page-scripts')


</body>
</html>
