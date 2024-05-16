<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $faker = $this->faker;
        $init_price = $faker->randomFloat(2, 0, 100);
        $selling_price = $faker->randomFloat(2, 150, 200);
        $profit = $selling_price - $init_price;


        return [
            'name' => $faker->sentence(),
            'qte' => $faker->randomNumber(3, true),
            'init_price' => $init_price,
            'selling_price' => $selling_price,
            'profit' => $profit,
        ];

        
    }
}
