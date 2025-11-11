<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class QcRejectController extends Controller
{
    public function index(){
        $api_url = env('API_URL');
        $response = Http::get($api_url.'/QcReject?sortBy=true&pageNumber=1&pageSize=10');
        $response_resource = $response->object();
       
        return view('qc_rejects.index', compact('response_resource'));
    }
}
