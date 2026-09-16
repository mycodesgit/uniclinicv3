<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryComplaint extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'category_complaint';

    protected $fillable = [
        'category_name',
        'cstatus',
    ];
}
