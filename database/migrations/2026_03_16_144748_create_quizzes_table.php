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
            $table->string('name', 500)->comment('Tên bài thi');
            $table->text('description')->nullable()->comment('Mô tả bài thi');
            $table->dateTime('start_date')->nullable()->comment('Thời gian bắt đầu');
            $table->dateTime('end_date')->nullable()->comment('Thời gian kết thúc');
            $table->integer('duration_minutes')->default(40)->comment('Thời gian làm bài (phút)');
            $table->integer('max_attempts')->default(1)->comment('Số lần làm bài tối đa');
            $table->float('pass_percent')->default(50)->comment('Phần trăm điểm cần để qua môn');
            $table->boolean('show_answer')->default(1)->comment('1: Cho phép xem đáp án, 0: Không');
            $table->boolean('require_camera')->default(0)->comment('1: Yêu cầu bật camera');
            $table->boolean('shuffle_questions')->default(1)->comment('1: Trộn câu hỏi');
            $table->boolean('require_login')->default(1)->comment('1: Yêu cầu đăng nhập');
            $table->boolean('is_demo')->default(0)->comment('1: Bài thi thử nghiệm');
            $table->timestamp('created_at')->useCurrent();
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
