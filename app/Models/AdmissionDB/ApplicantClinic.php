<?php

namespace App\Models\AdmissionDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantClinic extends Model
{
    use HasFactory;

    protected $connection = 'admission';
    protected $table = 'ad_applicant_clinic';

    protected $fillable = [
        'app_id',
        'status',
        'interviewerid',
        'camp',
        'admission_id', 
        'interviewer',
        'height_cm',
        'height_ft',
        'weight_kg',
        'weight_lb',
        'bmi',
        'bami_cat',
        'temp',
        'pr',
        'bp',
        'rr',
        'disease',
        'disease_rem',
        'hospital_confine',
        'date_hospitaliz',
        'date_hospitaliz1',
        'immunization1',
        'immunization2',
        'smoking',
        'drinking',
        'menarche',
        'studuration',
        'studinterval',
        'pads_use',
        'mens_symp',
        'lmp',
        'en_pexam',
        'findings_pexam',
        'other_pexam',
        'other_find',
        'pexam_pwd',
        'pexam_remarks',
        'pend_reason',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];
}
