<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;

class JobController extends Controller
{
    public function index(){
        $months = Month::all();
        return view('jobs.index',compact('months'));
    }
}
