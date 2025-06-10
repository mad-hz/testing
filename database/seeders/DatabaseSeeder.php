<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'test',
            'password' => bcrypt('1'),
        ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            RoleUserSeeder::class,
        ]);

        $this->call(QuizSeeder::class);
        user::factory(10)->create();
        $this->call([
            ArticleSeeder::class,
        ]);

        $this->call([CourseStepSeeder::class]);
    }
}
