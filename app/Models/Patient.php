<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'lastname',
        'username',
        'noSSocial',
        'dob',
        'phone',
        'email',
        'diseases',
        'allergies',
        'background',
    ];

    public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function orientationLtrs()
    {
        return $this->hasMany(OrientationLetter::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    
    public function doctors()
    {
        return $this->belongsToMany(User::class, 'doctor_patient', 'patient_id', 'user_id');
    }
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $isUpdatingUser = false;

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($patient) {

            if ($patient->user && !$patient->isUpdatingUser) {

                $patient->isUpdatingUser = true;

                $userData = [];

                if ($patient->isDirty('name')) $userData['name'] = $patient->name;
                if ($patient->isDirty('lastname')) $userData['lastname'] = $patient->lastname;
                if ($patient->isDirty('username')) $userData['username'] = $patient->username;
                if ($patient->isDirty('phone')) $userData['phone'] = $patient->phone;
                if ($patient->isDirty('email')) $userData['email'] = $patient->email;

                if (!empty($userData)) {
                    $patient->user->updateQuietly($userData);

                }

                 
                $patient->isUpdatingUser = false;
            }
        });
    }
}
