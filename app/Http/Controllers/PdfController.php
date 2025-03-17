<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use PDF; 
use Auth;
use App\Models\QcTag;
use App\Models\QcUser;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PdfController extends Controller
{   

    public function test_quarantine(){
        $print = 'pdf.test_quarantine';
        $font = 'arial';
        $position = 'portrait';
        $tag = QcTag::where('id',1)->first();
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print,compact('tag'))->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('test.pdf',array('Attachment' => false));
    }

    public function print(Request $request){
        $user_name = $request->input('user_name');
        $ids = $request->input('ids');
        $irene = $this->print_now($ids);
        $status = $request->input('tag');
        $print = 'pdf.tag';
        $font = 'arial';
        $position = 'portrait';
        $tag = QcTag::where('title',strtoupper($status))->first();

        $qc_user_1 = $request->input('qc_user_1');
        $qc_user_2 = $request->input('qc_user_2');

        $qc_user_1_row = QcUser::where('id',$qc_user_1)->first();
        $qc_user_2_row = QcUser::where('id',$qc_user_2)->first();
       
        $api_url = env('API_URL');
        $response = Http::post($api_url.'/Pallet/GetPalletByIds',$ids);
        $pallets =  $response->object();
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print,compact('tag','pallets','user_name','qc_user_1_row','qc_user_2_row'))->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);
        
        return base64_encode($pdf->output());
        
    }

    public function print_now($ids){

    }

    public function print_pdf_advance($job_id,$pallet_count,$date){
        $id =$job_id;
        $pallet_count = $pallet_count;
        $date = $date;
        $tag = QcTag::where('id',1)->first();
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/Pallet/PalletAdvancePrinting?iJobNo='.$id.'&iPalletCount='.$pallet_count.'&dDate='.$date);
        $pallets =  $response->object();

        $user = Auth::user();
        $user_name = $user->name;

        $print = 'pdf.tag2';
        $font = 'arial';
        $position = 'portrait';

        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print,compact('tag','pallets','user_name'))->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);
        
        return base64_encode($pdf->output());
    }

    public function test_tos(){
        $print = 'pdf.test_tos';
        $font = 'arial';
        $position = 'portrait';
       
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print)->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('test.pdf',array('Attachment' => false));
    }

    public function turnover_form($id,$flag){
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/TOS/GetTOSDetailsPrint?id='.$id);
        $fields =  $response->object();
        $tos_ref = $fields->cTOSRefNo;
        $user_auth = Auth::user();
       
        // DETAILS
        $jobs[] = 'Job No(s)';
        $skus[] = 'SKU';
        $batchs[] = 'Batch No(s)';
        $mfg_dates[] = 'Manufacturing Date(s)';
        $exp_dates[] = 'Expiry Dates(s)';
        $pallet_counts[] = 'Pallet Quantity';
        $loose_case[] = 'Loose Case Quantity';
        $cases[] = 'Total Quantity (Cases)';
        $references[] = 'QA/QC Reference';
        $coas = []; 
        $stock_codes = [];
        $long_desc = [];

        foreach($fields->details as $detail):
            $jobs[] = $detail->iJobNo;
            $skus[] = $detail->cStockCode;
            $batchs[] = $detail->cLotNumber;
            $mfg_dates[] = Carbon::parse($detail->dMfgDate)->format('y-M-d');
            $exp_dates[] = Carbon::parse($detail->dExpDate)->format('y-M-d');
            $pallet_counts[] = $detail->iPalletCount;
            $loose_case[] = 0;
            $cases[] = $detail->iCases;
            $references[] = $detail->refNo;
            $coas[] = $detail->cCoaRefNo;
            $stock_codes[] = $detail->cStockCode;
            $long_desc[] = $detail->cLongDesc;
        endforeach;

        for($x = count($jobs); $x <= 5; $x++):
            $jobs[] = '';
            $skus[] = '';
            $batchs[] = '';
            $mfg_dates[] = '';
            $exp_dates[] = '';
            $pallet_counts[] = '';
            $loose_case[] = '';
            $cases[] = '';
            $references[] = '';
            $coas[] = '';
            $stock_codes[] = '';
            $long_desc[] = '';
        endfor;
        
        $job_details = (object)array(
            'jobs'=>$jobs,
            'skus'=>$skus,
            'batchs'=>$batchs,
            'mfg_dates'=>$mfg_dates,
            'exp_dates'=>$exp_dates,
            'pallet_counts'=>$pallet_counts,
            'loose_case'=>$loose_case,
            'cases'=>$cases,
            'references'=>$references
        );
        // END DETAILS

        $job_post = array_filter(array_unique($jobs));
        $stock_code_post = array_filter($stock_codes);
        $long_desc_post = array_filter($long_desc);
        // TURNOVER DETAILS
        $turnover_details = (object)array(
            'date'=>Carbon::parse($fields->dCreatedDate)->format('M d, Y'),
            'time'=>Carbon::parse($fields->dCreatedDate)->format('h:i a'),
            'location'=>'Holding Area',
            'pallet_count'=>array_sum($pallet_counts),
            'created_by'=>$fields->cCreatedBy,
            'approved_by'=>$fields->cApprovedBy,
            'approved_date'=>Carbon::parse($fields->dApprovedDate)->format('M d, Y'),
            'for_turnover'=>$fields->cForTurnover,
            'for_turnover_date'=>Carbon::parse($fields->dForTurnoverDate)->format('M d, Y'),
            'validated_by'=>$fields->cValidatedBy,
            'validated_by_date'=>Carbon::parse($fields->dValidatedDate)->format('M d, Y'),
            'received_by'=>$fields->cReceivedBy,
            'received_by_date'=>Carbon::parse($fields->dReceivedBy)->format('M d, Y'),
            'is_warehouse'=>$user_auth->is_warehouse,
            'tos_ref'=>$tos_ref,
            'job'=> $job_post,
            'stock_code'=>$stock_code_post[0],
            'long_desc'=>$long_desc_post[0],
        );
        // END TURNOVER DETAILS

        // REMARKS 
        $job_check = array_filter($jobs);
        $remarks = [];
        $total_remark = (object)array(
            'batch_no'=>'Total:',
            'cases_qty' =>array_sum($cases),
            'coa' =>'Micro Result'
        );
        for($y = 1; $y <= count($job_check)-1; $y++):
            $remarks[] = (object)array(
                'job'=>$jobs[$y],
                'batch_no'=>$batchs[$y],
                'cases_qty'=>$cases[$y],
                'cases'=>'cases',
                'coa' =>$coas[$y]
            );
        endfor;
        // END REMARKS

        $print = 'pdf.tos';
        $font = 'arial';
        $position = 'portrait';
        
        $tag = QcTag::where('id',4)->first();

        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print,compact('job_details','turnover_details','remarks','total_remark','tag'))->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);

        if($flag==1):
            return $pdf->stream('tos-'.$tos_ref.'.pdf',array('Attachment' => false));

        else:
            return base64_encode($pdf->output());
        endif;
        
    }

    public function turnover_form1($id,$flag){
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/TOS/GetTOSDetailsPrint?id='.$id);
        $fields =  $response->object();
        $tos_ref = $fields->cTOSRefNo;
        $user_auth = Auth::user();
   
        // DETAILS
        $jobs[] = 'Job No(s)';
        $skus[] = 'SKU';
        $batchs[] = 'Batch No(s)';
        $mfg_dates[] = 'Manufacturing Date(s)';
        $exp_dates[] = 'Expiry Dates(s)';
        $pallet_counts[] = 'Pallet Quantity';
        $loose_case[] = 'Loose Case Quantity';
        $cases[] = 'Total Quantity (Cases)';
        $references[] = 'QA/QC Reference';
        $coas []= 'COAS'; 
        $stock_codes = [];
        $long_desc = [];

        foreach($fields->details as $detail):
            $jobs[] = $detail->iJobNo;
            $skus[] = $detail->cStockCode;
            $batchs[] = $detail->cLotNumber;
            $mfg_dates[] = Carbon::parse($detail->dMfgDate)->format('y-M-d');
            $exp_dates[] = Carbon::parse($detail->dExpDate)->format('y-M-d');
            $pallet_counts[] = $detail->iPalletCount;
            $loose_case[] = $detail->iLossCase;
            $cases[] = $detail->iCases;
            $references[] = $detail->refNo;
            $coas[] = $detail->cCoaRefNo;
            $stock_codes[] = $detail->cStockCode;
            $long_desc[] = $detail->cLongDesc;
        endforeach;
        

        for($x = count($jobs); $x <= 5; $x++):
            $jobs[] = '';
            $skus[] = '';
            $batchs[] = '';
            $mfg_dates[] = '';
            $exp_dates[] = '';
            $pallet_counts[] = '';
            $loose_case[] = '';
            $cases[] = '';
            $references[] = '';
            $coas[] = '';
            $stock_codes[] = '';
            $long_desc[] = '';
        endfor;
        
        $job_details = (object)array(
            'jobs'=>$jobs,
            'skus'=>$skus,
            'batchs'=>$batchs,
            'mfg_dates'=>$mfg_dates,
            'exp_dates'=>$exp_dates,
            'pallet_counts'=>$pallet_counts,
            'loose_case'=>$loose_case,
            'cases'=>$cases,
            'references'=>$references
        );
        // END DETAILS

        $job_post = array_filter(array_unique($jobs));
        $stock_code_post = array_filter($stock_codes);
        $long_desc_post = array_filter($long_desc);
        // TURNOVER DETAILS
        if($fields->dReceivedDate == null):
            $received_date = $fields->dReceivedDate = '';
        else:
            $received_date = Carbon::parse($fields->dReceivedDate)->format('h:i a');
        endif;
        $turnover_details = (object)array(
            'id'=>$fields->id,
            'date'=>Carbon::parse($fields->dCreatedDate)->format('M d, Y'),
            'time'=>$received_date,
            'location'=>'Holding Area',
            'pallet_count'=>array_sum($pallet_counts),
            'created_by'=>$fields->cCreatedBy,
            'created_by_signature'=> $fields->cCreatedSig,
            'approved_by'=>$fields->cApprovedBy,
            'approved_date'=>Carbon::parse($fields->dApprovedDate)->format('M d, Y'),
            'approved_by_signature'=> $fields->cApprovedSig,
            'for_turnover'=>$fields->cForTurnover,
            'for_turnover_date'=>Carbon::parse($fields->dForTurnoverDate)->format('M d, Y'),
            'for_turnover_by_signature'=> $fields->cForTurnoverSig,
            'validated_by'=>$fields->cValidatedBy,
            'validated_by_date'=>Carbon::parse($fields->dValidatedDate)->format('M d, Y'),
            'validated_by_signature'=>$fields->cValidatedSig,
            'received_by'=>$fields->cReceivedBy,
            'received_by_date'=>Carbon::parse($fields->dReceivedDate)->format('M d, Y'),
            'received_signature'=>$fields->cReceivedSig,
            'is_warehouse'=>$user_auth->is_warehouse,
            'tos_ref'=>$tos_ref,
            'job'=> $job_post,
            'stock_code'=>$stock_code_post[0],
            'long_desc'=>$long_desc_post[0],
        );
        // END TURNOVER DETAILS

        // REMARKS 
        $job_check = array_filter($jobs);
        $remarks = [];
        $total_remark = (object)array(
            'batch_no'=>'Total:',
            'cases_qty' =>array_sum($cases),
            'coa' =>'Micro Result'
        );
        for($y = 1; $y <= count($job_check)-1; $y++):
            $remarks[] = (object)array(
                'job'=>$jobs[$y],
                'batch_no'=>$batchs[$y],
                'cases_qty'=>$cases[$y],
                'cases'=>'cases',
                'coa' =>$coas[$y]
            );
        endfor;
        // END REMARKS
       
        $print = 'pdf.tos';
        $font = 'arial';
        $position = 'portrait';
        
        $tag = QcTag::where('id',4)->first();
        $user = Auth::user();
        return view('pdf.tos1',compact('job_details','turnover_details','remarks','total_remark','tag','user'));
    }

    public function static_report1(){
        return view('pdf.test_report1');
    }

    public function downtime_report($id){
        $api_url = env('API_URL');
        $response = Http::post($api_url.'/Pallet/GetPalletByIds',$id);
        $pallets =  $response->object();
    }

    public function downtime_report_job($job){
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/Downtime/GetDowntimeHeaders?iJobNo='.$job);
        $headers =  $response->object();    
     
        // JO TARGET QUANTITY
        $response = Http::get($api_url.'/Production/GetJobSysproDetails?ijob='.$job);
        $jobs = $response->object();
        foreach($jobs as $job_row):
            $long_desc_remove  = $job_row->cLongDesc;
            $part = explode("X", $long_desc_remove);
            $conv_factor = trim($part[1]);
            $stock_code=$job_row->cStockCode;
            $jo_details = array(
                'cases' => $job_row->nQtyToMake,
                'bottle'=> $job_row->nQtyToMake * $conv_factor,
                'stock_code'=>$job_row->cStockCode
            ); 
        endforeach;
        // END JO TARGET QUANTITY
        foreach($headers as $header):
            $iLineId = $header->iLineId;
            $iDowntimeHeaderId = $header->id;
            $dCountDate = $header->dDate;
          
            $fbo[] =Carbon::parse($header->dFBO)->format('H:ia');
            $lbo[] =Carbon::parse($header->dLBO)->format('H:ia');

            $date[] = Carbon::parse($header->dDate)->format('d-M');
            $iShiftLength[] = $header->iShiftLength;
            
            $response_details = Http::get($api_url.'/Downtime/GetDowntimeDetails?iDowntimeHeaderId='.$iDowntimeHeaderId.'&iLineId='.$iLineId.'&dCountDate='.$dCountDate.'&iJobNo='.$job);
            $details = $response_details->object();   

            $total_machine_downtime = 0;
            $total_expected_downtime = 0;
            $total_unexpected_downtime = 0;
            
            // MACHINE DOWNTIME
            foreach($details->machineDowntime as $machineDowntime):
                $total_machine_downtime += $machineDowntime->iMinute;
                if($machineDowntime->downtimeTypeId == '1'):
                    $md_1[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '2'):
                    $md_2[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '3'):
                    $md_3[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '4'):
                    $md_4[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '5'):
                    $md_5[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '6'):
                    $md_6[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '7'):
                    $md_7[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '8'):
                    $md_8[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '9'):
                    $md_9[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '10'):
                    $md_10[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '11'):
                    $md_11[] = $machineDowntime->iMinute;
                elseif($machineDowntime->downtimeTypeId == '12'):
                    $md_12[] = $machineDowntime->iMinute;
                endif;
            endforeach;
            $md = (object)array(
                'md_1'=>$md_1,
                'md_2'=>$md_2,
                'md_3'=>$md_3,
                'md_4'=>$md_4,
                'md_5'=>$md_5,
                'md_6'=>$md_6,
                'md_7'=>$md_7,
                'md_8'=>$md_8,
                'md_9'=>$md_9,
                'md_10'=>$md_10,
                'md_11'=>$md_11,
                'md_12'=>$md_12,
            );
            // END MACHINE DOWNTIME
        
            // EXPECTED DOWNTIME
            foreach($details->expectedDowntime as $expectedDowntime):
                $total_expected_downtime += $expectedDowntime->iMinute;
                if($expectedDowntime->downtimeTypeId == '13'):
                    $ed_1[] = $expectedDowntime->iMinute;
                elseif($expectedDowntime->downtimeTypeId == '14'):
                    $ed_2[] = $expectedDowntime->iMinute;
                elseif($expectedDowntime->downtimeTypeId == '15'):
                    $ed_3[] = $expectedDowntime->iMinute;
                elseif($expectedDowntime->downtimeTypeId == '16'):
                    $ed_4[] = $expectedDowntime->iMinute;
                elseif($expectedDowntime->downtimeTypeId == '17'):
                    $ed_5[] = $expectedDowntime->iMinute;
                elseif($expectedDowntime->downtimeTypeId == '18'):
                    $ed_6[] = $expectedDowntime->iMinute;
                elseif($expectedDowntime->downtimeTypeId == '19'):
                    $ed_7[] = $expectedDowntime->iMinute;
                endif;
            endforeach;
            $ed = (object)array(
                'ed_1'=>$ed_1,
                'ed_2'=>$ed_2,
                'ed_3'=>$ed_3,
                'ed_4'=>$ed_4,
                'ed_5'=>$ed_5,
                'ed_6'=>$ed_6,
                'ed_7'=>$ed_7,
            );
            // END EXPECTED DOWNTIME

            // EXPECTED DOWNTIME
            foreach($details->unexpectedDowntime as $unexpectedDowntime):
                $total_unexpected_downtime += $unexpectedDowntime->iMinute;
                if($unexpectedDowntime->downtimeTypeId == '20'):
                    $ued_1[] = $unexpectedDowntime->iMinute;
                elseif($unexpectedDowntime->downtimeTypeId == '21'):
                    $ued_2[] = $unexpectedDowntime->iMinute;
                elseif($unexpectedDowntime->downtimeTypeId == '22'):
                    $ued_3[] = $unexpectedDowntime->iMinute;
                elseif($unexpectedDowntime->downtimeTypeId == '23'):
                    $ued_4[] = $unexpectedDowntime->iMinute;
                elseif($unexpectedDowntime->downtimeTypeId == '24'):
                    $ued_5[] = $unexpectedDowntime->iMinute;
                elseif($unexpectedDowntime->downtimeTypeId == '25'):
                    $ued_6[] = $unexpectedDowntime->iMinute;
                elseif($unexpectedDowntime->downtimeTypeId == '26'):
                    $ued_7[] = $unexpectedDowntime->iMinute;
                endif;
            endforeach;

            $ued = (object)array(
                'ued_1'=>$ued_1,
                'ued_2'=>$ued_2,
                'ued_3'=>$ued_3,
                'ued_4'=>$ued_4,
                'ued_5'=>$ued_5,
                'ued_6'=>$ued_6,
                'ued_7'=>$ued_7,
            );

            $total_machine_downtime_post[] = $total_machine_downtime;
            $total_expected_downtime_post[] = $total_expected_downtime;
            $total_unexpected_downtime_post[] = $total_unexpected_downtime;

            // DETAILS
            $cases_check = $details->cases;
            $pallets_check = $details->palletCount;
            $cycle_time_check = $details->idealCycleTime;
            $machine_count_check = $details->machineCount;
            $pcs_case_check = $details->pcsCase;
            $bottles_check = $details->pcsCase * $details->cases;

            $total_cases[] = $cases_check;
            $total_pallets[] = $pallets_check;
            $total_cycle_time[] = $cycle_time_check;
            $total_machine_count[] = $machine_count_check;
            $total_pcs_case[] = $pcs_case_check;
            $total_bottles[] = $bottles_check;
           
            // Planned Production Time, mins = Shift Length - Expected Downtime;
            $planned_production_time_check = $header->iShiftLength-$total_expected_downtime;
            $planned_production_time[] = $planned_production_time_check;
            
            // Operating Time, mins = Planned Production Time - Unexpected Downtime;
            $operating_time_create = $planned_production_time_check - $total_unexpected_downtime;
            $operating_time[] = $operating_time_create;

            // % Machine Downtime = (Machine Declated Downtime / Operating time, mins) * 100
            $machine_downtime_check = ($total_machine_downtime/$operating_time_create)*100;
            $machine_downtime[] = $machine_downtime_check;

            // Expected Output, Bottles = Operating Time, mins * Ideal Cycle Time, Btls/min
            $expected_output_check = $planned_production_time_check * $cycle_time_check;
            $expected_output[] = $expected_output_check;

            // Machine Actual Downtime, mins = (Expected Output - Total FG Bottles) / Cycle Time  
            $machine_actual_check = ($expected_output_check - $bottles_check) / $cycle_time_check;
            $machine_actual[] = $machine_actual_check;

            // Variance = Machine Declated Downtime, mins - Machine Actual Downtime, mins
            $downtime_variance_check = $total_machine_downtime - $machine_actual_check;
            $downtime_variance[] = $downtime_variance_check;

            // Running Time, mins = FG Bottles / Ideal Cycle Time, btls/min
            $running_time_check = $bottles_check / $cycle_time_check;
            $running_time[] = $running_time_check;
            
            // Machine Counter rdg, bottles = Machine Count * pcsCase
            $rdg_machine_check = $machine_count_check * $pcs_case_check;  
            $rdg_machine[] = $rdg_machine_check;

            //Availability = Operating Time, mins /  Planned Production Time, mins
            $availability_check = ($operating_time_create/$planned_production_time_check)*100;
            $availability[] =  $availability_check;

            // Performance(%) = Running Time,mins / Operating Time, mins
            $performance_check = (round($running_time_check,0)/$operating_time_create) * 100;
            $performance[] = $performance_check;

            // Quality = Total FG, Bottles / Machine Counter rdg, Bottles
            $quality_check = ($bottles_check/$rdg_machine_check) * 100;
            $quality[] = $quality_check;

            // OEEE = ((Performance(%)/100) * (Quality(%)/100) * (Availability(%)/100)) * 100  
            $oeee_check = ((round($performance_check,2)/100) * (round($quality_check,2)/100) * (round($availability_check,2)/100))*100;
            $oeee[] = round($oeee_check,2);
        endforeach;
        
        $data_headers = (object)array(
            'dates'=>$date,
            'stock_code'=>$stock_code,
            'shift_lengths'=>$iShiftLength,
            'expecteds'=>$total_expected_downtime_post,
            'unexpecteds'=>$total_unexpected_downtime_post,
            'planned_production_times'=>$planned_production_time,
            'operating_times'=> $operating_time,
            'machines_declared'=>$total_machine_downtime_post,
            'machine_downtimes'=>$machine_downtime,
            'machine_actuals'=>$machine_actual,
            'downtime_variances'=>$downtime_variance,
            'running_times'=>$running_time,
            'total_bottles'=>$total_bottles,
            'total_cases'=>$total_cases,
            'total_pallets'=>$total_pallets,
            'rdg_machines'=>$rdg_machine,
            'cycle_times'=>$total_cycle_time,
            'expected_outputs'=>$expected_output,
            'availabilities'=>$availability,
            'performances'=>$performance,
            'qualities'=>$quality,
            'oeees'=>$oeee,
            'fbo'=>$fbo,
            'lbo'=>$lbo,
        );
     
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>'Arial'])
        ->loadView('pdf.downtime',compact('data_headers','md','ed','ued','job'))->setPaper('LETTER', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('job-'.$job.'.pdf',array('Attachment' => false));
       
    }

}
