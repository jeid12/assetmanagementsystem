<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequestType;

class RequestTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Maintenance Request', 'slug' => 'maintenance'],
            ['name' => 'New Device Request', 'slug' => 'new-device'],
            ['name' => 'Other Report', 'slug' => 'other'],
        ];
    
        foreach ($types as $type) {
            RequestType::create($type);
        }
    }
}