<html>
    <head>
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/png">
        <link href="{{asset("css/tos.css")}}" rel="stylesheet" />
        <link href=" https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" />
    </head>
    <body>
        <div id="printJS-form">
          
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
                            @if($turnover_details->is_warehouse =='1')
                                <b>(Warehouse Copy)</b>
                            @else
                                <b>(Production Copy)</b>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center; padding:12px;" colspan="4">
                        </td>
                        <td style="text-align: center;">
                            Reference No:
                        </td>
                        <td style="text-align:center; border-bottom:1px solid black;">
                            {{$turnover_details->tos_ref}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="font-size:5px;" colspan="6">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <table class="irene-table" cellspacing='0' cellpadding="2" style=" border-collapse: collapse;border:2px solid black; width:100%;">
                <tr> 
                    <td colspan="6" class="irene-100"  style="background-color:#c0c0c0; text-align:center; font-weight:bold;">Turnover Details</td>
                </tr>
                <tr>
                    <td class="irene_border irene-20 font-weight-bold">Date</td>
                    <td class="irene_border text-center irene-80" colspan="5">{{$turnover_details->date}}</td>
                </tr>
                <tr>
                    <td class="irene_border irene-20 font-weight-bold" style="width: 20%; font-weight:bold;">Time</td>
                    <td class="irene_border text-center irene-80" colspan="5">{{$turnover_details->time}}</td>
                </tr>
                <tr>
                    <td class="irene_border irene-20 font-weight-bold">Location</td>
                    <td class="irene_border text-center irene-80" colspan="5">Holding Area</td>
                </tr>
                <tr>
                    <td class="irene_border irene-20 font-weight-bold">Pallet Count</td>
                    <td class="irene_border text-center irene-80" colspan="5">{{$turnover_details->pallet_count}}</td>
                </tr>
               
            </table>
            <p style="margin-top:0px;"></p>

            <table class="irene-table" cellspacing='0' cellpadding="2" style=" border-collapse: collapse;border:2px solid black; width:100%; font-size:13px;">
                <tbody>
                    <tr> 
                        <td class="irene-100 text-center font-weight-bold" colspan="6" style="background-color:#c0c0c0;">Job Details</td>
                    </tr>
                    
                    <tr>
                        <?php $count = 1;?>
                        
                        @foreach($job_details->jobs as $job)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$job}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>

                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->skus as $sku)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$sku}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>
                    
                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->batchs as $batch)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$batch}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>

                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->mfg_dates as $mfg_date)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$mfg_date}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>

                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->exp_dates as $exp_date)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$exp_date}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>

                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->pallet_counts as $pallet_count)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$pallet_count}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>

                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->loose_case as $loose_case_row)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$loose_case_row}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>

                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->cases as $case)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$case}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>
                    
                    <tr>
                        <?php $count = 1;?>
                        @foreach($job_details->references as $reference)
                            @if($count==1)
                                <?php $weight = 'font-weight-bold';?>
                            @else
                                <?php $weight = 'text-center';?>
                            @endif
                            <td class="irene-16 {{$weight}} irene-padding-7">
                                {{$reference}}
                            </td>
                            <?php $count++;?>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <p style="margin-top:0px;"></p>
            {{-- REMARKS --}}
            <table class="irene-table" cellspacing='0' cellpadding="2" style=" border:2px solid black; width:100%;">
                <tr> 
                    <td class="irene-100 text-center font-weight-bold" colspan="2" style="background-color:#c0c0c0;">REMARKS</td>
                </tr>
                <tr>
                    <td class="irene-50">
                        <table class="irene-100 bypass-no-border" cellspacing='0' cellpadding="0" style="height: 150px;">
                            <tr>
                                <td colspan="4" class="irene-font-size irene-100 font-weight-bold text-center bypass-no-border">
                                    <?php
                                        $job_shift = array_shift($turnover_details->job);
                                        $new_job_array = implode(', ',$turnover_details->job);
                                    ?> 
                                    {{$new_job_array}} {{$turnover_details->stock_code}} - {{$turnover_details->long_desc}}
                                </td>
                            </tr>
                
                            <tr>
                                <td class="irene-25 bypass-no-border irene-font-size">
                                    {{$total_remark->batch_no}}
                                </td>
                                <td class="irene-25 bypass-no-border text-center irene-font-size">
                                    {{$total_remark->cases_qty}}
                                </td>
                                <td class="irene-25 bypass-no-border text-center irene-font-size">
                                    cases
                                </td>
                                <td class="irene-25 bypass-no-border text-center irene-font-size">
                                    {{$total_remark->coa}}
                                </td>
                            </tr>

                            @foreach ($remarks as $remark)
                                <tr>
                                    <td class="irene-25 bypass-no-border irene-font-size">
                                        {{$remark->batch_no}}
                                    </td>
                                    <td class="irene-25 bypass-no-border text-center irene-font-size">
                                        {{$remark->cases_qty}}
                                    </td>
                                    <td class="irene-25 bypass-no-border text-center irene-font-size">
                                        {{$remark->cases}}
                                    </td>
                                    <td class="irene-25 bypass-no-border text-center irene-font-size">
                                        {{$total_remark->coa}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td class="irene-50 text-center">
                        @if($turnover_details->received_by !='')
                            <img src="{{asset('images/received_warehouse.png')}}" class="irene_absolute" style="width: 50%;">
                            <div class="irene_absolute font-weight-bold" style="margin-top:-70px; margin-left:4px; color:#c71a1e; font-size:19px;" >
                                SEPT 19, 2024
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
            <p style="margin-top:0px;"></p>
            {{-- NOTES DETAILS --}}
            <table class="irene-table" cellspacing='0' cellpadding="2" style="border-collapse: collapse;border:2px solid black; width:100%;">
                <thead>
                    <tr> 
                        <td class="irene-100 text-center font-weight-bold" colspan="5" style="background-color:#c0c0c0;">NOTES</td>
                    </tr>
                    <tr style="font-size:12px; ">
                        <th class="irene-20 font-weight-bold text-center">PIC</th>
                        <th class="irene-20 font-weight-bold text-center">QA/QC</th>
                        <th class="irene-20 font-weight-bold text-center">Production Supervisor</th>
                        <th class="irene-20 font-weight-bold text-center">Warehouse</th>
                        <th class="irene-20 font-weight-bold text-center">Production Manager</th>
                    </tr>
                </thead>
                <tbody>
                   
                  
                    <tr>
                        <td class="irene-20 font-weight-bold text-center" style="font-size: 12px;">
                            <img src="{{asset('images/test_sig.png')}}" style="width: 100px;"><br>
                            CEFRIAN TRINCHERA
                        </td>
                        <td class="irene-20 font-weight-bold text-center" style="font-size: 12px;">
                            <img src="{{asset('images/test_sig.png')}}" style="width: 100px;"><br>
                            CEFRIAN TRINCHERA
                        </td>
                        <td class="irene-20 font-weight-bold text-center" style="font-size: 12px;">
                            <img src="{{asset('images/test_sig.png')}}" style="width: 100px;"><br>
                            CEFRIAN TRINCHERA
                        </td>
                        <td class="irene-20 font-weight-bold text-center" style="font-size: 12px;">
                            <img src="{{asset('images/test_sig.png')}}" style="width: 100px;"><br>
                            CEFRIAN TRINCHERA
                        </td>
                        <td class="irene-20 font-weight-bold text-center" style="font-size: 12px;">
                            <img src="{{asset('images/test_sig.png')}}" style="width: 100px;"><br>
                            CEFRIAN TRINCHERA
                        </td>
                    </tr>
                </tbody>
               
            </table>
            <br>
            <p class="font-weight-bold" style="text-align: right; font-size:9px;">{{$tag->control_no}} {{$tag->revision_number}}</p>
        </div>
        <script src="https://printjs-4de6.kxcdn.com/print.min.js" crossorigin="anonymous"></script>
        <script>
            function irene(){
                printJS({
                printable: 'printJS-form',
                type: 'html',
                css: [
                    '{{asset("css/tos.css")}}'
                ],
                scanStyles: false
            })
            }
        </script>
    </body>
</html>