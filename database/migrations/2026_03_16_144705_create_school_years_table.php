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
        Schema::create('school_years', function (Blueprint $table) {
            $table->string('year', 9)->comment('Năm học. VD: 2024-2025');
            $table->tinyInteger('semester')->comment('Học kỳ: 1 hoặc 2');
            $table->boolean('is_active')->default(0)->comment('0: Không hoạt động, 1: Đang hoạt động');

            // Khóa chính kết hợp (Composite Primary Key)
            $table->primary(['year', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_years');
    }
};
