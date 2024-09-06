<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailView;
use Auth;

class MailController extends Controller
{
    public function email_post(Request $request){
        date_default_timezone_set('Asia/Manila');
        $datetoday = date('Y-m-d H:i');

        $user_auth = Auth::user();
        $url = $request->input('url');
        $title = $request->input('title');
        $to = $request->input('to');

        $email_details = [
            'title' => $title,
            'email'=>$user_auth->email,
            'body' =>$user_auth->name.' created a job number 123' ,
            'date' =>$datetoday,
            'from' => 'notify@bevi.com.ph',
            'url'=>$url,
            'user_name'=> $user_auth->name
        ];
        Mail::to($to)->send(new EmailView($email_details));
        return '1';
    }
}
