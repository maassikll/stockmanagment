<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker;

        $faker = $this->faker;
        $first_name = $faker->firstName();
        $last_name = $faker->lastName();
        $phone = $faker->phoneNumber();
        $description = $faker->text(20);
        $adresse = $faker->address();

        return [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'description' =>$description,
            'adresse' => $adresse,
        ];
    }
}
