<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Patient;
use App\Enums\UserRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'lastname',
        'username',
        'email',
        'password',
        'image',
        'specialty',
        'phone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRoles::class,
    ];

    // ===== Relations =====
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'doctor_patient', 'user_id', 'patient_id');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }

    // ===== Scopes =====
    public function scopeDoctors($query)
    {
        return $query->where('role', UserRoles::DOCTOR);
    }

    public function scopePatients($query)
    {
        return $query->where('role', UserRoles::PATIENT);
    }

    protected $isDeletingPatient = false;
    protected $isUpdatingPatient = false;

    protected static function boot()
    {
        parent::boot();

        // ===== DELETE SYNC =====
        static::deleting(function ($user) {
            if ($user->patient && !$user->isDeletingPatient) {
                $user->isDeletingPatient = true;
                $user->patient->delete();
            }
        });

        // ===== UPDATE SYNC 🔥 =====
        static::updating(function ($user) {
            if ($user->patient && !$user->isUpdatingPatient) {
                $user->isUpdatingPatient = true;

                $patientData = [];

                if ($user->isDirty('name')) $patientData['name'] = $user->name;
                if ($user->isDirty('lastname')) $patientData['lastname'] = $user->lastname;
                if ($user->isDirty('username')) $patientData['username'] = $user->username;
                if ($user->isDirty('phone')) $patientData['phone'] = $user->phone;
                if ($user->isDirty('email')) $patientData['email'] = $user->email;

                if (!empty($patientData)) {
                    $user->patient->updateQuietly($patientData);

                }
            }
        });
    }

  
public function notifications()
{
    return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
}

public function unreadNotifications()
{
    return $this->notifications()->whereNull('read_at');
}
}
