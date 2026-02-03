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
        'referralID',
        'date',
        'time',
        'bp',
        'pr',
        'rr',
        'spo',
        'btemp',
        'lmp',
        'pheight',
        'pweight',
        'preferfrom',
        'preferto',
        'reasonrefer',
        'tentdiagnose',
        'treatmentmedgiven',
    ];
}
