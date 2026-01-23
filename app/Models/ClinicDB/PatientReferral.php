<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReferral extends Model
{
    use HasFactory;

    protected $table ='patientreferral';

    protected $fillable=[
        'stid',
        'stdntID',
        'date',
        'time',
        'preferfrom',
        'preferto',
        'reasonrefer',
        'tentdiagnose',
        'treatmentmedgiven',
    ];
}
