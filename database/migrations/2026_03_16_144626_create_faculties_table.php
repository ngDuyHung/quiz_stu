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
        Schema::create('faculties', function (Blueprint $table) {
            $table->string('id', 10)->primary()->comment('Mã khoa. VD: cntt, qtkd, ckhi');
            $table->string('name', 100)->comment('Tên khoa. VD: Công Nghệ Thông Tin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
