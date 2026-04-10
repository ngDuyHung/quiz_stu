<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ─── FIX 1: Thêm cột 'name' vào bảng 'classes' ───────────────────────
        if (!Schema::hasColumn('classes', 'name')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('name', 100)->after('id');
            });
        }

        // ─── FIX 2: Cấu trúc lại bảng 'school_years' ─────────────────────────
        // DB hiện tại: composite PK (year varchar, semester tinyint), không có id/timestamps
        // Mục tiêu: thêm id auto-increment PK, unique(year,semester), timestamps

        if (!Schema::hasColumn('school_years', 'id')) {
            // Bước 1: Bỏ composite primary key cũ
            DB::statement('ALTER TABLE `school_years` DROP PRIMARY KEY');

            // Bước 2: Thêm cột id auto-increment làm PK mới
            DB::statement('ALTER TABLE `school_years` ADD COLUMN `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');

            // Bước 3: Thêm unique constraint trên (year, semester)
            Schema::table('school_years', function (Blueprint $table) {
                $table->unique(['year', 'semester']);
            });

            // Bước 4: Thêm timestamps
            Schema::table('school_years', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Rollback classes
        if (Schema::hasColumn('classes', 'name')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        // Rollback school_years (trả về composite PK cũ)
        if (Schema::hasColumn('school_years', 'id')) {
            Schema::table('school_years', function (Blueprint $table) {
                $table->dropTimestamps();
                $table->dropUnique(['year', 'semester']);
            });
            DB::statement('ALTER TABLE `school_years` DROP PRIMARY KEY, DROP COLUMN `id`');
            DB::statement('ALTER TABLE `school_years` ADD PRIMARY KEY (`year`, `semester`)');
        }
    }
};
