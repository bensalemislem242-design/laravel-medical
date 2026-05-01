<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'invoice_date',
        'status',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
