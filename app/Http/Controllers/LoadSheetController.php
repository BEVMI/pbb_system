<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class LoadSheetController extends Controller
{
    public function index(){
        $api_url = env('API_URL');
        $response_customers = Http::get($api_url.'/LoadSheetSyspro/customers');
        $customers = $response_customers->object();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $date_today = Carbon::now()->format('Y-m-d');
        return view('loadsheet.index', compact('customers', 'month', 'year', 'date_today'));
    }
}
