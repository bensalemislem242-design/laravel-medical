<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        Doctor::create([
            'name' => 'Ahmed',
            'lastname' => 'Ben Salem',
            'speciality' => 'Cardiology'
        ]);
        Doctor::create([
            'name' => 'Salma',
            'lastname' => 'Chikhi',
            'speciality' => 'Dermatology'
        ]);
        Doctor::create([
            'name' => 'Mohamed',
            'lastname' => 'Toumi',
            'speciality' => 'Neurology'
        ]);
    }
}
