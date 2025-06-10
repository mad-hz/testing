<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'type',
        'title',
        'description',
        'url',
        'file_path',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

