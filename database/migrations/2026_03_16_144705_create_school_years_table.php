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
            $table->id(); // Khóa chính đơn (Laravel cực thích cái này)
            $table->string('year', 9)->comment('VD: 2024-2025');
            $table->tinyInteger('semester')->comment('1 hoặc 2');
            $table->boolean('is_active')->default(0);
            $table->timestamps();

            // Ràng buộc để không bao giờ có 2 dòng trùng cả Năm và Kỳ
            $table->unique(['year', 'semester']); 
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
