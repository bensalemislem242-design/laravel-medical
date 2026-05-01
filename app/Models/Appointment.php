<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'motivation',
        'date',
        'start_time',
        'end_time',
        'status',
        'user_id',
        'hospital_id',
        'is_new',           // Ajouté
        'appointment_date', // Ajouté
        'appointment_time', // Ajouté
    ];
    
  
    /* =========================
       RELATIONS
    ========================= */

    // Doctor (user avec role doctor)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Patient (user avec role patient)
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Creator (admin ou staff)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}