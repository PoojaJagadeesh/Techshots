<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li>
            <a class="dropdown-item"  href="{{ route('admin.logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form-admin').submit();"
            >
            {{ __('Logout') }}<i class="dropdown-item-icon ti-power-off"></i>
            </a>

            <form  action="{{ route('admin.logout') }}" id="logout-form-admin" method="POST" class="d-none">
                @csrf
            </form>
        </li>

    </ul>
  </nav>
