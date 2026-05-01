<?php
// app/Models/Prescription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medication',
        'dosage',
        'instructions',
        'content',  // AJOUTER ICI
        'file',
        'prescribed_at'
    ];

    protected $casts = [
        'prescribed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}