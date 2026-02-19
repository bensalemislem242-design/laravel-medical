<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // pour patient et user
use App\Models\Doctor;

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
        'user_id', // ajouter cette ligne
    ];

    /**
     * Relation avec le docteur
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Relation avec le patient
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Relation avec l'utilisateur qui crée le rendez-vous
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
