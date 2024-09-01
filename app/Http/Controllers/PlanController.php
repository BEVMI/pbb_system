<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PlanResource;

class PlanController extends Controller
{
    public function index(){
        $months = Month::all();
        $line = '1';
        $api_url = Config('irene.api_url');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->StockCode;
        endforeach;
        return view('plan.index',compact('months','line','stock_codes'));
    }

    public function line_2(){
        $months = Month::all();
        $line = '2';
        $api_url = Config('irene.api_url');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->StockCode;
        endforeach;
        return view('plan.index',compact('months','line','stock_codes'));
    }

    public function injection(){
        $months = Month::all();
        $line = '3';
        $api_url = Config('irene.api_url');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->StockCode;
        endforeach;
        return view('plan.index',compact('months','line','stock_codes'));
    }

    public function plan_ajax($year,$month,$line){
        $api_url = Config('irene.api_url');
        $response = Http::get($api_url.'/MonthlyPlan/GetMonthlyPlan?nYear='.$year.'&nMonth='.$month.'&nLineNo='.$line);
        return PlanResource::collection($response->object());
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
