<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    use HasFactory;

    protected $table='tblPallet';

    public function plan(){
        return $this->belongsTo(Plan::class, 'iJobId', 'iJobId');
    }

}
