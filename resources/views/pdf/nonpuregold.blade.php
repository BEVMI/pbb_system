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

            .table {
                width: 100%;
                margin-bottom: 0.3rem;
                border-collapse: collapse;
            }

            .pdf-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                height: 170px;/* Adjust height as needed */
                background-color: #fff; /* Ensure the header has a white background */
                z-index: 1000;
            }


            .pdf-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: 525px;/* Adjust height as needed */
                background-color: #fff; /* Ensure the header has a white background */
                z-index: 1000;
            }

            body {
                margin-top: 1.4cm;
                margin-left: 0cm;
                margin-right: 0cm;
                margin-bottom: 10cm;
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
            .body_table {
                width: 100%;
                border-collapse: collapse;
            }
            .body_table tr{
                border:2px solid black;
            }
            .body_table th, .body_table td {
                font-size:10px;
                 border:2px solid black;
            }
            .irene-table2{
                width: 100%;
                border-collapse: collapse;
            }
            .irene-table2 th, .irene-table2 td {
                border: 1px solid black;
                font-size:8px;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <div class="pdf-header">
            <table class="table border-0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width:20%; text-align:left;">
                            <img src="{{url('/images/PBB_LOGO.png')}}" style="width:100px;">
                        </td>
                        <td style="width:35%; text-align:left;">
                            <p style="font-size:11px; text-align:left; line-height: 1.4; font-weight:bold; color:rgb(0, 0, 153);">PHILIPPINE BOTTLING AND BEVERAGE MANUFACTURING CORPORATION</p>
                        </td>
                        <td style="width:15%;">

                        </td>
                        <td class="text-right align-middle" style="width: 30%; font-size: 11px">
                            <h2 style="font-weight:bold; text-align: center; font-size:11px;">PBB-SS-WH-FO-004 Rv00_15Aug2025</h2>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table border-0" style="width: 100%; margin-top:15px;">
                <tbody>
                    <tr style="font-size:12px;">
                        <td style="text-align: center;"><b>{{ $depot }}</b></td>
                    </tr>
                    <tr style="font-size:12px;">
                        <td style="text-align: center;">PACKING LIST <b>#{{ $control_number }}</b></td>
                    </tr>
                </tbody>
            </table>

            <table class="table border-0" style="width: 100%; margin-top:15px;">
                <tbody>
                    <tr style="font-size:12px;">
                        <td colspan="4">DATE: <u>{{ $created_date }}</u></td>
                    </tr>
                    <tr style="font-size:12px;">
                        <td colspan="4">PLATE: <u>{{ $plate_number }}</u></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pdf-footer">
            <p style="font-weight: bold; font-size: 10px;">Note: To be filled by Cross Dock Checker</p>
            <br>
            <table class="irene-table2">
                <tbody>
                    <tr>
                        <td style="width:90%; vertical-align: top; height:30px;">
                            <span style="">Remarks:</span>
                        </td>
                        <td style="width:10%;"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="irene-table2">
                <tbody>
                    <tr>
                        <td style="width:90%; vertical-align: top; height:30px;">
                            <span style="">Damages:</span>
                        </td>
                        <td style="width:10%;"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="irene-table2">
                <tbody>
                    <tr>
                        <td style="width:90%; vertical-align: top; height:30px;">
                            <span style="">Excess:</span>
                        </td>
                        <td style="width:10%;"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="irene-table2">
                <tbody>
                    <tr>
                        <td style="width:90%; vertical-align: top; height:30px;">
                            <span style="">Short receive:</span>
                        </td>
                        <td style="width:10%;"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="irene-table2">
                <tbody>
                    <tr>
                        <td style="width:90%; vertical-align: top; height:30px;">
                            <span style="">Others</span>
                        </td>
                        <td style="width:10%;"></td>
                    </tr>
                </tbody>
            </table>
            <table class="table border-0" style="width: 100%; margin-top:15px;">
                <tbody>
                    <tr style="font-size:12px;">
                        <td style="width:40%;">ACKNOWLEDGE BY</td>
                        <td style="width:20%;">&nbsp;</td>
                        <td style="width:40%;">&nbsp;</td>
                    </tr>

                    <tr style="font-size:12px;">
                        <td style="width:40%;"><br></td>
                        <td style="width:20%;"><br></td>
                        <td style="width:40%;"><br></td>
                    </tr>

                    <tr style="font-size:12px;">
                        <td style="width:40%; border-bottom:1px solid black;"></td>
                        <td style="width:20%;"><br></td>
                        <td style="width:40%; border-bottom:1px solid black;"></td>
                    </tr>

                    <tr style="font-size:12px; text-align:center;">
                        <td style="width:40%;">Signature Over Printed Name</td>
                        <td style="width:20%;"><br></td>
                        <td style="width:40%;">Signature Over Printed Name</td>
                    </tr>
                    <tr style="font-size:12px; text-align:center;">
                        <td style="width:40%;">Supplier's Responsive</td>
                        <td style="width:20%;"><br></td>
                        <td style="width:40%;">Count 2: Crossdock Checker</td>
                    </tr>
                    <tr style="font-size:12px;">
                        <td style="width:40%;"><br></td>
                        <td style="width:20%;"><br></td>
                        <td style="width:40%;"><br></td>
                    </tr>
                     <tr style="font-size:12px;">
                        <td style="width:40%; border-bottom:1px solid black;"></td>
                        <td style="width:20%;"><br></td>
                        <td style="width:40%;"></td>
                    </tr>
                    <tr style="font-size:12px; text-align:center;">
                        <td style="width:40%;">Signature Over Printed Name</td>
                        <td style="width:20%;"></td>
                        <td style="width:40%;"></td>
                    </tr>
                    <tr style="font-size:12px; text-align:center;">
                        <td style="width:40%;">Count 1: Crossdock Checker</td>
                        <td style="width:20%;"><br></td>
                        <td style="width:40%;"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php $total = 0; ?>
        <div class="main-content" style="margin-top: 130px;">
            <table class="body_table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width:15%;">CASE CODE</th>
                        <th style="width:15%;">PO NO.</th>
                        <th style="width:10%;">SI NO.</th>
                        <th style="width:10%;">SKU CODE</th>
                        <th style="width:20%;">ITEM DESCRIPTION</th>
                        <th style="width:15%;">UOM</th>
                        <th style="width:15%;">QTY</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loadsheets as $loadsheet)
                        @foreach($loadsheet->lssDetails as $detail)
                              <tr style="text-align: center;">
                                <td>{{$detail->caseCode}}</td>
                                <td>{{$detail->customerPoNumber}}</td>
                                <td>{{$detail->invoice}}</td>
                                <td>{{$detail->stockCode}}</td>
                                <td>{{$detail->description}}</td>
                                <td>CS</td>
                                <td>{{$detail->qty}}</td>
                              </tr>
                                <?php $total += $detail->qty; ?>
                        @endforeach
                    @endforeach
                    @foreach($loadsheets as $loadsheet)
                        @foreach($loadsheet->lssDetails as $detail)
                              <tr style="text-align: center;">
                                <td>{{$detail->caseCode}}</td>
                                <td>{{$detail->customerPoNumber}}</td>
                                <td>{{$detail->invoice}}</td>
                                <td>{{$detail->stockCode}}</td>
                                <td>{{$detail->description}}</td>
                                <td>CS</td>
                                <td>{{$detail->qty}}</td>
                              </tr>
                                <?php $total += $detail->qty; ?>
                        @endforeach
                    @endforeach
                    @foreach($loadsheets as $loadsheet)
                        @foreach($loadsheet->lssDetails as $detail)
                              <tr style="text-align: center;">
                                <td>{{$detail->caseCode}}</td>
                                <td>{{$detail->customerPoNumber}}</td>
                                <td>{{$detail->invoice}}</td>
                                <td>{{$detail->stockCode}}</td>
                                <td>{{$detail->description}}</td>
                                <td>CS</td>
                                <td>{{$detail->qty}}</td>
                              </tr>
                                <?php $total += $detail->qty; ?>
                        @endforeach
                    @endforeach
                    @foreach($loadsheets as $loadsheet)
                        @foreach($loadsheet->lssDetails as $detail)
                              <tr style="text-align: center;">
                                <td>{{$detail->caseCode}}</td>
                                <td>{{$detail->customerPoNumber}}</td>
                                <td>{{$detail->invoice}}</td>
                                <td>{{$detail->stockCode}}</td>
                                <td>{{$detail->description}}</td>
                                <td>CS</td>
                                <td>{{$detail->qty}}</td>
                              </tr>
                                <?php $total += $detail->qty; ?>
                        @endforeach
                    @endforeach
                    @foreach($loadsheets as $loadsheet)
                        @foreach($loadsheet->lssDetails as $detail)
                              <tr style="text-align: center;">
                                <td>{{$detail->caseCode}}</td>
                                <td>{{$detail->customerPoNumber}}</td>
                                <td>{{$detail->invoice}}</td>
                                <td>{{$detail->stockCode}}</td>
                                <td>{{$detail->description}}</td>
                                <td>CS</td>
                                <td>{{$detail->qty}}</td>
                              </tr>
                                <?php $total += $detail->qty; ?>
                        @endforeach
                    @endforeach
                    @foreach($loadsheets as $loadsheet)
                        @foreach($loadsheet->lssDetails as $detail)
                              <tr style="text-align: center;">
                                <td>{{$detail->caseCode}}</td>
                                <td>{{$detail->customerPoNumber}}</td>
                                <td>{{$detail->invoice}}</td>
                                <td>{{$detail->stockCode}}</td>
                                <td>{{$detail->description}}</td>
                                <td>CS</td>
                                <td>{{$detail->qty}}</td>
                              </tr>
                                <?php $total += $detail->qty; ?>
                        @endforeach
                    @endforeach
                    @foreach($loadsheets as $loadsheet)
                        @foreach($loadsheet->lssDetails as $detail)
                              <tr style="text-align: center;">
                                <td>{{$detail->caseCode}}</td>
                                <td>{{$detail->customerPoNumber}}</td>
                                <td>{{$detail->invoice}}</td>
                                <td>{{$detail->stockCode}}</td>
                                <td>{{$detail->description}}</td>
                                <td>CS</td>
                                <td>{{$detail->qty}}</td>
                              </tr>
                                <?php $total += $detail->qty; ?>
                        @endforeach
                    @endforeach
                    <tr>
                        <td colspan="6" style="text-align: right; font-weight: bold;">TOTAL QTY:</td>
                        <td style="text-align: center; font-weight: bold;">{{ $total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>