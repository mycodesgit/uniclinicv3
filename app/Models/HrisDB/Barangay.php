<?php

namespace App\Models\HrisDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;
    
    protected $connection = 'hremp';
    protected $table = 'barangays';

    protected $fillable = [
        'code',
        'name',
        'region_id',
        'province_id',
        'city_id',
    ];

}
