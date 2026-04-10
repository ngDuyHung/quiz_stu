<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cấu hình Danh mục chuẩn
        $categories = [
            ['id' => 1, 'name' => 'Web Hacking'],
            ['id' => 2, 'name' => 'Network Security'],
            ['id' => 3, 'name' => 'Pentest Methodology'],
        ];
        foreach ($categories as $cat) {
            DB::table('question_categories')->updateOrInsert(['id' => $cat['id']], ['name' => $cat['name']]);
        }

        // 2. Cấu hình Mức độ chuẩn
        $levels = [
            ['id' => 1, 'name' => 'Beginner'],
            ['id' => 2, 'name' => 'Intermediate'],
            ['id' => 3, 'name' => 'Expert'],
        ];
        foreach ($levels as $lv) {
            DB::table('question_levels')->updateOrInsert(['id' => $lv['id']], ['name' => $lv['name']]);
        }

        // 3. Data mẫu đa dạng (30 câu)
        $rawQuestions = [
            "SQL Injection là gì? <script>alert('XSS')</script> <b>Định nghĩa:</b> Một kỹ thuật tấn công phổ biến.",
            "Làm thế nào để bypass <i>WAF</i> khi thực hiện <u>Automated Fuzzing</u>?",
            "Phương pháp <strong>'Hacking AI'</strong> trên APEUni thực chất là gì?",
            "Phân tích lỗ hổng <code>CVE-2025-13942</code> trên thiết bị Zyxel.",
            "Cách thiết lập một <ul><li>Reverse Shell</li><li>Bind Shell</li></ul> trên môi trường Linux.",
            "Sự khác biệt giữa <strong>IDOR</strong> và <strong>BOLA</strong> trong API Security là gì?",
            "Lệnh <code>nmap -sV -p-</code> dùng để làm gì trong giai đoạn Reconnaissance?",
            "Tại sao cần sử dụng <span style='color:red'>Burp Suite</span> trong kiểm thử bảo mật Web?",
            "Lỗ hổng <b>Broken Access Control</b> đứng thứ mấy trong OWASP Top 10?",
        ];

        for ($i = 0; $i < 30; $i++) {
            // Lấy nội dung ngẫu nhiên từ mảng hoặc tạo mới nếu hết
            $content = $rawQuestions[$i % count($rawQuestions)] . " - Phần bổ sung " . Str::random(20);
            
            DB::table('questions')->insert([
                'content' => $content,
                'type' => rand(0, 1) ? 'single' : 'multiple',
                'category_id' => rand(1, 3),
                'level_id' => rand(1, 3),
                'times_served' => rand(50, 200),
                'times_correct' => rand(10, 50),
                'times_incorrect' => rand(10, 50),

            ]);
        }
    }
}