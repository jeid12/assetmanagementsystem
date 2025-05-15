<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Device;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      // Ensure roles exist
    foreach (['Admin', 'RTB-Staff', 'Technician', 'School'] as $roleName) {
        Role::firstOrCreate(['name' => $roleName]);
    }

    // Create users
    $users = [
        [
            "name" => "Alice Mugenzi",
            "email" => "athegunners90@gmail.com",
            "password" => "12345678",
            "role" => "Admin",
            "phone" => "0788123456",
            "gender" => "Female",
        ],
        [
            "name" => "Alice Mugenzi",
            "email" => "niyokwizerajd123@gmail.com",
            "password" => "12345678",
            "role" => "Admin",
            "phone" => "0788123456",
            "gender" => "Male",
        ]
    ];

    foreach ($users as $data) {
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'gender' => $data['gender']
            ]
        );

        // Assign role
        $user->assignRole($data['role']);
    }
}
}