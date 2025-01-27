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
    <body style="font-size:9px;">
        <table class="table">
            <tr>
                <td class="w-30 border-top border-left">Date</td>
                @foreach ($data_headers->dates as $date)
                    <td class="irene-td border-top border-left border-right border-bottom w-10">{{$date}}</td>
                @endforeach
                <td class="irene-td w-10 border-top border-left border-right border-bottom" rowspan="4" style="vertical-align: middle;">JOB - {{$job}}</td>
            </tr>
            <tr>
                <?php $count = count($data_headers->dates);?>
                <td class="w-30 border-left border-bottom">SKU</td>
                <td class="irene-td-center w-10  border-left border-bottom" colspan="{{$count}}">{{$data_headers->stock_code}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-bottom">FBO</td>
                @foreach ($data_headers->fbo as $fbo_row)
                    <td class="irene-td-center w-10  border-left border-bottom" colspan="{{$count}}">{{$fbo_row}}</td>
                @endforeach
            </tr>

            <tr>
                <td class="w-30 border-left border-bottom">LBO</td>
                @foreach ($data_headers->lbo as $lbo_row)
                    <td class="irene-td-center w-10  border-left border-bottom" colspan="{{$count}}">{{$lbo_row}}</td>
                @endforeach
            </tr>

            <tr>
                <td class="w-30 border-left border-right">Shift Length</td>
                @foreach ($data_headers->shift_lengths as $shift_length)
                    <td class="irene-td w-10 border-right">{{$shift_length}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{array_sum($data_headers->shift_lengths)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Expected Oprl Downtime, mins</td>
                @foreach ($data_headers->expecteds as $expected)
                    <td class="irene-td w-10 border-right">{{$expected}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{array_sum($data_headers->expecteds)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Unexpected Oprl Downtime, mins</td>
                @foreach ($data_headers->unexpecteds as $unexpected)
                    <td class="irene-td w-10 border-right">{{$unexpected}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{array_sum($data_headers->unexpecteds)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Planned Production Time, mins</td>
                @foreach ($data_headers->planned_production_times as $planned_production_time)
                    <td class="irene-td w-10 border-right">{{$planned_production_time}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{array_sum($data_headers->planned_production_times)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Operating Time, mins</td>
                @foreach ($data_headers->operating_times as $operating_time)
                    <td class="irene-td w-10 border-right">{{$operating_time}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{array_sum($data_headers->operating_times)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Machine Declared Downtime, mins</td>
                @foreach ($data_headers->machines_declared as $machines_declared_row)
                    <td class="irene-td w-10 border-right">{{$machines_declared_row}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{array_sum($data_headers->machines_declared)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">% Machine Downtime</td>
                @foreach ($data_headers->machine_downtimes as $machine_downtime)
                    <td class="irene-td w-10 border-right">{{round($machine_downtime,2)}}%</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->machine_downtimes)/2,2)}}%</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Machine Actual Downtime</td>
                @foreach ($data_headers->machine_actuals as $machine_actual)
                    <td class="irene-td w-10 border-right">{{round($machine_actual,0)}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->machine_actuals),0)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Downtime Variance</td>
                @foreach ($data_headers->downtime_variances as $downtime_variance)
                    <td class="irene-td w-10 border-right" style="color: red;">{{round($downtime_variance,0)}}%</td>
                @endforeach
                <td class="irene-td w-10 border-right" style="color: red;">{{round(array_sum($data_headers->downtime_variances),0)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right border-bottom">Running Time,mins</td>
                @foreach ($data_headers->running_times as $running_time)
                    <td class="irene-td w-10 border-bottom border-right">{{round($running_time,0)}}</td>
                @endforeach
                <td class="irene-td w-10 border-right border-bottom">{{round(array_sum($data_headers->running_times),0)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Total FG, bottles</td>
                @foreach ($data_headers->total_bottles as $total_bottle)
                    <td class="irene-td w-10 border-right">{{round($total_bottle,0)}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->total_bottles),0)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Total FG, cases</td>
                @foreach ($data_headers->total_cases as $total_case)
                    <td class="irene-td w-10 border-right">{{round($total_case,0)}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->total_cases),0)}}</td>
            </tr>
        
            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Total FG, pallets</td>
                @foreach ($data_headers->total_pallets as $total_pallet)
                    <td class="irene-td w-10 border-right border-bottom" style="border-right: 1px solid black;">{{round($total_pallet,2)}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($data_headers->total_pallets),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right">Machine Counter rdg, bottles</td>
                @foreach ($data_headers->rdg_machines as $rdg_machine)
                    <td class="irene-td w-10 border-right">{{round($rdg_machine,0)}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->rdg_machines),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right">Ideal Cycle Time, btls/min</td>
                @foreach ($data_headers->cycle_times as $cycle_time)
                    <td class="irene-td w-10 border-right">{{round($cycle_time,0)}}</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->cycle_times),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Expected Output, bottles</td>
                @foreach ($data_headers->expected_outputs as $expected_output)
                    <td class="irene-td w-10 border-right border-bottom" style="border-right: 1px solid black;">{{round($expected_output,2)}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($data_headers->expected_outputs),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right">Availability(%)</td>
                @foreach ($data_headers->availabilities as $availability)
                    <td class="irene-td w-10 border-right">{{round($availability,0)}}%</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->availabilities),0)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Performance(%)</td>
                @foreach ($data_headers->performances as $performance)
                    <td class="irene-td w-10 border-right">{{round($performance,0)}}%</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->performances),0)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right">Quality(%)</td>
                @foreach ($data_headers->qualities as $quality)
                    <td class="irene-td w-10 border-right">{{round($quality,0)}}%</td>
                @endforeach
                <td class="irene-td w-10 border-right">{{round(array_sum($data_headers->qualities),0)}}</td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">OEE(%)</td>
                @foreach ($data_headers->oeees as $oeee)
                    <td class="irene-td w-10 border-right border-bottom" style="border-right: 1px solid black;">{{round($oeee,2)}}%</td>
                @endforeach
                <td class="irene-td w-10 text-white border-bottom border-right" style="background-color:rgb(216, 85, 85); 1px solid black;">{{round(array_sum($data_headers->oeees),2)/$count}}%</td>
            </tr>
            <tr>
                <td class="border-bottom border-left"></td>
                <td colspan="{{$count}}" class="text-white border-bottom border-top">-</td>
                <td class="border-bottom border-right"></td>
            </tr>
            <tr>
                <td class="border-bottom border-left"></td>
                <td colspan="{{$count}}" class="font-weight-bolf border-bottom border-top">MACHINE DOWNTIME,mins.</td>
                <td class="border-bottom border-right"></td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Blowing</td>
                @foreach ($md->md_1 as $md_1)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_1}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_1),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Filer/capper</td>
                @foreach ($md->md_2 as $md_2)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_2}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_2),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">FT System</td>
                @foreach ($md->md_3 as $md_3)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_3}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_3),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Labeler</td>
                @foreach ($md->md_4 as $md_4)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_4}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_4),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Conveyor</td>
                @foreach ($md->md_5 as $md_5)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_5}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_5),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Shrinkwrapper</td>
                @foreach ($md->md_6 as $md_6)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_6}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_6),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Packs Coder</td>
                @foreach ($md->md_7 as $md_7)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_7}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_7),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Palletizer</td>
                @foreach ($md->md_8 as $md_8)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_8}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_8),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Ro Water Treatment</td>
                @foreach ($md->md_9 as $md_9)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_9}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_9),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">LP Air Compressor</td>
                @foreach ($md->md_10 as $md_10)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_10}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_10),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">HP Air Compressor</td>
                @foreach ($md->md_11 as $md_11)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_11}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_11),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Electrical</td>
                @foreach ($md->md_12 as $md_12)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$md_12}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($md->md_12),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Total</td>
                @foreach ($data_headers->machines_declared as $machines_declared_row)
                    <td class="irene-td w-10 border-right border-bottom" style="border-right: 1px solid black;">{{$machines_declared_row}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($data_headers->machines_declared),0)}}</td>
            </tr>

            <tr>
                <td class="border-bottom border-left"></td>
                <td colspan="{{$count}}" class="text-white border-bottom border-top">-</td>
                <td class="border-bottom border-right"></td>
            </tr>
            <tr>
                <td class="border-bottom border-left"></td>
                <td colspan="{{$count}}" class="font-weight-bolf border-bottom border-top">Expected Operational DOWNTIME,mins.</td>
                <td class="border-bottom border-right"></td>
            </tr>
            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Blowing</td>
                @foreach ($ed->ed_1 as $ed_1)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ed_1}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ed->ed_1),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Filer/capper</td>
                @foreach ($ed->ed_2 as $ed_2)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ed_2}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ed->ed_2),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">FT System</td>
                @foreach ($ed->ed_3 as $ed_3)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ed_3}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ed->ed_3),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Labeler</td>
                @foreach ($ed->ed_4 as $ed_4)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ed_4}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ed->ed_4),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Conveyor</td>
                @foreach ($ed->ed_5 as $ed_5)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ed_5}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ed->ed_5),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Shrinkwrapper</td>
                @foreach ($ed->ed_6 as $ed_6)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ed_6}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ed->ed_6),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Packs Coder</td>
                @foreach ($ed->ed_7 as $ed_7)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ed_7}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ed->ed_7),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Total</td>
                @foreach ($data_headers->expecteds as $expected)
                    <td class="irene-td w-10 border-right border-bottom" style="border-right: 1px solid black;">{{$expected}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($data_headers->expecteds),0)}}</td>
            </tr>

            <tr>
                <td class="border-bottom border-left"></td>
                <td colspan="{{$count}}" class="text-white border-bottom border-top">-</td>
                <td class="border-bottom border-right"></td>
            </tr>
            <tr>
                <td class="border-bottom border-left"></td>
                <td colspan="{{$count}}" class="font-weight-bolf border-bottom border-top">Unexpected Operational DOWNTIME,mins.</td>
                <td class="border-bottom border-right"></td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Blowing</td>
                @foreach ($ued->ued_1 as $ued_1)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ued_1}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ued->ued_1),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Filer/capper</td>
                @foreach ($ued->ued_2 as $ued_2)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ued_2}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ued->ued_2),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">FT System</td>
                @foreach ($ued->ued_3 as $ued_3)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ued_3}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ued->ued_3),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Labeler</td>
                @foreach ($ued->ued_4 as $ued_4)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ued_4}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ued->ued_4),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Conveyor</td>
                @foreach ($ued->ued_5 as $ued_5)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ued_5}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ued->ued_5),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Shrinkwrapper</td>
                @foreach ($ued->ued_6 as $ued_6)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ued_6}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ued->ued_6),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Packs Coder</td>
                @foreach ($ued->ued_7 as $ued_7)
                    <td class="irene-td w-10 border-right border-bottom blue_background" style="border-right: 1px solid black;">{{$ued_7}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($ued->ued_7),0)}}</td>
            </tr>

            <tr>
                <td class="w-30 border-left border-right border-bottom" style="border-right: 1px solid black;">Total</td>
                @foreach ($data_headers->unexpecteds as $unexpected)
                    <td class="irene-td w-10 border-right border-bottom" style="border-right: 1px solid black;">{{$unexpected}}</td>
                @endforeach
                <td class="irene-td w-10 border-bottom border-right" style="border-right: 1px solid black;">{{round(array_sum($data_headers->unexpecteds),0)}}</td>
            </tr>
            
        </table>
    </body>
</html>