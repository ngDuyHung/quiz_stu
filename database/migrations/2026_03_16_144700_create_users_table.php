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
        // 1. Bảng users (Kết hợp Laravel mặc định + ERD của bạn)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('student_code', 15)->unique()->nullable()->comment('Mã số sinh viên');
            $table->string('email')->unique()->comment('Email đăng nhập');
            $table->timestamp('email_verified_at')->nullable();
            
            // Laravel Auth sử dụng cột 'password', nên giữ tên này thay vì 'password_hash'
            $table->string('password')->comment('Mật khẩu mã hóa'); 
            
            $table->string('first_name', 100)->comment('Tên');
            $table->string('last_name', 100)->comment('Họ');
            $table->string('phone', 20)->nullable()->comment('Số điện thoại');
            
            // Các khóa ngoại (Lưu ý: các bảng faculties, classes, user_groups phải được tạo trước bảng users)
            $table->foreignId('group_id')->nullable()->constrained('user_groups')->nullOnDelete()->comment('Nhóm: đầu/giữa/cuối khóa');
            $table->tinyInteger('role')->default(0)->comment('0=Sinh viên, 1=Admin/GV');
            
            $table->string('class_id', 20)->nullable()->comment('Mã lớp học');
            $table->foreign('class_id')->references('id')->on('classes')->nullOnDelete();
            
            $table->string('faculty_id', 10)->nullable()->comment('Mã khoa');
            $table->foreign('faculty_id')->references('id')->on('faculties')->nullOnDelete();
            
            $table->date('birthdate')->nullable()->comment('Ngày sinh');
            $table->string('academic_year', 9)->nullable()->comment('Niên khóa. VD: 2022-2026');
            $table->string('degree_type', 20)->nullable()->comment('Hệ đào tạo: Đại học / Cao đẳng');
            $table->string('photo', 255)->nullable()->comment('Ảnh đại diện');
            $table->string('status', 10)->default('active')->comment('Trạng thái: active / inactive');
            
            $table->rememberToken();
            $table->timestamps(); // Sẽ tự tạo created_at và updated_at
        });

        // 2. Bảng password_reset_tokens (Giữ nguyên của Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Bảng sessions (Giữ nguyên của Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};