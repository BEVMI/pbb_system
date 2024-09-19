<html>
    <head>
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/png">
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 20px 25px;
            }

            @font-face {
                font-family: "source_sans_proregular";           
                src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
                font-weight: normal;
                font-style: normal;
            }        
            body{
                font-family: "source_sans_proregular","sans-serif";            
            }

            body {
                margin-top: .1cm;
                margin-left: 0cm;
                margin-right: 0cm;
                margin-bottom: .1cm;
            }
             .pdf th, .pdf td {
             border: 1px solid;
            }

            .pdf{
                border-collapse: collapse;
                font-size:14px;
            }
            .irene_class{
                font-size: 8px !important;
            }
        </style>
    </head>
    <body>
        <?php 
            $count = 1;    
        ?>
        
            <table cellspacing='0' cellpadding="0" style="width:100%;">
                <thead>
                    <th style="width:20%;"></th>
                    <th style="width:20%;"></th>
                    <th style="width:20%;"></th>
                    <th style="width:20%;"></th>
                    <th style="width:20%;"></th>
                    <th style="width:20%;"></th>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center; border: 1px solid black;">
                            <img src="{{asset('images/PBB_LOGO.png')}}" style="padding:7px 0px; width: 65px;">
                        </td>
                        <td colspan="5" style="text-align:center; border: 1px solid black; font-weight: bold; font-size:16px;">
                            TURNOVER FORM
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding:12px;" colspan="6">
                            <b>(Warehouse Copy)</b>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center; padding:12px;" colspan="4">
                        </td>
                        <td style="text-align: center;">
                            Reference No:
                        </td>
                        <td style="text-align:center; border-bottom:1px solid black;">
                            FG0824010
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="font-size:5px;" colspan="6">&nbsp;</td>
                    </tr>
                    <tr> 
                     
                        <td colspan="6" style="margin-top: 5px; background-color:rgb(180, 180, 180); text-align:center; font-weight:bold;">
                            Turnover Details
                        </td>
                    </tr>
                </tbody>
            </table>
        
    </body>
</html>