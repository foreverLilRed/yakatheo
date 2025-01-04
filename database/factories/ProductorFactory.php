<?php

namespace Database\Factories;

use App\Models\Community;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productor>
 */
class ProductorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'names' => $this->faker->firstName,          // Nombre ficticio
            'surnames' => $this->faker->lastName,        // Apellido ficticio
            'dni' => $this->faker->unique()->numerify('########'), // DNI único
            'birthday' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'community_id' => Community::pluck('id')->random(),
        ];
    }
}
