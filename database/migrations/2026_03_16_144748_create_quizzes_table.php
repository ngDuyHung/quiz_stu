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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->text('description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('duration_minutes')->default(60);
            $table->integer('max_attempts')->default(1);
            $table->integer('pass_percent')->default(50);
            $table->boolean('show_answer')->default(false);
            $table->boolean('require_camera')->default(false);
            $table->boolean('shuffle_questions')->default(false);
            $table->boolean('require_login')->default(true);
            $table->boolean('is_demo')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
