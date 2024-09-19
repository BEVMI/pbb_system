<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; 
use Auth;
use App\Models\QcTag;
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

        $api_url = env('API_URL');
        $response = Http::post($api_url.'/Pallet/GetPalletByIds',$ids);
        $pallets =  $response->object();
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print,compact('tag','pallets','user_name'))->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return base64_encode($pdf->output());
        
    }

    public function print_now($ids){

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

    public function turnover_form($id){
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
            'tos_ref'=>$tos_ref
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
       
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print,compact('job_details','turnover_details','remarks','total_remark'))->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('tos-'.$tos_ref.'.pdf',array('Attachment' => false));
    }
}
