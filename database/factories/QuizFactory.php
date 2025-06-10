<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author_id' => User::factory(),
            'description' => collect(range(1, 5))
                ->map(fn () => $this->faker->paragraph(8))
                ->implode("\n\n")
        ];
    }

    public function withQuestions(int $count = 10): static
    {
        return $this->has(
            Question::factory()->count($count),
            'questions'
        );
    }
}
