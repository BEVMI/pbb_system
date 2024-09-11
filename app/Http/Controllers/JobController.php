<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    public function index(){
        $months = Month::all();
        return view('jobs.index',compact('months'));
    }
}
