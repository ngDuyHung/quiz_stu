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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100)->default('single')->comment('Loại câu hỏi: single / multiple / match');
            $table->text('content')->comment('Nội dung câu hỏi (hỗ trợ HTML)');
            $table->text('description')->nullable()->comment('Mô tả/Giải thích câu hỏi');
            $table->foreignId('category_id')->constrained('question_categories')->cascadeOnDelete()->comment('Thuộc danh mục nào');
            $table->foreignId('level_id')->nullable()->constrained('question_levels')->nullOnDelete()->comment('Độ khó');
            $table->integer('times_served')->default(0)->comment('Số lần xuất hiện trong đề thi');
            $table->integer('times_correct')->default(0)->comment('Số lần trả lời đúng');
            $table->integer('times_incorrect')->default(0)->comment('Số lần trả lời sai');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
