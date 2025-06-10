<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseStep;

class CourseStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        Course::all()->each(function ($course) {
            CourseStep::factory()
                ->count(rand(3, 5))
                ->create(['course_id' => $course->id]);
        });
    }
}
