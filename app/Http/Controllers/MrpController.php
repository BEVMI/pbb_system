<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use App\Models\Month;
use Illuminate\Support\Facades\Http;

class MrpController extends Controller
{
    public function index(){
        $months = Month::all();
        return view('mrp.index',compact('months'));
    }

    public function detail($month,$year,$source){
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/Mrp/GetComputedMaterials?nYear='.$year.'&nMonth='.$month.'&cSource='.$source.'&cType=Detail');
        $mrps = $response->object();

        return view('mrp.detail',compact('mrps'));
    }
}
