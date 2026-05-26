<?php

namespace App\Models\AdmissionDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdReupload extends Model
{
    use HasFactory;

    protected $connection = 'admission';
    protected $table = 'ad_reupload';

    protected $fillable = [
        'appid', 
        'camp', 
        'reuploadallow', 
        'status'
    ];

    protected $casts = [
        'reuploadallow' => 'array',
    ];

}
