<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'is_active',
        'is_admin',
        'is_warehouse',
        'is_qc',
        'is_production',
        'line_1',
        'line_2',
        'injection',
        'is_pm',
        'is_supervisor',
        'is_manager',
        'signature'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    protected $casts = [
        'id' => 'string',
    ];

    public function scopeSearch($query,$search){
        if($search!=''){
            $users = $query->orderBy('id','DESC')->where('name', 'like', '%'.$search.'%')->paginate(8)->appends(request()->query());
        }else{
            $users = $query->orderBy('id','DESC')->paginate(8)->onEachSide(1);
        }
        return $users;
    }

    public function is_active(){
        if($this->is_active== "1" ){
            return true;
        }
        return false;
    }

    public function line_1(){
        if($this->line_1== "1" ){
            return true;
        }
        return false;
    }

    public function line_2(){
        if($this->line_2== "1" ){
            return true;
        }
        return false;
    }

    public function injection(){
        if($this->injection== "1" ){
            return true;
        }
        return false;
    }

    public function is_pm(){
        if($this->is_pm== "1" ){
            return true;
        }
        return false;
    }

    public function is_admin(){
        if($this->is_admin== "1" ){
            return true;
        }
        return false;
    }
}
