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
    public function index(Request $request){
        $month_post = $request->get('month_post');
        $year_post = $request->get('year_post');
        $page = $request->get('page');
        $api_url = env('API_URL');
        $response_customers = Http::get($api_url.'/LoadSheetSyspro/customers');
        $customers = $response_customers->object();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        
        if($month_post):
            $month_post = $month_post;
        else:
            $month_post = $month;
        endif;
        if($year_post):
            $year_post = $year_post;
        else:
            $year_post = $year;
        endif;

        if($page):
            $page = $page;
        else:
            $page = 1;
        endif;

        $date_today = Carbon::now()->format('Y-m-d');
        $response_loadsheet = Http::get($api_url.'/LssControlHeader/GetAllLssHeaders?month='.$month.'&year='.$year.'&sortBy=true&pageNumber='.$page.'&pageSize=10');
        $headers = $response_loadsheet->object();

        return view('loadsheet.index', compact('customers', 'month', 'year', 'date_today','headers','month_post','year_post','page'));
    }
}
