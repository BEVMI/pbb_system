<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
class TosController extends Controller
{
    public function index(){
        $months = Month::all();
        return view('tos.index',compact('months'));
    }
}
