<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InventoriesFGController extends Controller
{
    public function index(){
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->cStockCode;
        endforeach;
        return view('fg.index',compact('stock_codes'));
    }
}
