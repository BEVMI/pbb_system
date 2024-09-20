<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproverLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level',
    ];

    protected $casts = [
        'user_id' => 'string',
    ];

    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
