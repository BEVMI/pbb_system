<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicon.png')}}">
        <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">
        <title>
          PBB SYSTEM
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
        <link href="{{asset('assets/css/bootstrap-treefy.min.css')}}" rel="stylesheet" />
        <!-- CSS Files -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
        <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
        <style>
            .irene_thead {
                font-weight: bold;
                background-color: #5e72e4;
                color: white;
            }
        </style>
    </head>
    <body>
        @yield('main')    
    </body>

    <script src="{{asset('js/jquery-3.7.1.js')}}"></script>
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-treefy.min.js')}}"></script>
    
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
    {{-- <script src="{{asset('js/buttons.js')}}"></script> --}}
    <script src="{{asset('js/sweetalert2@11.js')}}"></script>
    @yield('scripts')  
</html>