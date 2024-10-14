<?php

namespace App\Http\Controllers;

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
