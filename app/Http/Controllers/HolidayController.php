<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class HolidayController extends Controller
{
    public function index(){
        $year_now = Carbon::now()->format('Y');
        $response = Http::get(env('API_URL').'/Holiday?dYear='.$year_now.'&sortBy=false&pageNumber=1&pageSize=10');
        $responses = $response->object();
        $pages = $responses->pages;
        $holidays = $responses->holidays;
        $count = $responses->count;
        $date_today = Carbon::now()->format('Y-m-d');
        return view('holidays.index', compact('year_now','holidays','pages','count','date_today'));
    }
}
