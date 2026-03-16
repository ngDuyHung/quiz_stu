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
        Schema::create('quiz_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('user_groups')->cascadeOnDelete()->comment('Áp dụng cho nhóm nào');
            $table->string('faculty_id', 10)->nullable()->comment('Áp dụng cho khoa nào');
            $table->foreign('faculty_id')->references('id')->on('faculties')->cascadeOnDelete();
            $table->dateTime('start_date')->comment('Giờ mở thi');
            $table->dateTime('end_date')->comment('Giờ đóng thi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_schedules');
    }
};
