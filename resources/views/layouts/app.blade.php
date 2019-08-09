<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IRS Helpdesk</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.addons.css')}}">
    <!-- endinject -->
    <!-- vendor css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/flag-icon-css/css/flag-icon.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/hilightjs/skins/atom-one-light.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/pace/pace.min.css')}}">
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png')}}" />
    <script src="{{ asset('js/app.js')}}" defer></script>

  </head>
  <body class="header-fixed docs-body">
    <div class="doc-content-wrapper container">
      <div class="doc-aside">
        <div class="aside-header">
          <a href="#"><img class="logo" src="{{ asset('assets/images/logo.png')}}" alt="logo"></a>
          <div class="nav-toggle-warpper">
            <span class="nav-toggler"></span>
          </div>
        </div>
        <ul class="nav">
          @php
            $routes = [
                [ "route" => route('tickets.summary'), "name" => "Dashboard"],
                [ "route" => route('tickets.new'), "name" => "Create new ticket"],
                [ "route" => route('tickets.list'), "name" => "My tickets"],
                [ "route" => route('tickets.list', ['assigned_to_me' => 1]), "name" => "Tickets assigned to me"],
              ]
          @endphp
          @foreach($routes as $route)
          <li class="nav-item">
            <a href="{{ $route['route'] }}" class="nav-link {{ (request()->fullUrl() == $route['route']) ? 'active' : ''}}">{{ $route['name'] }}</a>
          </li>
          @endforeach
          <li class="nav-item">
            <a href="#" class="nav-link">IRS</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Help</a>
          </li>
        </ul>
      </div>

      <div class="doc-content-section" id="app">
          @yield('content')
      </div>
    </div>

    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/core.js')}}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.addons.js')}}"></script>
    <script src="{{ asset('assets/vendors/pace/pace.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js')}}"></script>
    <script src="{{ asset('assets/js/charts/chartjs.addon.js')}}"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <script src="{{ asset('assets/js/highlight.pack.js')}}"></script>
    <script>
      $(document).ready(function()
      {
        $('body').scrollspy(
        {
          target: ".doc-aside .nav",
          offset: 50
        });
        $(".doc-aside .nav .nav-link").on('click', function(event)
        {
          if (this.hash !== "")
          {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate(
            {
              scrollTop: $(hash).offset().top
            }, 800, function()
            {
              window.location.hash = hash;
            });
          }
        });
        $(".doc-aside .aside-header .nav-toggle-warpper").on("click", function()
        {
          toggleResponsiveNav();
        });

        function toggleResponsiveNav()
        {
          var screenWidth = $(window).outerWidth();
          if (screenWidth < 991)
          {
            $(".doc-content-wrapper .doc-aside .nav").slideToggle();
            $(".doc-content-wrapper .doc-aside .nav .nav-item").on("click", function()
            {
              $(".doc-content-wrapper .doc-aside .nav").slideUp();
            });
          }
        }
      });
    </script>
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="{{ asset('assets/js/template.js')}}"></script>
    <script src="{{ asset('assets/js/dashboard.js')}}"></script>
    @yield('scripts')
    <!-- endbuild -->
  </body>
</html>