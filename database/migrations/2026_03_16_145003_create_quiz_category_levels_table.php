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
        Schema::create('quiz_category_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('question_categories')->cascadeOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('question_levels')->nullOnDelete();
            $table->integer('question_count')->comment('Số câu lấy từ chuyên đề và mức độ này');
            $table->float('score_correct')->default(1)->comment('Điểm khi làm đúng');
            $table->float('score_incorrect')->default(0)->comment('Điểm bị trừ khi làm sai (nếu có)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_category_levels');
    }
};
