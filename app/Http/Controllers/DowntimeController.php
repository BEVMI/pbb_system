<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Month;
 
class DowntimeController extends Controller
{
    public function index(){
        $api_url = env('API_URL');
        $response_line = Http::get($api_url.'/Production/GetLines');
        $lines = $response_line->object();
        $response_jobs = Http::get($api_url.'/Production/GetJobsOnGoing');
        $job_post = $response_jobs->object();
        foreach($job_post as $job):
            $jobs_post[] =  $job->iJobNo;
        endforeach;
        $jobs = array_unique($jobs_post);
        $months = Month::pluck('month_name','id');
        return view('downtime.index',compact('lines','jobs','months'));
    }
}
