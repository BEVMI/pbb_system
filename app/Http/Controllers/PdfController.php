<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; 
use Auth;

class PdfController extends Controller
{
    public function test_quarantine(){
        $print = 'pdf.test_quarantine';
        $font = 'Century Gothic';
        $position = 'portrait';
        
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultMediaType'=> 'all','isFontSubsettingEnabled'=>true,'defaultFont'=>$font])
        ->loadView($print)->setPaper('LETTER', $position);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('test.pdf',array('Attachment' => false));
    }
}
