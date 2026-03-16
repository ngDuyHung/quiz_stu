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
        Schema::create('result_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->constrained('quiz_results')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('selected_option_id')->nullable()->constrained('question_options')->nullOnDelete()->comment('Đáp án user đã chọn');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->float('score')->default(0)->comment('Điểm cho câu này');
            $table->timestamp('answered_at')->useCurrent()->comment('Giờ tick vào đáp án');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_answers');
    }
};
