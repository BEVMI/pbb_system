<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use App\Models\PalletStatus;
use App\Models\QcUser;
class PalletsController extends Controller
{
    public function index(){
        $qc_users = QcUser::all();
        $statuses = PalletStatus::pluck('status_name');
        return view('pallets.index',compact('statuses','qc_users'));
    }
}
