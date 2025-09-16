<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;
    protected $table='tblCoa';

    protected $fillable = [
        'id',
        'tosId',
        'fileName'
    ];

    public $timestamps = false;
}
