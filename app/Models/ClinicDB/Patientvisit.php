<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patientvisit extends Model
{
    use HasFactory;

    protected $table ='patientvisits';

    protected $fillable=[
        'stid',
        'stdntID',
        'date',
        'time',
        'chief_complaint',
        'bp',
        'pr',
        'rr',
        'spo',
        'btemp',
        'lmp',
        'treatment',
        'medicine',
        'qty',
        'certificate',
    ];
}
