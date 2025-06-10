<?php

namespace App\Models;

use App\Models\traits\HasValidationRequests;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    use HasValidationRequests;

    protected $fillable = [
        'title',
        'description',
        'credits',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')->withTimestamps();
    }

    public function steps()
    {
        return $this->hasMany(CourseStep::class)->orderBy('order');
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisite', 'course_id', 'prerequisite_id');
    }

    public function dependentCourses()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisite', 'prerequisite_id', 'course_id');
    }

    // In app/Models/Course.php

    public function checkPrerequisitesForUser($user)
    {
        if (!$user) {
            return false; // Not logged in users cannot enroll
        }

        // Get the IDs of courses the user is enrolled in
        $enrolledCourseIds = $user->courses()->pluck('courses.id')->toArray();

        // Check if all prerequisite courses are enrolled
        foreach ($this->prerequisites as $prereq) {
            if (!in_array($prereq->id, $enrolledCourseIds)) {
                return false; // missing prerequisite
            }
        }

        return true;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resources()
    {
        return $this->hasMany(CourseResource::class);
    }
}
