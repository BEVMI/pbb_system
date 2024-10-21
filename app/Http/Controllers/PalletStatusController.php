<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use App\Models\PalletStatus;
use App\Http\Resources\PalletStatusResource;
class PalletStatusController extends Controller
{
    public function check($status){
        $status = PalletStatus::where('status_name',$status)->first();
        
        // if($status->is_quarantine == '1'):
            $data[] = (object)array(
                'status_name'=>'Quarantine'
            );
        // endif;

        // if($status->is_approved == '1'):
            $data[] = (object)array(
                'status_name'=>'Approved'
            );
        // endif;

        // if($status->is_on_hold == '1'):
            $data[] = (object)array(
                'status_name'=>'On Hold'
            );
        // endif;

        // if($status->is_reject == '1'):
            $data[] = (object)array(
                'status_name'=>'Reject'
            );
        // endif;

        // if($status->is_turnover == '1'):
            $data[] = (object)array(
                'status_name'=>'Turnover'
            );
        // endif;

        if(!empty($data)):
            return [PalletStatusResource::collection($data),$status->is_reason];
        else:
            return 0;
        endif;
    }

    public function row($status){
        $status = PalletStatus::where('status_name',$status)->first();

        
    }

    public function check2($status){
        $status = PalletStatus::where('status_name',$status)->first();
        
        if($status->is_quarantine == '1'):
            $data[] = 'Quarantine';
        endif;

        if($status->is_approved == '1'):
            $data[] = 'Approved';
        endif;

        if($status->is_on_hold == '1'):
            $data[] = 'On Hold';
        endif;

        if($status->is_reject == '1'):
            $data[] = 'Reject';
        endif;

        if($status->is_turnover == '1'):
            $data[] = 'Turnover';
        endif;

        if(!empty($data)):
            return $data;
        else:
            return 0;
        endif;
    }
}