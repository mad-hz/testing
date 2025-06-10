<?php

namespace App\Models;

use App\Models\traits\HasValidationRequests;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;
    use HasValidationRequests;

    protected $fillable = [
        'name',
        'description',
        'banner'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }



}
