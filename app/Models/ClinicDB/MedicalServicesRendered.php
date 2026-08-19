<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalServicesRendered extends Model
{
    use HasFactory;

    protected $table ='medicalservices'; 

    protected $fillable = [
        'medservrender',
        'status'
    ];
}
