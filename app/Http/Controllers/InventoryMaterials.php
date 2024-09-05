<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\FgResource;

class InventoryMaterials extends Controller
{
    public function index(Request $request){
        $api_url = Config('irene.api_url');
        $search = strtoupper($request->search);
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->cStockCode;
        endforeach;
        return view('materials.index',compact('stock_codes'));
    }
}
