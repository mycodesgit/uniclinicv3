<?php

namespace App\Models\HrisDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $connection = 'hremp';
    protected $table = 'employees';

    protected $fillable = [
        'fname', 
        'mname', 
        'lname', 
        'position', 
        'profile', 
        'area_id', 
        'camp_id', 
        'emp_ID', 
        'android_id', 
        'emp_status', 
        'emp_dept', 
        'item_no',
        'username', 
        'verification_code', 
        'password', 
        'role', 
        'date_hired', 
        'prefix', 
        'title_prefix', 
        'suffix', 
        'bdate', 
        'age',
        'b_place', 
        'sex', 
        'civil_status', 
        'height_cm', 
        'height_m', 
        'weight_kg', 
        'weight_lb', 
        'b_type',
        'gsis', 
        'pagibig', 
        'philhealth', 
        'sss', 
        'tin', 
        'citizenship', 
        'c_category', 
        'country', 
        'telephone', 
        'mobile',
        'org_email', 
        'add_block', 
        'add_street', 
        'add_village', 
        'add_brgy', 
        'add_city', 
        'supervisor',
        'add_region', 
        'add_prov', 
        'add_zcode', 
        'padd_block', 
        'padd_street', 
        'padd_village', 
        'padd_brgy',
        'padd_city', 
        'padd_region', 
        'padd_prov', 
        'padd_zcode', 
        'sl', 
        'vl', 
        'mat_leave', 
        'special_pl', 
        'solo_pl',
        'study_leave',
        'vawc_leave',
        'rehab_leave',
        'benefits_leave',
        'calamity_leave',
        'adopt_leave',
        'servcred_leave',
        'esign', 
        'dpn', 
        'stat_1', 
        'esign', 
        'strat_function', 
        'f1', 
        'f2', 
        'f3'
    ];

    public function getRouteKeyName()
    {
        return 'emp_ID';
    }

}
