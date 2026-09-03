<?php

namespace App\Models\ClinicDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    
    protected $table='medicines';  

    protected $fillable = [
        'code',
        'name',
        'generic_name',
        'dosage',
        'unit',
        'reorder_level',
        'description',
        'is_active',
    ];

    // Total stock active across all batches
    public function getTotalStockAttribute()
    {
        return $this->batches()->sum('quantity_remaining');
    }

    // Batches relationship
    public function batches()
    {
        return $this->hasMany(MedicineBatch::class);
    }

    // Transactions relationship
    public function transactions()
    {
        return $this->hasMany(MedicineTransaction::class);
    }
}
