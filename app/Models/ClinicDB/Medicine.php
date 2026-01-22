<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $table='medicines';  

    protected $fillable = [
        'category',
        'medicine',
        'qty',
        'measure',
        'lotno',
        'expirydate',
        'refnoid'
    ];
}
