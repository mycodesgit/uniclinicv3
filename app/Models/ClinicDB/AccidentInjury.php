<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccidentInjury extends Model
{
    use HasFactory;

    protected $table ='accidentinjury'; 

    protected $fillable = [
        'name',
        'status',
    ];
}
