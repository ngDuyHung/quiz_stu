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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200)->comment('Tiêu đề thông báo');
            $table->text('content')->nullable()->comment('Nội dung thông báo');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Người tạo thông báo');
            $table->dateTime('start_date')->nullable()->comment('Ngày bắt đầu hiển thị');
            $table->dateTime('end_date')->nullable()->comment('Ngày kết thúc hiển thị');
            $table->boolean('status')->default(1)->comment('0=Ẩn, 1=Hiển thị');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
