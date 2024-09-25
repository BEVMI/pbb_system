<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        return view('downtime.index',compact('lines','jobs'));
    }
}
