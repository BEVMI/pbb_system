<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\QcTag;
use Illuminate\Support\Facades\Http;

class QcController extends Controller
{
    public function index(){
        return view('qc.index');
    }
}
