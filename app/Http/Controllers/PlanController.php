<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');

use Illuminate\Http\Request;
use App\Models\Month;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PlanResource;

class PlanController extends Controller
{
    public function index(){
        $months = Month::all();
        $line = '1';
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->cStockCode;
        endforeach;
        $pm_flag = '0';

        $response_line = Http::get($api_url.'/Production/GetLines');
        $lines = $response_line->object();
        
        return view('plan.index',compact('months','line','stock_codes','pm_flag','lines'));
    }

    public function line_2(){
        $months = Month::all();
        $line = '2';
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->cStockCode;
        endforeach;
        $pm_flag = '0';
        $response_line = Http::get($api_url.'/Production/GetLines');
        $lines = $response_line->object();
        return view('plan.index',compact('months','line','stock_codes','pm_flag','lines'));
    }

    public function injection(){
        $months = Month::all();
        $line = '3';
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->cStockCode;
        endforeach;
        $pm_flag = '0';
        $response_line = Http::get($api_url.'/Production/GetLines');
        $lines = $response_line->object();
        return view('plan.index',compact('months','line','stock_codes','pm_flag','lines'));
    }

    public function plan_ajax($year,$month,$line){
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/MonthlyPlan/GetMonthlyPlan?nYear='.$year.'&nMonth='.$month.'&nLineNo='.$line);
        return PlanResource::collection($response->object());
    }

    public function upload(Request $request){
        $irene = $request->file('file');
        $nYear = $request->input('nYear');
        $nMonth = $request->input('nMonth');

        $api_url = env('API_URL');
        $response = Http::post($api_url.'/MonthlyPlan/upload', [
            'nYear' => $nYear,
            'nMonth' => $nMonth,
            'file'=>$irene
        ]);

        return $response->body();
    }
}
