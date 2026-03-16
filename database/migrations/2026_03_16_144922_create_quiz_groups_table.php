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
        Schema::create('quiz_groups', function (Blueprint $table) {
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('group_id')->constrained('user_groups')->cascadeOnDelete();
            $table->primary(['quiz_id', 'group_id']); // Khóa chính kết hợp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_groups');
    }
};
