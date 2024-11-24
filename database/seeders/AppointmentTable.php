<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Schedule;
use Faker\Factory as Faker;

class AppointmentTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // Assuming there are already users, doctors, and schedules created
        $patient_ids = User::whereHas('roles', function ($query) {
            $query->where('name', 'Patient');
        })->pluck('id')->toArray();
        $doctor_ids = User::whereHas('roles', function ($query) {
            $query->where('name', 'Doctor');
        })->pluck('id')->toArray();
        $schedule_ids = Schedule::pluck('id')->toArray();
        // Create 5 appointments
        for ($i = 0; $i < 5; $i++) {
            Appointment::create([
                'patient_id' => $faker->randomElement($patient_ids),
                'doctor_id' => $faker->randomElement($doctor_ids),
                'schedule_id' => $faker->randomElement($schedule_ids),
                'status' => $faker->randomElement(['pending', 'approved', 'canceled']),
            ]);
        }
    }
}
