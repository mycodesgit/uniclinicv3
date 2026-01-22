<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $table ='complaint'; 

    protected $fillable = [
        'complaint',
        'colorcode', 
    ];
}
