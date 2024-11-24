<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Permissions
        $permissions = [
            'user',
            'create user',
            'edit user',
            'view user',
            'delete user',
            'appointment',
            'create appointment',
            'edit appointment',
            'view appointment',
            'delete appointment',
            'medical image',
            'create medical image',
            'edit medical image',
            'view medical image',
            'delete medical image',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $doctorRole = Role::create(['name' => 'Doctor']);
        $patientRole = Role::create(['name' => 'Patient']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        $doctorRole->givePermissionTo([
            'user',
            'edit user',
            'view user',
            'appointment',
            'edit appointment',
            'view appointment',
            'medical image',
            'view medical image',
        ]);
        $patientRole->givePermissionTo([
            'user',
            'edit user',
            'view user',
            'appointment',
            'create appointment',
            'edit appointment',
            'view appointment',
            'medical image',
            'create medical image',
            'edit medical image',
            'view medical image',
            'delete medical image',
        ]);

        // Create users and assign roles
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
        $admin->assignRole('Admin');

        for ($i = 0; $i < 8; $i++) {
            $doctor = User::create([
                'name' => 'dr. ' . $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);
            $doctor->assignRole('Doctor');
        }

        for ($i = 0; $i < 4; $i++) {
            $patient = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);
            $patient->assignRole('Patient');
        }
    }
}
