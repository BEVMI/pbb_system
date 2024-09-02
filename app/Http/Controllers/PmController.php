<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
use Illuminate\Support\Facades\Http;

class PmController extends Controller
{
    public function index(){
        $months = Month::all();
        $line = 'all';
        $api_url = Config('irene.api_url');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->StockCode;
        endforeach;
        return view('pm.index',compact('months','line','stock_codes'));
    }
}
