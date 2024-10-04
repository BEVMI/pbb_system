<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Month;
use Carbon\Carbon;

class MachineCounter extends Controller
{
    public function index(){
        $api_url = env('API_URL');
        $response_line = Http::get($api_url.'/Production/GetLines');
        $lines = $response_line->object();
        $months = Month::all();

        $response_jobs = Http::get($api_url.'/Production/GetJobsOnGoing');
        $job_post = $response_jobs->object();
        foreach($job_post as $job):
            $date = Carbon::parse($job->dJobDate)->format('Y-m-d');
            $jobs[] =  (object)array(
                'value'=> $job->iJobNo.'_'.$job->id,
                'text'=>'JOB:'.$job->iJobNo.' - DATE:'.$date.' - ID:'.$job->id
            );
        endforeach;
       

        return view('machinecounter.index',compact('months','lines','jobs'));
    }
}
