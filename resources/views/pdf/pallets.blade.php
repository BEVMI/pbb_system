<?php 
  $user_auth = Auth::user();
  date_default_timezone_set('Asia/Manila');
  $datetoday = date('Y-m-d h:i a');
//   $year = date('Y');
?>

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
            .irene{
                width: 100%;
                border-collapse: collapse;
            }
            .irene_td{
                border: 2px solid black;
            }
            .text_center{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php 
            $count = 1;
        ?>
        @foreach($pallets as $pallet)
       
        <div>
            <p style="font-size:24px; padding-left:5px; margin:0px;">Receipt date: {{ Carbon\Carbon::now()->format('d.m.Y') }}</p>
            <table class="irene" style="border:2px solid black;" cellpadding="0" cellspacing="0">
                <thead>
                    <th style="width: 33.3%;"></th>
                    <th style="width: 33.3%;"></th>
                    <th style="width: 33.3%;"></th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset('images/PBB_TOS.png') }}" alt="Logo" style="padding-left:3px; padding-top:3px; position:absolute; width:230px; height:60px;">
                        </td>
                        <td class="text_center">
                            <h2>PALLET ID</h2>
                        </td>
                        <td class="text_center"></td>
                    </tr>
                    <tr>
                        <td class="irene_td">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>PALLET ID NUMBER</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:40px; padding-top:10px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px; ">
                                        <?php
                                            $exploded = explode('-', $pallet->cPalletRef);
                                        ?>
                                        {{$exploded[1]}}-{{$exploded[2]}}
                                    </td>
                                </tbody>
                            </table>
                        </td>

                        <td class="irene_td">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>DATE</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:40px; padding-top:10px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px;">{{Carbon\Carbon::parse($pallet->dOutPutDate)->format('d.m.Y')}}</td>
                                </tbody>
                            </table>
                        </td>

                        <td class="irene_td">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>REF: TURN OVER SLIP</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:40px; padding-top:10px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px;">{{$tos->cTOSRefNo}}</td>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="irene_td">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>SKU CODE</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:50px; padding-top:10px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px;">{{$pallet->plan->cStockCode}}</td>
                                </tbody>
                            </table>
                        </td>


                        <td class="irene_td" colspan="2">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>PRODUCT DESCRIPTION</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:50px; padding-top:10px; ">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px;">{{$pallet->plan->cDescription}} {{$pallet->plan->cLongDesc}}</td>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                     <tr>
                        <td class="irene_td"  colspan="2">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>Lot Number</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:60px; padding-top:20px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:36px;">{{$pallet->cLotNumber}}</td>
                                </tbody>
                            </table>
                        </td>


                        <td class="irene_td">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>QUANTITY</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:60px; padding-top:20px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:36px;">{{$pallet->iCases}} CS</td>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="irene_td" >
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>PRODUCTION DATE</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:60px; padding-top:15px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px;">{{Carbon\Carbon::parse($pallet->dMfgDate)->format('d.m.Y')}}</td>
                                </tbody>
                            </table>
                        </td>


                        <td class="irene_td">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>EXPIRATION DATE</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:60px; padding-top:15px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px;">{{Carbon\Carbon::parse($pallet->dExpDate)->format('d.m.Y')}}</td>
                                </tbody>
                            </table>
                        </td>

                         <td class="irene_td">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>GROSS WEIGHT</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:100%; height:60px; padding-top:15px;">
                                <tbody>
                                    <td style="text-align: center; font-weight: bold; middle-align:middle; font-size:24px;">
                                        {{number_format($pallet->iCases * $pallet->plan->InvMaster->nCaseWeight,2)}} KG
                                    </td>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="width:100%; margin-top:-5px;">
               <thead>
                    <th style="width:33.3%;"></th>
                    <th style="width:33.3%;"></th>
                    <th style="width:33.3%;"></th>
               </thead>
               <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="font-size:12px;">PBB-SS-WH-TG-001</td>
                    </tr>
               </tbody>
            </table>
        </div>

        @if($count % 2 != 0)
        <div>
            <table style="width:66.67%; border-bottom:2px solid black;">
                
                <tbody>
                    <tr>
                        <td style="">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        <?php $count++; ?>
        @if($count % 2 != 0)
            <div style="page-break-after:always;"></div>
        @endif
        @endforeach

    </body>
</html>