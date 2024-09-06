<?php 
    $user_auth = Auth::user();
?><!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">
  <title>
    PBB PMS SYSTEM
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('assets/css/fontawesome.min.css')}}" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
  <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <script src="{{asset('js/877d2cecdc.js')}}" crossorigin="anonymous"></script>
  <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet" />
  <link href="{{asset('css/style1.css')}}" rel="stylesheet" />
  <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
  @yield('styles')
</head>

<body class="g-sidenav-show bg-gray-100  g-sidenav-hidden">
  <div class="container-fluid py-2" style="max-width: 1920px;">
    <div class="row">
      <div class="irene_center col-md-6 col-12">
        <img src="{{asset('images/PBB_LOGO.png')}}" class="navbar-brand-img h-100" alt="main_logo" style="width: 150px;">
      </div>
      <div class="irene_center1 col-md-6 col-12 irene_user_name" style="margin: auto;">
        <b>{{$user_auth->name}}</b>
      </div>
    </div>
  </div>
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  {{-- ASIDE --}}
  @include('includes.aside')
  {{-- END ASIDE --}}
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <div class="row">
      <div class="col-sm-12">
       
      </div>
    </div>
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false" >
      <div class="container-fluid py-1 px-3" style="max-width: 1920px;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">@yield('breadcrumbs_1')</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('breadcrumbs_2')</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">@yield('title')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
           
          </div>
          <ul class="irene-nav-1" style="position: absolute; right: 0px; top: auto;">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav irene-nav justify-content-end">
            @if($user_auth->line_1 =='1' || $user_auth->line_2 =='1' || $user_auth->injection =='1')
            <li class="nav-item dropdown irene_hide px-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-table-columns"></i>
                <span class="d-sm-inline d-none" style="font-weight: bold;">PLAN</span>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                @if($user_auth->line_1 =='1')
                  <li class="mb-2">
                    <a class="nav-link" href="{{route('plan_line1.index')}}">
                      <i class="fa-solid fa-1 text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
                      <span class="nav-link-text ms-1" style="font-weight:bold; margin-top:8px;">LINE 1</span>
                    </a>
                  </li>
                @endif

                @if($user_auth->line_2 =='1')
                  <li class="mb-2">
                    <a class="nav-link" href="{{route('plan_line2.index')}}">
                      <i class="fa-solid fa-2 text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
                      <span class="nav-link-text ms-1" style="font-weight:bold; margin-top:8px;">LINE 2</span>
                    </a>
                  </li>
                @endif

                @if($user_auth->injection =='1')
                  <li class="mb-2">
                    <a class="nav-link" href="{{route('injection.index')}}">
                      <i class="fa-solid fa-2 text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
                      <span class="nav-link-text ms-1" style="font-weight:bold; margin-top:8px;">INJECTION</span>
                    </a>
                  </li>
                @endif
              </ul>
            </li>
            @endif
            
            @if($user_auth->is_pm='1')
              <li class="nav-item dropdown irene_hide px-2 d-flex align-items-center">
                <a href="{{route('pm.index')}}" class="nav-link text-white p-0">
                  <i class="fa-solid fa-sheet-plastic"></i>
                  <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">PM</span>
                </a>
              </li>
            @endif

            <li class="nav-item dropdown irene_hide px-2 d-flex align-items-center">
              <a href="{{route('job.index')}}" class="nav-link text-white p-0">
                <i class="fa-solid fa-bars-progress"></i>
                <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">JOB</span>
              </a>
            </li>

            <li class="nav-item dropdown irene_hide px-2 d-flex align-items-center">
              <a href="{{route('reject.index')}}" class="nav-link text-white p-0">
                <i class="fa-solid fa-eject"></i>
                <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">REJECTS</span>
              </a>
            </li>

            

            <li class="nav-item dropdown irene_hide px-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-warehouse"></i>
                <span class="d-sm-inline d-none" style="font-weight: bold;">INVENTORY</span>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="nav-link" href="{{route('inventoryfg.index')}}">
                    <i class="fa-regular fa-clipboard text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
                    <span class="nav-link-text ms-1" style="font-weight:bold; margin-top:8px;">INV. FG</span>
                  </a>
                </li>

                <li class="mb-2">
                  <a class="nav-link" href="{{route('inventorymaterials.index')}}">
                    <i class="fa-solid fa-money-bill text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
                    <span class="nav-link-text ms-1" style="font-weight:bold; margin-top:8px;">INV. MATERIALS</span>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item px-2 irene_hide d-flex align-items-center">
              <a href="{{route('mrp.index')}}" class="nav-link text-white p-0">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">MRP</span>
              </a>
            </li>

            <li class="nav-item px-2 irene_hide d-flex align-items-center">
              <a href="{{route('pocompliance.index')}}" class="nav-link text-white p-0">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">PO. COMPLIANCE</span>
              </a>
            </li>

            <li class="nav-item px-2 irene_hide d-flex align-items-center">
              <a href="{{route('forecast.index')}}" class="nav-link text-white p-0">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">FORECAST</span>
              </a>
            </li>

            @if($user_auth->is_admin='1')
              <li class="nav-item px-2 irene_hide d-flex align-items-center">
                <a href="{{route('users.index')}}" class="nav-link text-white p-0">
                  <i class="fa-solid fa-user"></i>
                  <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">USERS</span>
                </a>
              </li>
            @endif

            <li class="nav-item dropdown irene_hide px-2 d-flex align-items-center">
              <a href="{{route('logout')}}" class="nav-link text-white p-0">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="nav-link-text ms-1" style="margin-top:8px; font-weight:bold;">LOGOUT</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-1"  style="max-width: 1920px;">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-xl-4 col-lg-4 col-sm-6">
                  <h3>@yield('subtitle')</h3>
                </div>
                <div class="col-xl-6 col-lg-5 ">
                    
                </div>
                <div class="col-xl-2 col-lg-3 col-sm-6">
                  @yield('button')
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2" >
              <hr style="background-color: black; height: 1px; border: 0;">
              @yield('main')
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                MADE WITH <i class="fa fa-heart"></i> BY
                <b>IT DEPARTMENT</b>
              </div>
            </div>
            <div class="col-lg-6">
             
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 ">
        <div class="float-start">
          <h5 class="mt-3 mb-0">LINKS</h5>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0 overflow-auto">
        {{-- LINKS --}}
        @include('includes.links')
        {{-- END LINKS --}}
      </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{asset('js/jquery-3.7.1.js')}}"></script>
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
  {{-- <script src="{{asset('js/buttons.js')}}"></script> --}}
  <script src="{{asset('js/sweetalert2@11.js')}}"></script>
  <script>
    let api_url = '{!!$api_url!!}';
    function formatDate(date) {
      var d = new Date(date),
          month = '' + (d.getMonth() + 1),
          day = '' + d.getDate(),
          year = d.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      return [year, month, day].join('-');
    }

    window.onload = function () {
        $('.fc-toolbar.fc-header-toolbar').addClass('row col-lg-12');
    };

    // add the responsive classes when navigating with calendar buttons
  </script>
  @yield('scripts')
</body>

</html>