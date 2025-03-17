<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailView;
use App\Models\Email;
use Auth;
class TestController extends Controller
{
    public function emaildesign(){
        $user = Auth::user();
        print_r($user);
    }

    public function emailtest(){
        date_default_timezone_set('Asia/Manila');
        $datetoday = date('Y-m-d H:i');

        $user_auth = Auth::user();
        $url = route('injection.index');
        $email_details = [
            'title' => 'JOB CREATION',
            'email'=>'irenejoy15@gmail.com',
            'body' =>$user_auth->name.' created a job number 123' ,
            'date' =>$datetoday,
            'from' => 'notify@bevi.com.ph',
            'url'=>$url,
            'user_name'=> $user_auth->name
        ];
        Mail::to('cefrian.trinchera@bevmi.com')->send(new EmailView($email_details));
    }

    public function emailSend($title,$content,$department){
        date_default_timezone_set('Asia/Manila');
        $datetoday = date('Y-m-d H:i');
        if($department == 'production1'):
            $email = Email::where('department','production')->first();
        elseif($department == 'allqc'):
            $email = Email::where('department','qc')->first();
        elseif($department == 'qc'):
            $email = Email::where('department','qc')->first();
        elseif($department == 'production2'):
            $email = Email::where('department','production')->first();
        elseif($department == 'manager'):
            $email = Email::where('department','manager')->first();
        else:
            $email = Email::where('department',$department)->first();
        endif;
        
        $user_auth = Auth::user();
        if($department == 'production'):
            $url = route('machine_counter.index');
            $email_to = Email::where('department','production')->first();
        elseif($department == 'production2'):
            $url = route('tos.index');
            $email_to = Email::where('department','production')->first();
        elseif($department == 'production1'):
            $url = route('pallets.index');
            $email_to = Email::where('department','qc')->first();
        elseif($department == 'allsuper'):
            $url = route('tos.index');
            $email_to = Email::where('department','qc')->first();
        elseif($department == 'allqc'):
            $url = route('tos.index');
            $email_to = Email::where('department','manager')->first();
        elseif($department == 'allmanager'):
            $url = route('tos.index');
            $email_to = Email::where('department','warehouse')->first();
        endif;
        if($department != 'allwarehouse'):
            $email_details = [
                'title' => $title,
                'email'=>$email->email,
                'body' =>$content ,
                'date' =>$datetoday,
                'from' => 'notify@bevi.com.ph',
                'url'=>$url,
                'user_name'=> $user_auth->name
            ];
            Mail::to($email_to)->send(new EmailView($email_details));
        endif;
    }
    
}
