<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;

class SchedulesTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua ID dokter
        $doctor_ids = User::whereHas('roles', function ($query) {
            $query->where('name', 'Doctor');
        })->pluck('id')->toArray();

        // Definisikan hari kerja dan jam konsultasi
        $workingDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $shifts = [
            ['09:00:00', '10:30:00'],
            ['10:30:00', '12:00:00'],
            ['13:00:00', '14:30:00'],
            ['14:30:00', '16:00:00'],
            ['16:00:00', '17:30:00'],
        ];

        // Tentukan tanggal mulai untuk dua minggu ke depan
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->addWeeks(2)->endOfWeek();

        // Buat jadwal untuk dua minggu ke depan
        $currentDate = $startDate->copy();
        $doctorIndex = 0;

        while ($currentDate->lessThanOrEqualTo($endDate)) {
            if (in_array($currentDate->format('l'), $workingDays)) {
                foreach ($shifts as $shift) {
                    // Pilih dokter secara berurutan untuk setiap shift
                    $doctor_id = $doctor_ids[$doctorIndex % count($doctor_ids)];
                    $doctorIndex++;

                    Schedule::create([
                        'doctor_id' => $doctor_id,
                        'date' => $currentDate->format('Y-m-d'),
                        'start_time' => $shift[0],
                        'end_time' => $shift[1],
                    ]);
                }
            }
            // Pindah ke hari berikutnya
            $currentDate->addDay();
        }
    }
}
