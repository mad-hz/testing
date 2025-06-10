<?php

namespace App\Models;

use App\Models\traits\HasValidationRequests;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learnpath extends Model
{
    use HasFactory;
    use HasValidationRequests;

    protected $fillable = [
        'title',
        'header',
        'description'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
