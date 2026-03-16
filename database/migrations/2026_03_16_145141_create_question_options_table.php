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
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->text('content')->comment('Nội dung câu trả lời');
            $table->string('match_text', 500)->nullable()->comment('Dùng cho câu hỏi dạng ghép cặp');
            $table->boolean('is_correct')->default(0)->comment('1 là đáp án đúng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};
