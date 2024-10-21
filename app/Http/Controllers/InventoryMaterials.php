<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\FgResource;

class InventoryMaterials extends Controller
{
    public function index(Request $request){
        $api_url = env('API_URL');
        $search = strtoupper($request->search);
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
     
        $stockcodes_resource = $response->object();
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->cStockCode;
        endforeach;
        return view('materials.index',compact('stock_codes'));
    }
}
