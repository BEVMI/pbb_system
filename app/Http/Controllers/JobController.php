<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\Job;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    public function index(){
        $months = Month::all();
        return view('jobs.index',compact('months'));
    }

    public function check($job_id){
        $check = Job::where('iJobNo',$job_id)->first();
        if(empty($check)):
            return 0;
        else:
            return 1;
        endif;
    }
}
