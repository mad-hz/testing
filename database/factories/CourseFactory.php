<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition(): array
    {
         return [
        'title' => $this->faker->sentence(3),
        'description' => $this->faker->paragraph(),
        'credits' => $this->faker->numberBetween(1, 5),
    ];
    }
}
