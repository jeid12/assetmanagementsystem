<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name_tag'          => 'DEFAULT-' . Str::random(7),
            'category'          => $this->faker->randomElement(['Laptop', 'Projector', 'Tablet', 'Printer']),
            'slug'              => $this->faker->slug(),
            'model'             => strtoupper($this->faker->bothify('Model-###')),
            'serial_number'     => strtoupper(Str::uuid()),
            'brand'             => $this->faker->randomElement(['HP', 'Dell', 'Lenovo', 'Apple', 'Samsung']),
            'specifications'    => [
                'RAM' => $this->faker->randomElement(['4GB', '8GB', '16GB']),
                'Storage' => $this->faker->randomElement(['128GB', '256GB', '512GB']),
                'Processor' => $this->faker->randomElement(['i3', 'i5', 'i7', 'Ryzen 5']),
            ],
            'purchase_date'     => $this->faker->date(),
            'warranty_expiry'   => $this->faker->dateTimeBetween('now', '+2 years'),
            'current_status'    => $this->faker->randomElement(['available', 'in_use', 'maintenance', 'retired']),
            'current_school_id' => $this->faker->randomElement([1, 2, 3, null]),
            'purchase_cost'     => $this->faker->randomFloat(2, 100, 1500),
            'notes'             => $this->faker->sentence(),
        ];
    }
}