<?php

namespace App\Http\Controllers;

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
        $api_url = Config('irene.api_url');
        $response = Http::get($api_url.'/Mrp/GetComputedMaterials?nYear='.$year.'&nMonth='.$month.'&cSource='.$source.'&cType=Detail');
        $mrps = $response->object();

        return view('mrp.detail',compact('mrps'));
    }
}
