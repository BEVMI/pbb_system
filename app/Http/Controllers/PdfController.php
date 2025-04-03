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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Percentage;

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
        $response = Http::get($api_url.'/Downtime/DowntimeReports?iJobNo='.$job);
        $datas =  $response->object();    
        $data = (object) array(
            'id' => 'Id',
            'lineId' => 'Line Id',
            'line' => 'Line',
            'shiftLength' => 'Shift Length, mins',
            'downtimeDate' => 'Date',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'jobNo' => 'Job No',
            'stockCode' => 'SKU',
            'description' => 'Description',
            'longDesc' => 'Long Description',
            'cases' => 'Total FG, cases',
            'palletCount' => 'Total FG, Pallets',
            'machineCount'=>'Machine Counter rdg. Bottles',
            'idealCycleTime' => 'Ideal Cycle Time',
            'pcsCase' => 'Pcs/Case',
            'fbo' => 'FBO',
            'lbo' => 'LBO',
            'totalMachineDowntime' => 'Machine Declared Downtime, mins',
            'totalExpectedDowntime' => 'Expected Oprl Downtime, mins',
            'totalUnExpectedDowntime' => 'Unexpected Oprl Downtime, mins',
            'planedProductionTime' => 'Planned Production Time, mins',
            'operatingTime' => 'Operating Time, mins',
            'machineDowntimeTime' => '% Machine Downtime',
            'expectedOutput' => 'Expected Output Bottles',
            'bottlesCheck'=> 'Total FG Bottles',
            'machineActual'=> 'Machine Actual Downtime',
            'variance'=> 'Downtime Variance',
            'runningTime'=> 'Running Time, mins',
            'machineCounterRdg'=> 'Machine Counter rdg, Bottles',
            'availability' => 'Availability(%)',
            'performance' => 'Performance(%)',
            'quality' => 'Quality(%)',
            'oeee' => 'OEE(%)',
            'machineDowntime' => array(),
            'expectedDowntime' => array(),
            'unexpectedDowntime' => array(),
            'jobCases' => 'Cases',
            'jobPallets' => 'Pallets',
            'jobBottles' => 'Bottles',
            'monthlyCases' => 'Cases',
            'monthlyBottles' => 'Bottles',
            'monthlyPallets' => 'Pallets',

        );
        array_unshift($datas, $data);
        
        $spreadsheet = new Spreadsheet();

        $sheet = 0;
        $count_now = 2;
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex($sheet);
        $spreadsheet->getActiveSheet()->setTitle('PBB DOWNTIME REPORTS');
        $active = $spreadsheet->getActiveSheet('PBB DOWNTIME REPORTS');
        
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

        ];

        $styleCenterArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],

        ];


        $styleArrayAlignmentLeft = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
            ],
        ];

        $styleArrayNoDownLeft= [
            'borders' => [
                'top'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'left'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'right'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],

        ];

        $styleArrayNoUpLeft= [
            'borders' => [
                'bottom'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'left'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'right'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],

        ];

        $styleArrayNoDownRight= [
            'borders' => [
                'top'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'left'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'right'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

        ];

        $styleArrayNoUpRight= [
            'borders' => [
                'bottom'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'left'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'right'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

        ];

        $styleArrayNoTopDownRight= [
            'borders' => [
                'left'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'right'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

        ];
        

        $styleArrayNoTopDownLeft= [
            'borders' => [
                'left'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
                'right'=> [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN//fine border
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],

        ];

        $start = Coordinate::stringFromColumnIndex($count_now+1); 
        $end =  Coordinate::stringFromColumnIndex($count_now+count($datas)-1); 
        $end2 =  Coordinate::stringFromColumnIndex($count_now+count($datas));
        // echo $start.'---'.$end;
        // $spreadsheet->mergeCells($start.'2:'.$end.'2');
        $active->getStyle('B29:'.$end2.'29')->applyFromArray($styleArray);
        $active->setCellValue('B29', '');
        $active->mergeCells('B29:'.$end2.'29');

        $active->getStyle('B30:'.$end2.'30')->applyFromArray($styleCenterArray);
        $active->setCellValue('B30', 'MACHINE DOWNTIME, mins.');
        $active->mergeCells('B30:'.$end2.'30');

        $count_second = 31;
        $count_third = 31;
        $count_machine = 2;
        
        $data_machine = array();
        $count_array = array();
        foreach($datas as $header):
            $count_check = Coordinate::stringFromColumnIndex($count_now); 
            $count_array[] = $count_check ;
            if($count_now == 2):
                $active->getColumnDimension($count_check)->setWidth(35);
                $active->getStyle($count_check.'1')->applyFromArray($styleArrayAlignmentLeft);
                $active->getStyle($count_check.'2')->applyFromArray($styleArrayAlignmentLeft);

                $active->getStyle($count_check.'3')->applyFromArray($styleArrayAlignmentLeft);
                $active->getStyle($count_check.'4')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'5')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'6')->applyFromArray($styleArrayNoUpLeft);

                $active->getStyle($count_check.'7')->applyFromArray($styleArrayNoDownLeft);
                $active->getStyle($count_check.'8')->applyFromArray($styleArrayNoUpLeft);
                $active->getStyle($count_check.'9')->applyFromArray($styleArrayNoDownLeft);
                $active->getStyle($count_check.'10')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'11')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'12')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'13')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'14')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'15')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'16')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'17')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'18')->applyFromArray($styleArrayNoUpLeft);
                $active->getStyle($count_check.'19')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'20')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'21')->applyFromArray($styleArrayNoUpLeft);
                $active->getStyle($count_check.'22')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'23')->applyFromArray($styleArrayNoTopDownLeft);
                $active->getStyle($count_check.'24')->applyFromArray($styleArrayNoUpLeft);
                $active->getStyle($count_check.'25')->applyFromArray($styleArrayNoTopDownLeft)->getNumberFormat()->setFormatCode('0.00%');
                $active->getStyle($count_check.'26')->applyFromArray($styleArrayNoTopDownLeft)->getNumberFormat()->setFormatCode('0.00%');
                $active->getStyle($count_check.'27')->applyFromArray($styleArrayNoTopDownLeft)->getNumberFormat()->setFormatCode('0.00%');
                $active->getStyle($count_check.'28')->applyFromArray($styleArrayNoUpLeft)->getNumberFormat()->setFormatCode('0.00%');
                

                $active->setCellValue($count_check.'2', $header->stockCode);
                $active->setCellValue($count_check.'3', 'JO Target Quantity');
             

                $active->setCellValue($count_check.'7',$header->fbo); 
                $active->setCellValue($count_check.'8',$header->lbo); 
                $active->setCellValue($count_check.'9',$header->shiftLength); 
                $active->setCellValue($count_check.'10',$header->totalExpectedDowntime); 
                $active->setCellValue($count_check.'11',$header->totalUnExpectedDowntime); 
                $active->setCellValue($count_check.'12',$header->planedProductionTime); 
                $active->setCellValue($count_check.'13',$header->operatingTime); 
                $active->setCellValue($count_check.'14',$header->totalMachineDowntime); 
                $active->setCellValue($count_check.'15',$header->machineDowntimeTime);
                $active->setCellValue($count_check.'16',$header->machineActual);  
                $active->setCellValue($count_check.'17',$header->variance);  
                $active->setCellValue($count_check.'18',$header->runningTime);  
                $active->setCellValue($count_check.'19',$header->bottlesCheck);
                $active->setCellValue($count_check.'20',$header->cases);
                $active->setCellValue($count_check.'21',$header->palletCount);
                $active->setCellValue($count_check.'22',$header->machineCount);
                $active->setCellValue($count_check.'23',$header->idealCycleTime);
                $active->setCellValue($count_check.'24',$header->expectedOutput);
                
                $active->setCellValue($count_check.'25',$header->availability);
                $active->setCellValue($count_check.'26',$header->performance);
                $active->setCellValue($count_check.'27',$header->quality);
                $active->setCellValue($count_check.'28',$header->oeee);
            else:
                $job_no = $header->jobNo;
                $active->getColumnDimension($count_check)->setWidth(20);
                $active->getStyle($count_check.'1')->applyFromArray($styleArray);

                $active->getStyle($count_check.'4')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'5')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'6')->applyFromArray($styleArrayNoUpRight);

                $active->getStyle($count_check.'7')->applyFromArray($styleArrayNoDownRight);
                $active->getStyle($count_check.'8')->applyFromArray($styleArrayNoUpRight);
                $active->getStyle($count_check.'9')->applyFromArray($styleArrayNoDownRight);
                $active->getStyle($count_check.'10')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'11')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'12')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'13')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'14')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'15')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'16')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'17')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'18')->applyFromArray($styleArrayNoUpRight);
                $active->getStyle($count_check.'19')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'20')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'21')->applyFromArray($styleArrayNoUpRight);
                $active->getStyle($count_check.'22')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'23')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'24')->applyFromArray($styleArrayNoUpRight);
                $active->getStyle($count_check.'25')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'26')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'27')->applyFromArray($styleArrayNoTopDownRight);
                $active->getStyle($count_check.'28')->applyFromArray($styleArrayNoUpRight);

                $active->setCellValue($count_check.'4',$header->monthlyCases); 
                $active->setCellValue($count_check.'5',$header->monthlyBottles); 
                $active->setCellValue($count_check.'6',$header->monthlyPallets);

                $date_fbo = explode("T",$header->fbo);
                $active->setCellValue($count_check.'7', $date_fbo[1]);

                $date_lbo = explode("T",$header->lbo);
                $active->setCellValue($count_check.'8', $date_lbo[1]);

                $active->setCellValue($count_check.'9',$header->shiftLength); 
                $active->setCellValue($count_check.'10',$header->totalExpectedDowntime); 
                $active->setCellValue($count_check.'11',$header->totalUnExpectedDowntime); 
                $active->setCellValue($count_check.'12',$header->planedProductionTime); 
                $active->setCellValue($count_check.'13',$header->operatingTime); 
                $active->setCellValue($count_check.'14',$header->totalMachineDowntime); 
                $active->setCellValue($count_check.'15',$header->machineDowntimeTime); 
                $active->setCellValue($count_check.'16',$header->machineActual);
                $active->setCellValue($count_check.'17',$header->variance);
                $active->setCellValue($count_check.'18',$header->runningTime);
                $active->setCellValue($count_check.'19',$header->bottlesCheck);
                $active->setCellValue($count_check.'20',$header->cases);
                $active->setCellValue($count_check.'21',$header->palletCount);
                $active->setCellValue($count_check.'22',$header->machineCount);
                $active->setCellValue($count_check.'23',$header->idealCycleTime);
                $active->setCellValue($count_check.'24',$header->expectedOutput);

                $localeCurrencyMask = new Percentage(
                    locale: 'tr_TR'
                );
               
                $active->setCellValue($count_check.'25',round($header->availability/100,2));
                $active->getCell($count_check.'25',round($header->availability,2))
                ->getStyle()->getNumberFormat()
                ->setFormatCode($localeCurrencyMask);

                $active->setCellValue($count_check.'26',round($header->performance/100,2));
                $active->getCell($count_check.'26',round($header->performance,2))
                ->getStyle()->getNumberFormat()
                ->setFormatCode($localeCurrencyMask);

                $active->setCellValue($count_check.'27',round($header->quality/100,2));
                $active->getCell($count_check.'27',round($header->quality,2))
                ->getStyle()->getNumberFormat()
                ->setFormatCode($localeCurrencyMask);

                $active->setCellValue($count_check.'28',round($header->oeee/100,2));
                $active->getCell($count_check.'28',round($header->oeee,2))
                ->getStyle()->getNumberFormat()
                ->setFormatCode($localeCurrencyMask);
            endif;

            if($count_now == 3):
                $active->setCellValue('B4', 'CASES          '.$header->jobCases);
                $active->setCellValue('B5', 'BOTTLES        '.$header->monthlyBottles);
                $active->setCellValue('B6', 'PALLETS        '.$header->monthlyPallets); 

                $active->getStyle($start.'2:'.$end.'2')->applyFromArray($styleArray);
                $active->setCellValue($count_check.'2', $header->stockCode);
                $active->mergeCells($start.'2:'.$end.'2');
            endif;

            if($count_now == 4):
                $active->getStyle($start.'3:'.$end.'3')->applyFromArray($styleArray);
                $active->setCellValue($count_check.'3', '');
                $active->mergeCells($start.'3:'.$end.'3');
            endif;
            // $date = Carbon::createFromFormat('Y-m-d',$header->downtimeDate);
            
            $date = explode("T",$header->downtimeDate);
          
            $active->setCellValue($count_check.'1', $date[0]); 
          
            $count_now++;
           
            foreach($header->machineDowntime as $machine):   
                $active->getStyle('B'.$count_second)->applyFromArray($styleCenterArray);
                $active->setCellValue('B'.$count_second, $machine->description);

                $active->getStyle($count_check.$count_second)->applyFromArray($styleCenterArray);
                $active->setCellValue($count_check.$count_second, $machine->iMinute);
               
                $count_second++;
                $data_machine[] = 'M'.$machine->downtimeTypeId;
            endforeach;
            $count_last_machine = 49;
            // echo $count_last_machine;
            foreach($header->expectedDowntime as $expectedMachine):  
                $active->getStyle('B'.$count_last_machine)->applyFromArray($styleCenterArray);
                $active->setCellValue('B'.$count_last_machine, $expectedMachine->description);

                $active->getStyle($count_check.$count_last_machine)->applyFromArray($styleCenterArray);
                $active->setCellValue($count_check.$count_last_machine, $expectedMachine->iMinute);
               
                $count_last_machine++;
             
                $data_exmachine[] = 'N'.$expectedMachine->downtimeTypeId;
             
            endforeach;
            
            $count_last_exmachine = $count_last_machine+3;

            foreach($header->unexpectedDowntime as $unexpectedMachine):  
                $active->getStyle('B'.$count_last_exmachine)->applyFromArray($styleCenterArray);
                $active->setCellValue('B'.$count_last_exmachine, $unexpectedMachine->description);

                $active->getStyle($count_check.$count_last_exmachine)->applyFromArray($styleCenterArray);
                $active->setCellValue($count_check.$count_last_exmachine, $unexpectedMachine->iMinute);
               
                $count_last_exmachine++;
                $data_unmachine[] = 'M'.$unexpectedMachine->downtimeTypeId;
            endforeach;

            $count_second = 31;
        endforeach;
        
        $active->getStyle($end2.'1:'.$end2.'9')->applyFromArray($styleCenterArray);
        $active->setCellValue($end2.'1','JOB NO. '.$job_no);
        $active->mergeCells($end2.'1:'.$end2.'9');
      

        // TOTAL
        $shift_length_sum = 'B9:'.$end2.'9';
        $total_expected_downtime = 'B10:'.$end2.'10';
        $total_unexpected_downtime = 'B11:'.$end2.'11';
        $planed_production_time = 'B12:'.$end2.'12';
        $operating_time = 'B13:'.$end2.'13';
        $total_machine_downtime = 'B14:'.$end2.'14';
        $machine_downtime_time = 'B15:'.$end2.'15';
        $machine_actual = 'B16:'.$end2.'16';
        $variance = 'B17:'.$end2.'17';
        $running_time = 'B18:'.$end2.'18';
        $bottles_check = 'B19:'.$end2.'19';
        $cases = 'B20:'.$end2.'20';
        $palletCount = 'B21:'.$end2.'21';
        $machineCount = 'B22:'.$end2.'22';
        $ideal_cycle_time = 'B23:'.$end2.'23';
        $expected_output = 'B24:'.$end2.'24';
        $availability = 'B25:'.$end.'25';
        $performance = 'B26:'.$end.'26';
        $quality = 'B27:'.$end.'27';
        $oeee = 'B28:'.$end.'28'; 

        $active->setCellValue($end2.'9', '=SUM('.$shift_length_sum.')');
        $active->setCellValue($end2.'10', '=SUM('.$total_expected_downtime.')');
        $active->setCellValue($end2.'11', '=SUM('.$total_unexpected_downtime.')');
        $active->setCellValue($end2.'12', '=SUM('.$planed_production_time.')');
        $active->setCellValue($end2.'13', '=SUM('.$operating_time.')');
        $active->setCellValue($end2.'14', '=SUM('.$total_machine_downtime.')');
        $active->setCellValue($end2.'15', '=SUM('.$machine_downtime_time.')');
        $active->setCellValue($end2.'16', '=SUM('.$machine_actual.')');
        $active->setCellValue($end2.'17', '=SUM('.$variance.')');
        $active->setCellValue($end2.'18', '=SUM('.$running_time.')');
        $active->setCellValue($end2.'19', '=SUM('.$bottles_check.')');
        $active->setCellValue($end2.'20', '=SUM('.$cases.')');
        $active->setCellValue($end2.'21', '=SUM('.$palletCount.')');
        $active->setCellValue($end2.'22', '=SUM('.$machineCount.')');
        $active->setCellValue($end2.'23', '=SUM('.$ideal_cycle_time.')');
        $active->setCellValue($end2.'24', '=SUM('.$expected_output.')');
        
        $active->getCell($end2.'25', '=AVERAGE('.$availability.')')
        ->getStyle()->getNumberFormat()
        ->setFormatCode($localeCurrencyMask);
        $active->getCell($end2.'26', '=AVERAGE('.$performance.')')
        ->getStyle()->getNumberFormat()
        ->setFormatCode($localeCurrencyMask);
        $active->getCell($end2.'27', '=AVERAGE('.$quality.')')
        ->getStyle()->getNumberFormat()
        ->setFormatCode($localeCurrencyMask);
        $active->getCell($end2.'28', '=AVERAGE('.$oeee.')')
        ->getStyle()->getNumberFormat()
        ->setFormatCode($localeCurrencyMask);
        

        $active->setCellValue($end2.'25', '=AVERAGE('.$availability.')');
        $active->setCellValue($end2.'26', '=AVERAGE('.$performance.')');
        $active->setCellValue($end2.'27', '=AVERAGE('.$quality.')');
        $active->setCellValue($end2.'28', '=AVERAGE('.$oeee.')');
        


        $active->getColumnDimension($end2)->setWidth(30);
        $machine_count = 31;
        foreach(array_unique($data_machine) as $machine):
            $machine_sum = 'B'.$machine_count.':'.$end2.$machine_count;
            $active->setCellValue($end2.$machine_count, '=SUM('.$machine_sum.')');
            $machine_count++;
        endforeach;
        
        $count_last_machine = $machine_count+3;
        $expected_machine_count = $count_last_machine;
        foreach(array_unique($data_exmachine) as $exmachine):
            $exmachine_sum = 'B'.$expected_machine_count.':'.$end2.$expected_machine_count;
            $active->setCellValue($end2.$expected_machine_count, '=SUM('.$exmachine_sum.')');
            $expected_machine_count++;
        endforeach;

        $unmachine_count = $expected_machine_count+3;
        foreach(array_unique($data_unmachine) as $unmachine):
            $unmachine_sum = 'B'.$unmachine_count.':'.$end2.$unmachine_count;
            $active->setCellValue($end2.$unmachine_count, '=SUM('.$unmachine_sum.')');
            $unmachine_count++;
        endforeach;
        

        $last_machine_count = $machine_count;
        $total_machine_downtime = array();
        $expected_count_blank = $machine_count+1;

        $active->getStyle('B'.$expected_count_blank.':'.$end2.$expected_count_blank)->applyFromArray($styleArray);
        $active->setCellValue('B'.$expected_count_blank, '');
        $active->mergeCells('B'.$expected_count_blank.':'.$end2.$expected_count_blank);

        $expected_count_title = $expected_count_blank+1;
        $active->getStyle('B'.$expected_count_title.':'.$end2.$expected_count_title)->applyFromArray($styleCenterArray);
        $active->setCellValue('B'.$expected_count_title, 'EXPECTED OPERATIONAL DOWNTIME,mins.');
        $active->mergeCells('B'.$expected_count_title.':'.$end2.$expected_count_title);
        
        $active->getStyle('B'.$expected_count_blank.':'.$end2.$expected_count_blank)->applyFromArray($styleArray);
        $active->setCellValue('B'.$expected_count_blank, '');
        $active->mergeCells('B'.$expected_count_blank.':'.$end2.$expected_count_blank);
        
        $total_machine_count = $expected_machine_count;
        $expected_count_first_count = $total_machine_count;
        $unexpected_count_first_count = $unmachine_count;

        $unexpected_count_blank = $total_machine_count+1;
        $active->getStyle('B'.$unexpected_count_blank.':'.$end2.$unexpected_count_blank)->applyFromArray($styleArray);
        $active->setCellValue('B'.$unexpected_count_blank, '');
        $active->mergeCells('B'.$unexpected_count_blank.':'.$end2.$unexpected_count_blank);

        $unexpected_count_title = $total_machine_count+2;
        $active->getStyle('B'.$unexpected_count_title.':'.$end2.$unexpected_count_title)->applyFromArray($styleCenterArray);
        $active->setCellValue('B'.$unexpected_count_title, 'UNEXPECTED OPERATIONAL DOWNTIME,mins.');
        $active->mergeCells('B'.$unexpected_count_title.':'.$end2.$unexpected_count_title);
        
        $count_last_machine_ex = $expected_count_first_count;
        $first_row_ex = $last_machine_count+3;
        $first_row_un = $expected_machine_count+3;
        foreach($count_array as $count_array_now):
            if($count_array_now == 'B'):
                $total = $count_array_now.$last_machine_count;
                $active->setCellValue($count_array_now.$last_machine_count,'TOTAL MACHINE DOWNTIME');
                $active->getStyle($count_array_now.$last_machine_count)->applyFromArray($styleCenterArray);

                $total = $count_array_now.$count_last_machine_ex;
                $active->setCellValue($count_array_now.$count_last_machine_ex,'TOTAL OPERATIONAL DOWNTIME');
                $active->getStyle($count_array_now.$count_last_machine_ex)->applyFromArray($styleCenterArray);

                $total = $count_array_now.$unexpected_count_first_count;
                $active->setCellValue($count_array_now.$unexpected_count_first_count,'TOTAL OPERATIONAL DOWNTIME');
                $active->getStyle($count_array_now.$unexpected_count_first_count)->applyFromArray($styleCenterArray);
            else:
                $total = $count_array_now.'31'.':'.$count_array_now.$last_machine_count;
                $active->setCellValue($count_array_now.$last_machine_count, '=SUM('.$total.')');
                $active->getStyle($count_array_now.$last_machine_count)->applyFromArray($styleCenterArray);
              
                $total_ex = $count_array_now.$first_row_ex.':'.$count_array_now.$total_machine_count-1;
                $active->setCellValue($count_array_now.$total_machine_count, '=SUM('.$total_ex.')');
                $active->getStyle($count_array_now.$total_machine_count)->applyFromArray($styleCenterArray);

                $total_un = $count_array_now.$first_row_un.':'.$count_array_now.$unexpected_count_first_count;
               
                $active->setCellValue($count_array_now.$unexpected_count_first_count, '=SUM('.$total_un.')');
                $active->getStyle($count_array_now.$unexpected_count_first_count)->applyFromArray($styleCenterArray);
            endif;
        endforeach;
        
        $last_letter = end($count_array);
        $total_machine_last = 'C'.$machine_count.':'.$last_letter.$last_machine_count;
        $total_machine_last2 = 'C'.$expected_machine_count.':'.$last_letter.$expected_machine_count;
        $total_machine_last3 = 'C'.$unmachine_count.':'.$last_letter.$unmachine_count;
       
        $active->setCellValue($end2.$last_machine_count, '=SUM('.$total_machine_last.')');
        $active->getStyle($end2.$last_machine_count)->applyFromArray($styleCenterArray);

        $active->setCellValue($end2.$expected_machine_count, '=SUM('.$total_machine_last2.')');
        $active->getStyle($end2.$expected_machine_count)->applyFromArray($styleCenterArray);

        $active->setCellValue($end2.$unmachine_count, '=SUM('.$total_machine_last3.')');
        $active->getStyle($end2.$unmachine_count)->applyFromArray($styleCenterArray);

        
        $active->getStyle($end2.'9:'.$end2.$unmachine_count)->applyFromArray($styleCenterArray);
        $writer = new Xlsx($spreadsheet);
        // $writer->save('downtime.xlsx');
        $fileName = 'downtime_report_'.date('Y-m-d').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
       
    }

}
