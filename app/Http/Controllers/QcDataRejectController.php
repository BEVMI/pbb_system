<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class QcDataRejectController extends Controller
{
    public function index(){
        $api_url = env('API_URL');
        $response_ongoing_jobs = Http::get($api_url.'/Production/GetJobsOnGoing');
        
        $response_critical = Http::get($api_url.'/QcReject/by-category/c07d2deb-a6bf-4047-bfc1-0adc6d5a029a');
        $response_minor = Http::get($api_url.'/QcReject/by-category/1a2b3c4d-5e6f-7a8b-9c0d-1e2f3a4b5c6d');
        $response_major_a = Http::get($api_url.'/QcReject/by-category/4f6e3c2d-1d1b-4f1c-8e2d-8f3c6d7a9b0c');
        $response_major_b = Http::get($api_url.'/QcReject/by-category/9a8b7c6d-5e4f-3a2b-1c0d-9e8f7a6b5c4d');

        $jobs = $response_ongoing_jobs->object();
        
        $criticals = $response_critical->object();
        $minors = $response_minor->object();
        $majors_a = $response_major_a->object();
        $majors_b = $response_major_b->object();
        
        $date_now = Carbon::now()->format('Y-m-d');
        $month_now = Carbon::now()->format('m');
        $year_now = Carbon::now()->format('Y');

        $response_rejects = Http::get($api_url.'/QcRejectData?dYearCreate='.$year_now.'&dMonthCreate='.$month_now.'&sortBy=true&pageNumber=1&pageSize=10');
        $reject_datas = $response_rejects->object();
        return view('qc_data_rejects.index', compact('jobs','criticals','minors','majors_a','majors_b','date_now','month_now','year_now','reject_datas'));
    }

    public function getEditedData($jobId,$dbatch,$categoryId,$dYearDate,$dMonthDate){
        $api_url = env('API_URL');
        $response_rejects = Http::get($api_url.'/QcRejectData/by-group?iJobId='.$jobId.'&dBatch='.$dbatch.'&categoryId='.$categoryId.'&dYearCreate='.$dYearDate.'&dMonthCreate='.$dMonthDate);
        $reject_datas = $response_rejects->object();
        return response()->json($reject_datas);
    }

    public function getCategoryData(){
        $api_url = env('API_URL');
        $response_categories = Http::get($api_url.'/Category');
        $category_datas = $response_categories->object();
        return response()->json($category_datas);
    }
}
