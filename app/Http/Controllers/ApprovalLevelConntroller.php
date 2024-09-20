<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApproverLevel;
use App\Models\User;

class ApprovalLevelConntroller extends Controller
{
    public function index(){
        $levels = ApproverLevel::all();
        $users = User::select('id','name')->get();
        return view('level.index',compact('levels','users'));
    }

    public function update(Request $request){

    }
}
