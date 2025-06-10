<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\CourseStep;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseStep>
 */
class CourseStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true), // Simulates Markdown-like content
            'order' => $this->faker->numberBetween(1, 100),
            'weight' => $this->faker->randomElement([10, 20, 25, 50, 100]),
        ];
    }
}
