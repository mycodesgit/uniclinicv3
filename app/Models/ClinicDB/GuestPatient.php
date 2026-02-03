<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestPatient extends Model
{
    use HasFactory;

    protected $table ='guestpatient'; 

    protected $fillable = [
        'patientID',
        'lname',
        'fname',
        'mname',
        'ext',
        'gender',
        'civil_status',
        'address'
    ];
}
