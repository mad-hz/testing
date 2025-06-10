<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 courses first
        $courses = Course::factory(20)->create();

        // Assign random prerequisites for each course
        foreach ($courses as $course) {
            // Number of prereqs: between 0 and 3
            $prereqCount = rand(0, 3);

            // Get other courses as potential prerequisites
            $potentialPrereqs = $courses->where('id', '!=', $course->id);

            if ($potentialPrereqs->count() > 0 && $prereqCount > 0) {
                // Select random prerequisites
                $prereqs = $potentialPrereqs->random(min($prereqCount, $potentialPrereqs->count()));

                // Attach the prerequisites (many-to-many relation)
                $course->prerequisites()->sync($prereqs->pluck('id')->toArray());
            }
        }
    }
}
