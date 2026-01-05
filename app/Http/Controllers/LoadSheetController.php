<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Auth;
use PDF;

class LoadSheetController extends Controller
{
    public function index(Request $request){
        $month_post = $request->get('month_post');
        $year_post = $request->get('year_post');
        $page = $request->get('page');
        $api_url = env('API_URL');
        $response_customers = Http::get($api_url.'/LoadSheetSyspro/customers');
        $customers = $response_customers->object();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $user = Auth::user();
        
        if($month_post):
            $month_post = $month_post;
        else:
            $month_post = $month;
        endif;
        if($year_post):
            $year_post = $year_post;
        else:
            $year_post = $year;
        endif;

        if($page):
            $page = $page;
        else:
            $page = 1;
        endif;

        $date_today = Carbon::now()->format('Y-m-d');
        $response_loadsheet = Http::get($api_url.'/LssControlHeader/GetAllLssHeaders?month='.$month_post.'&year='.$year_post.'&sortBy=true&pageNumber='.$page.'&pageSize=10');
        $headers = $response_loadsheet->object();


        return view('loadsheet.index', compact('customers', 'month', 'year', 'date_today','headers','month_post','year_post','page','user'));
    }

    public function print_loadsheet($id){
       
        $date_today = Carbon::now()->format('Y-m-d');
        $api_url = env('API_URL');
        $responses = Http::get($api_url.'/LssControlHeaderDetail/'.$id);
        $loadsheets = $responses->object();
        $header = $loadsheets[0]->lssDetails[0];
        $header_detail = $header->lssDetailHeader;
        $lssheader = $header->lssDetailHeader->lssHeader;
        $control_number = $lssheader->loadSheetNumber.'-'.$header->truckNo;
        $depot = $lssheader->depot;
      
        $ppic = 'PPCI';
        $puregold = 'PUREGOLD';
        $ayalagold = 'AYALAGOLD';

        $plate_number = $header_detail->plateNumber;
        $created_date = Carbon::parse($header_detail->createdDate)->format('F d, Y');
        if (str_contains($header->customerName, $ppic) || str_contains($header->customerName, $puregold)|| str_contains($header->customerName, $ayalagold)):
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>'Calibri Light'])
            ->loadView('pdf.puregold',compact('date_today','loadsheets','control_number','plate_number','created_date'))
            ->setPaper('A4', 'landscape');
        else:
             $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>'Calibri Light'])
            ->loadView('pdf.nonpuregold',compact('date_today','loadsheets','control_number','plate_number','created_date','depot'))
            ->setPaper('A4', 'portrait');
        endif;

        $pdf->getDomPDF()->set_option("enable_php", true);  
        return $pdf->stream($control_number.'.pdf',array('Attachment' => false));
    }
}
