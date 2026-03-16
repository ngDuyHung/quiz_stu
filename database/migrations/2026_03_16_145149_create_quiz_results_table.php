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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status', 20)->default('open')->comment('Trạng thái bài thi: open / completed / expired');
            $table->dateTime('started_at')->comment('Giờ bắt đầu làm bài');
            $table->dateTime('ended_at')->nullable()->comment('Giờ nộp bài');
            $table->integer('total_seconds')->default(0)->comment('Tổng thời gian đã làm (giây)');
            $table->float('score')->default(0)->comment('Điểm số đạt được');
            $table->float('percentage')->default(0)->comment('Phần trăm đúng');
            $table->string('ip_address', 45)->nullable()->comment('IP máy tính khi làm bài');
            $table->string('photo_proof', 255)->nullable()->comment('Ảnh chụp bằng webcam làm bằng chứng (nếu có)');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
