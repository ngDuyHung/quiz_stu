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
        Schema::create('quiz_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('result_id')->nullable()->constrained('quiz_results')->cascadeOnDelete();
            $table->tinyInteger('formality_score')->nullable()->comment('Điểm hình thức (1–5)');
            $table->tinyInteger('time_score')->nullable()->comment('Điểm thời gian thi (1–5)');
            $table->tinyInteger('content_score')->nullable()->comment('Điểm nội dung thi (1–5)');
            $table->tinyInteger('presenter_score')->nullable()->comment('Điểm trình bày (1–5)');
            $table->text('suggestion')->nullable()->comment('Góp ý thêm');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_feedbacks');
    }
};
