<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Article;
use App\Models\Permission;
use App\Models\traits\HasValidationRequests;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Quiz;
use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasPermissionsTrait, HasValidationRequests;

    protected $casts = [
        'skills' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'linkedin_url',
        'skills',
        'profile_picture',
        'description',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * A user could have multiple roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Checeks if a user has a specific permission
     * @return boolean
     */
    public function hasPermission($permission): bool
    {
        return $this->permissions->contains($permission) ||
            $this->roles->flatMap->permissions->contains($permission);
    }

    /**
     * A user could also have multiple permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')->withTimestamps();
    }

    public function completedSteps()
    {
        return $this->belongsToMany(CourseStep::class, 'user_completed_steps');
    }

    /**
     * Articles the user has created
     * @return HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
