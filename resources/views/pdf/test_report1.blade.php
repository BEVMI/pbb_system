<html>
    <head>
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/png">
        <link href="{{asset("css/report1.css")}}" rel="stylesheet" />
        <link href="{{asset("css/print.min.css")}}" rel="stylesheet" />
        <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
    </head>
    <body>
        <button onclick="irene()">PRINT</button>
        <div id="printJS-form">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        @include('reports.report1_mod1')
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{asset('js/jquery-3.7.1.js')}}"></script>
        <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
        <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/sweetalert2@11.js')}}"></script>
        <script src="{{asset("js/print.min.js")}}" crossorigin="anonymous"></script>
        <script>
            function irene(){
                printJS({
                    printable: 'printJS-form',
                    type: 'html',
                    css: [
                        '{{asset("css/report1.css")}}',
                        '{{asset("assets/css/argon-dashboard.css?v=2.0.4")}}'
                    ],
                    scanStyles: false
                })
            }
        </script>
    </body>
</html>