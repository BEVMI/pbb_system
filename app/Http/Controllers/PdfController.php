<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; 
use Auth;
use App\Models\QcTag;
use Illuminate\Support\Facades\Http;

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
}
