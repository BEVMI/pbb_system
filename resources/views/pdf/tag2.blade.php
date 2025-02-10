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
                    <th style="width:50%;"></th>
                    <th style="width:50%;"></th>
                </thead>
                <tbody>
                    @foreach($pallets as $pallet)
                    <?php 
                        $exploded_ref = explode("-",$pallet->cPalletRef);
                    ?>
                
                        @if($count % 2 != 0)
                            <tr>
                        @endif
                                <td> 
                                    <table class="irene_class"  style="padding:2px; height:193px; margin-top:-1px;  border:1px solid black; width:100%;">
                                        <thead>
                                            <th style='width:15%;'></th>
                                            <th style='width:34%;'></th>
                                            <th style='width:2%;'></th>
                                            <th style='width:15%;'></th>
                                            <th style='width:34%;'></th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="vertical-align: top;">
                                                    <img src="{{asset('images/PBB_LOGO.png')}}" style="width: 45px;">
                                                    <span style="position: absolute; font-size:7px;">
                                                        <b>Philippine Bottling and Beverage Manufacturing Corporation</b>
                                                        <br>
                                                        618 Brgy. San Jose, San Pablo City, Laguna
                                                    </span>
                                                </td>
                                            
                                                <td colspan="2" style="vertical-align: top; text-align:right;">
                                                    <br><br>
                                                    <span style="font-size: 6px;  margin-top:2px;">
                                                        <span style="font-size: 12px; font-weight:bolder;"><?php echo $exploded_ref[2]; ?></span>
                                                        <br>
                                                        {{$tag->control_no}}
                                                        <br>
                                                        {{$tag->revision_number}}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr style="margin-top:10px;">
                                                <td colspan="5" style="font-size: 50px; text-align: center; font-weight:bold;">
                                                    {{$tag->title}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox">
                                                    </span> 
                                                    <span style="margin-top:2px; position: absolute;">
                                                        RM
                                                    </span>
                                                
                                                    <span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox">
                                                    </span> 
                                                    <span style="margin-top:2px; position: absolute;">
                                                        PM
                                                    </span>

                                                    <span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" checked>
                                                    </span> 
                                                    <span style="margin-top:2px; position: absolute;">
                                                        FG
                                                    </span>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <span>
                                                        <input type="checkbox">
                                                    </span> 
                                                    <span style="margin-top:2px; position: absolute; ">
                                                        OTHERS:
                                                    </span>
                                                </td>
                                                <td>
                                                    &nbsp;___________________________
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;">Description:</td>
                                                <td style="border-bottom:1px solid black;">
                                                    {{$pallet->cStockCode}}
                                                </td>
                                                <td></td>
                                                <td style="font-weight: bold;">Batch No.:</td>
                                                <td style="border-bottom:1px solid black;">
                                                    {{$pallet->cLotNumber}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-weight: bold;">Mfg. Date:</td>
                                                <td style="border-bottom:1px solid black; font-weight:bold; text-transform: uppercase;">
                                                    <?php $manu_date = \Carbon\Carbon::parse($pallet->dMfgDate)->format('d M Y');?>
                                                    {{$manu_date}}
                                                </td>
                                                <td></td>
                                                <td style="font-weight: bold;">Quantity:</td>
                                                <td style="border-bottom:1px solid black;">
                                                    {{$pallet->iCases}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-weight: bold;">Expiry Date:</td>
                                                <td style="border-bottom:1px solid black; font-weight:bold; text-transform: uppercase;">
                                                    <?php $dExpDate = \Carbon\Carbon::parse($pallet->dExpDate)->format('d M Y');?>
                                                    {{$dExpDate}}
                                                </td>
                                                <td></td>
                                                <td style="font-weight: bold;">Ref No.:</td>
                                                <td style="border-bottom:1px solid black;">
                                                    <?php echo $exploded_ref[0]; ?>-<?php echo $exploded_ref[1]; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-weight: bold;">QA/QC:</td>
                                                <td style="border-bottom:1px solid black;">
                                                    {{$user_name}}
                                                </td>
                                                <td></td>
                                                <td style="font-weight: bold;">Date:</td>
                                                <td style="border-bottom:1px solid black; font-weight:bold; text-transform: uppercase;">
                                                    {{\Carbon\Carbon::now()->format('d M Y')}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                        @if($count % 2 == 0)
                            </tr>
                        @endif
                        <?php $count++;?>
                    @endforeach
                </tbody>
            </table>
        
    </body>
</html>