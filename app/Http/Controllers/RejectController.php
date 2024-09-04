<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Month;
class RejectController extends Controller
{
    public function index(){
        $api_url = Config('irene.api_url');
        $response_line = Http::get($api_url.'/Production/GetLines');
        $lines = $response_line->object();
        $months = Month::all();
        return view('rejects.index',compact('lines','months'));
    }
}
