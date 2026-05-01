<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
        'phone',
        'email',
        'specialty_id',
    ];
     public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
