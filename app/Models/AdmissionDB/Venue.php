<?php

namespace App\Models\AdmissionDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $connection = 'admission';
    protected $table = 'ad_venue';

    protected $fillable = [
        'campus', 
        'adyear', 
        'venue', 
    ];
}
