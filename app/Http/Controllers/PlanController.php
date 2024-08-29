<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
use Illuminate\Support\Facades\Http;

class PlanController extends Controller
{
    public function index(){
        $months = Month::all();
        return view('plan.index',compact('months'));
    }

    public function upload(Request $request){
        $irene = $request->file('file');
        $nYear = $request->input('nYear');
        $nMonth = $request->input('nMonth');

        $api_url = Config('irene.api_url');     
        $response = Http::post($api_url.'/MonthlyPlan/upload', [
            'nYear' => $nYear,
            'nMonth' => $nMonth,
            'file'=>$irene
        ]);

        return $response->body();
    }
}
