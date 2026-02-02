<?php

namespace App\Models\HrisDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    
    protected $connection = 'hremp';
    protected $table = 'cities';

    protected $fillable = [
        'code',
        'name',
        'region_id',
        'province_id',
        'city_id',
    ];

    public $timestamps = false;
}
