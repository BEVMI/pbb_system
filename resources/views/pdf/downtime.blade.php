<html>
    <head>
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/png">
        {{-- <link href="{{asset("css/report1.css")}}" rel="stylesheet" />
        <link href="{{asset("css/print.min.css")}}" rel="stylesheet" /> --}}
        <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
        <style>
            *{
                color:black;
            }
            td{
                font-weight: bold;
            }
            .irene-td{
                text-align: right;
            }
            .irene-td-center{
                text-align: center;
            }
            .border-top{
                border-top: 1px black solid !important; 
            }

            .border-right{
                border-right: 1px black solid !important; 
            }

            .border-left{
                border-left: 1px black solid !important; 
            }

            .border-bottom{
                border-bottom: 1px black solid !important; 
            }
            .table> :not(caption)>*>* {
                border-bottom-width:0px;
            }
            .blue_background{
                background-color: rgb(133, 180, 212);
            }
            @page {
                margin: 20px 25px;
            }

        </style>
    </head>
    <?php $count = 0;?>
    <body style="font-size:9px;">
        <table class="table">
            <tbody>
                <tr>
                    <?php 
                        $count = 1;
                        $count_all = count($headers->downtimeDate);
                    ?>
                    @foreach($headers->downtimeDate as $downtimeDate)
                        @if($count == 1)
                            <td class="w-30 border-top border-left">
                        @else
                            <td class="irene-td border-top border-left border-right border-bottom w-10">
                        @endif
                        {{$downtimeDate}}
                        </td>
                        <?php $count++;?>
                    @endforeach
                    <?php $count = 1;?>
                    {{$count_all}}
                </tr>
            </tbody>
        </table>
        
    </body>
</html>