<?php

namespace App\Models\HrisDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    
    protected $connection = 'hremp';
    protected $table = 'regions';

    protected $fillable = [
        'code',
        'name',
        'region_id',
    ];

}
