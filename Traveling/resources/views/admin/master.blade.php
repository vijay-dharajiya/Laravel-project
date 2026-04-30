<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Traveling Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('admin/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('admin/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('admin/img/favicon.ico') }}">
  </head>
  <body>
    <header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <!-- Navbar Header--><a href="{{ route('dashboard') }}" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">ADMIN</strong><strong>DASHBOSRD</strong></div>
              <div class="brand-text brand-sm"><strong class="text-primary">A</strong><strong>D</strong></div></a>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          <div class="right-menu list-inline no-margin-bottom d-flex align-items-center">
              <span class="text-white mr-3">
                  {{ auth()->user()->name }}
              </span>
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-lg">
                    <i class="fa fa-sign-out" aria-hidden="true"> Logout </i>
                  </button>
              </form>
          </div>
        </div>
      </nav>
    </header>
    <div class="d-flex align-items-stretch" style="min-height: calc(100vh - 120px);">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="{{ asset('admin/img/avatar-6.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">TRAVELING</h1>
            <p>Web Site</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled" id="sidebar-menu">

          <li class="active">
            <a href="{{ route('dashboard') }}">
              <i class="fa fa-home"></i> Home
            </a>
          </li>

          <!-- Flights -->
          <li>
            <a href="#exampledropdownDropdown" data-toggle="collapse">
              <i class="fa fa-plane"></i> Flights
            </a>
            <ul id="exampledropdownDropdown" class="collapse list-unstyled">
              <li><a href="{{ route('admin.addflight') }}">Add Flight</a></li>
              <li><a href="{{ route('admin.viewflight') }}">View Flights</a></li>
            </ul>
          </li>

          <!-- Hotels -->
          <li>
            <a href="#product" data-toggle="collapse">
              <i class="fa fa-bed"></i> Hotels
            </a>
            <ul id="product" class="collapse list-unstyled">
              <li><a href="{{ route('admin.addhotel') }}">Add Hotel</a></li>
              <li><a href="{{ route('admin.viewhotel') }}">View Hotels</a></li>
              <li><a href="{{ route('admin.hotelimages') }}">Add Hotel images</a></li>
              <li><a href="{{ route('admin.hotelroom') }}">Add Hotel room</a></li>
              <li><a href="{{ route('admin.roomimages') }}">Add Room images</a></li>
            </ul>
          </li>

          <!-- Packages -->
          <li>
            <a href="#orders" data-toggle="collapse">
              <i class="fa fa-suitcase"></i> Packages
            </a>
            <ul id="orders" class="collapse list-unstyled">
              <li><a href="#">Add Package</a></li>
              <li><a href="#">View Packages</a></li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        @yield('content')
       
      </div>
    </div>
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/charts-home.js') }}"></script>
    <script src="{{ asset('admin/js/front.js') }}"></script>

    <!-- ✅ ADD THIS HERE -->
    <script>
    $(document).ready(function () {
        $('#sidebar-menu a[data-toggle="collapse"]').on('click', function () {
            $('#sidebar-menu .collapse').not($(this).next()).collapse('hide');
        });
    });
    </script>
  </body>
</html>