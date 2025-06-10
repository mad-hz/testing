<?php

namespace Database\Seeders;

use App\Models\Learnpath;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LearnpathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Learnpath::factory(10)->create();
    }
}
