<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        foreach (['Admin', 'RTB-Staff', 'Technician', 'School'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Seed your two custom users
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
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'phone' => $data['phone'],
                    'gender' => $data['gender']
                ]
            );
            $user->assignRole($data['role']);
        }

        // Generate 8 fake users
        $faker = Faker::create();
        $roles = ['RTB-Staff', 'Technician', 'School'];

        for ($i = 0; $i < 8; $i++) {
            $role = $roles[array_rand($roles)];

            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('12345678'),
                'phone' => $faker->phoneNumber,
                'gender' => $faker->randomElement(['Male', 'Female']),
            ]);

            $user->assignRole($role);
        }
    }
}