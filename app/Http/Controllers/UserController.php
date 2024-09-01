<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Uuid;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search'));
        $users = User::Search($search); 
        return view('users.index',compact('search','users'));
    }

    public function store(UserCreateRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');    
        $password = trim($request->input('password'));   
        $is_active = $request->input('is_active');
        $is_admin = $request->input('is_admin');
        $is_warehouse = $request->input('is_warehouse');
        $is_production = $request->input('is_production');
        $is_qc = $request->input('is_qc');
        $uuid = Uuid::generate(4);
        $line_1 = $request->input('line_1');
        $line_2 = $request->input('line_2');
        $injection = $request->input('injection');
        
        $data_user = array(
            'id'=>$uuid,
            'name'=>$name,
            'email'=>$email,
            'password'=>md5($password),
            'is_active'=>$is_active,
            'is_admin' => $is_admin,
            'is_warehouse' => $is_warehouse,
            'is_production' => $is_production,
            'is_qc' => $is_qc,
            'line_1'=>$line_1,
            'line_2'=>$line_2,
            'injection'=>$injection,
        );

        User::create($data_user);
        return back()->with('success','USER SUCCESSFULLY CREATED!');
    }

    public function update_user(Request $request){
        $user_id = $request->input('update_id');
        $name = $request->input('name_update');
        $email = $request->input('email_update');
        
        $is_admin = $request->input('is_admin_update');
        $is_active = $request->input('is_active_update');
        $is_warehouse = $request->input('is_warehouse_update');
        $is_qc = $request->input('is_qc_update');
        $is_production = $request->input('is_production_update');
        $user_row = User::where('id',$user_id)->first();
        $password_post = trim($request->input('password_update'));  

        $line_1 = $request->input('line_1_update');
        $line_2 = $request->input('line_2_update');
        $injection = $request->input('injection_update');

        if(empty($password_post)):
            $password = $user_row->password;
        else:
            $password = md5($password_post);
        endif;
        
        $data_user = array(
            'name'=>$name,
            'email'=>$email,
            'password'=>md5($password),
            'is_active'=>$is_active,
            'is_admin' => $is_admin,
            'is_warehouse' => $is_warehouse,
            'is_production' => $is_production,
            'is_qc' => $is_qc, 
            'line_1'=>$line_1,
            'line_2'=>$line_2,
            'injection'=>$injection,
        );

        User::where('id',$user_id)->update($data_user);
        return back()->with('success',"USER SUCCESSFULLY UPDATED!");
    }
}
