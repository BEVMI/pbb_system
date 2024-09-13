<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PalletStatus;

class PalletsController extends Controller
{
    public function index(){
        $statuses = PalletStatus::pluck('status_name');
        return view('pallets.index',compact('statuses'));
    }
}
