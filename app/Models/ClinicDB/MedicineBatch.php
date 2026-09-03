<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineBatch extends Model
{
    use HasFactory;

    protected $table='medicine_batches'; 

    protected $fillable = [
        'medicine_id',
        'lotbatch_number',
        'quantity_received',
        'quantity_remaining',
        'refnoid',
        'expiration_date',
        'received_date',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'received_date' => 'date',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function transactions()
    {
        return $this->hasMany(MedicineTransaction::class, 'batch_id');
    }
}
