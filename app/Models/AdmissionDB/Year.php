<?php

namespace App\Models\AdmissionDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $connection = 'admission';
    protected $table = 'admission_year';

    protected $fillable = [
        'adyear', 
        'status', 
    ];
}
