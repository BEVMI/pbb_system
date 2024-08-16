<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
class PoComplianceController extends Controller
{
    public function index(){
        $months = Month::all();
        return view('pocompliance.index',compact('months'));
    }
}
