<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Uuid;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

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
        $is_pm = $request->input('is_pm');
        $uuid = Uuid::generate(4);
        $line_1 = $request->input('line_1');
        $line_2 = $request->input('line_2');
        $injection = $request->input('injection');

        $is_supervisor = $request->input('is_supervisor');
        $is_manager = $request->input('is_manager');

        $photo = $request->file('photo');
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);    

        $photo_name = 'P'.time().'.'.$photo->extension();
        
        $photo->move('user_images', $photo_name);
        $photo_image_post = $photo_name;

        $signature = $request->file('signature');
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);    

        $signature_name = 'S'.time().'.'.$signature->extension();
        
        $signature->move('signatures', $signature_name);
        $signature_image_post = $signature_name;

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
            'is_pm'=>$is_pm,
            'is_supervisor'=>$is_supervisor,
            'is_manager'=>$is_manager,
        );

        if(!empty($photo)):
            $new_array = array('photo'=>$photo_name);
            $data_user  = array_merge($data_user,$new_array);
        endif;
        
        if(!empty($signature)):
            $new_array = array('signature'=>$signature_name);
            $data_user  = array_merge($data_user,$new_array);
        endif;
        
        User::create($data_user);
        return back()->with('success','USER SUCCESSFULLY CREATED!');
    }

    public function update_user(Request $request){
        $user_id = $request->input('update_id');
        $name = $request->input('name_update');
        $email = $request->input('email_update');
        
        $is_admin = $request->input('is_admin_update');
        $is_pm = $request->input('is_pm_update');
        $is_active = $request->input('is_active_update');
        $is_warehouse = $request->input('is_warehouse_update');
        $is_qc = $request->input('is_qc_update');
        $is_production = $request->input('is_production_update');
        $user_row = User::where('id',$user_id)->first();
        $password_post = trim($request->input('password_update'));  

        $line_1 = $request->input('line_1_update');
        $line_2 = $request->input('line_2_update');
        $injection = $request->input('injection_update');
        $is_supervisor = $request->input('is_supervisor_update');
        $is_manager = $request->input('is_manager_update');

        $update_photo = $request->file('update_photo');
        $update_signature = $request->file('update_signature');
        if(empty($password_post)):
            $password = $user_row->password;
        else:
            $password = md5($password_post);
        endif;

        if(!empty($update_photo)):
            $photo_name = 'P'.time().'.'.$update_photo->extension();
            $photo_path = "user_images/".$user_row->photo;

            if(File::exists($photo_path)) {
                File::delete($photo_path);
            }
            $update_photo->move('user_images', $photo_name);
            $photo_image_post = $photo_name;
        endif;

        if(!empty($update_signature)):
            $signature_name = 'S'.time().'.'.$update_signature->extension();
            $signature_path = "signatures/".$user_row->signature;

            if(File::exists($signature_path)) {
                File::delete($signature_path);
            }
            $update_signature->move('signatures', $signature_name);
            $signature_image_post = $signature_name;
        endif;

        $data_user = array(
            'name'=>$name,
            'email'=>$email,
            'password'=>$password,
            'is_active'=>$is_active,
            'is_admin' => $is_admin,
            'is_warehouse' => $is_warehouse,
            'is_production' => $is_production,
            'is_qc' => $is_qc, 
            'line_1'=>$line_1,
            'line_2'=>$line_2,
            'injection'=>$injection,
            'is_pm'=>$is_pm,
            'is_supervisor'=>$is_supervisor,
            'is_manager'=>$is_manager,
        );

        if(!empty($update_photo)):
            $new_array = array('photo'=>$photo_image_post);
            $data_user  = array_merge($data_user,$new_array);
        endif;
        
        if(!empty($update_signature)):
            $new_array = array('signature'=>$signature_image_post);
            $data_user  = array_merge($data_user,$new_array);
        endif;
        
        User::where('id',$user_id)->update($data_user);
        return back()->with('success',"USER SUCCESSFULLY UPDATED!");
    }
}
