<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStepsTable extends Migration
{
    public function up(): void
    {
        Schema::create('course_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->longText('content'); // markdown content
            $table->integer('order')->default(0); // ordering inside course
            $table->unsignedInteger('weight')->default(0); // contributes to course progress
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_steps');
    }
}

