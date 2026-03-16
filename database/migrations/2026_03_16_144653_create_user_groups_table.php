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
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->comment('Tên nhóm: Đầu khóa / Giữa khóa / Cuối khóa');
            $table->text('description')->nullable()->comment('Mô tả nhóm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_groups');
    }
};
