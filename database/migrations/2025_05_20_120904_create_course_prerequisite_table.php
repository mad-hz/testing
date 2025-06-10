<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_prerequisite', function (Blueprint $table) {
        $table->unsignedBigInteger('course_id');
        $table->unsignedBigInteger('prerequisite_id');

        $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        $table->foreign('prerequisite_id')->references('id')->on('courses')->onDelete('cascade');

        $table->primary(['course_id', 'prerequisite_id']);
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_prerequisite');
    }
};
