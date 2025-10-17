<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table='tblMonthlyPlan';

    public function InvMaster(){
        return $this->belongsTo(InvMaster::class, 'cStockCode', 'cStockCode');
    }
}
