<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalImage;
use App\Models\User;
use Faker\Factory as Faker;

class MedicalImageTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // Assuming there are already patients created
        $patient_ids = User::whereHas('roles', function ($query) {
            $query->where('name', 'Patient');
        })->pluck('id')->toArray();
        // Create 5 medical images
        for ($i = 0; $i < 5; $i++) {
            MedicalImage::create([
                'patient_id' => $faker->randomElement($patient_ids),
                'file_path' => $faker->imageUrl,
                'description' => $faker->sentence,
            ]);
        }
    }
}
