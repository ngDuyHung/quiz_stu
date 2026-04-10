# Quiz STU – Hệ thống thi trực tuyến

Ứng dụng thi trắc nghiệm trực tuyến dành cho sinh viên Trường Đại học Công nghệ TP.HCM (STU). Được xây dựng trên **Laravel 12**, hỗ trợ đầy đủ luồng từ quản trị đề thi đến sinh viên làm bài và xem kết quả.

---

## Tech Stack

| Layer | Công nghệ |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, Tailwind CSS (CDN), Vanilla JS |
| Database | MySQL |
| Auth | Laravel Session Auth (middleware theo role) |
| Storage | Laravel Storage (disk `public`) |
| Export/Import | Maatwebsite Excel 3.1 |

---

## Tài khoản mặc định (Seeder)

| Vai trò | Email | Mật khẩu |
|---|---|---|
| Admin / Giảng viên | `admin@stu.edu.vn` | `admin123` |
| Sinh viên (Nhóm A+B) | `student@stu.edu.vn` | `student123` |
| Sinh viên (Nhóm A) | `nguyen.van.a@stu.edu.vn` | `student123` |
| Sinh viên (Nhóm B) | `pham.thi.d@stu.edu.vn` | `student123` |

---

## Cài đặt

```bash
# 1. Clone & cài dependencies
git clone <repo-url>
cd quiz_stu
composer install

# 2. Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# 3. Cấu hình DB trong .env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quiz_stu
DB_USERNAME=root
DB_PASSWORD=

# 4. Migrate & seed dữ liệu test
php artisan migrate
php artisan db:seed --class=QuizTestSeeder

# 5. Tạo symlink storage
php artisan storage:link

# 6. Chạy server
php artisan serve
```

---

## Cấu trúc chính

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Quản trị: dashboard, quiz, câu hỏi, users, nhóm
│   │   └── Client/         # Sinh viên: dashboard, làm bài, kết quả, hồ sơ
│   └── Middleware/         # admin.only / client.only
├── Models/                 # Eloquent models
├── Console/Commands/       # ExpireQuizzes (cron)
└── Services/

database/
├── migrations/             # 22 bảng
└── seeders/                # QuizTestSeeder (60 câu hỏi, 4 đề thi)

resources/views/
├── admin/                  # Giao diện quản trị
└── client/                 # Giao diện sinh viên
    ├── partials/           # sidebar.blade.php, header.blade.php
    └── quizzes/            # take.blade.php (trang làm bài)
```

---

## Tính năng

### Admin / Giảng viên (`/admin/*`)
- Quản lý người dùng, lớp học, khoa, nhóm thi
- Tạo đề thi: cấu hình thời gian, số lượt, camera, xáo trộn câu hỏi
- Quản lý câu hỏi & đáp án theo danh mục và mức độ
- Import sinh viên từ file CSV/Excel

### Sinh viên (`/client/*`)

| Route | Tính năng |
|---|---|
| `/client/dashboard` | Danh sách bài thi đang mở, countdown, badge trạng thái |
| `/client/exams` | Tất cả bài thi được phép, lọc theo trạng thái |
| `/client/quiz/{id}/start` | Bắt đầu bài thi, random câu hỏi theo cấu hình |
| `/client/quiz/{id}/take/{result}` | Giao diện làm bài: sidebar, đồng hồ đếm ngược, camera |
| `/client/quiz/{result}/result` | Kết quả: điểm, %, xem lại đáp án, biểu đồ danh mục |
| `/client/history` | Lịch sử thi, badge "Chưa phản hồi" |
| `/client/profile` | Thông tin cá nhân, đổi ảnh, đổi mật khẩu |

### Engine làm bài
- Đồng hồ đếm ngược server-side + client-side, auto-submit khi hết giờ
- Lưu đáp án AJAX theo thời gian thực (chỉ UPDATE, không INSERT)
- Hỗ trợ xáo trộn câu hỏi & đáp án (deterministic theo `result_id`)
- Chụp ảnh webcam khi nộp bài (`require_camera`)
- Tính điểm theo `score_correct / score_incorrect` từng danh mục–mức độ

### Cron Job
```bash
# Tự động expire bài thi hết giờ
* * * * * php artisan quiz:expire

# Kiểm tra không ghi DB
php artisan quiz:expire --dry-run
```

---

## Database (các bảng chính)

| Bảng | Mô tả |
|---|---|
| `users` | Sinh viên & admin, có `role`, `group_id`, `photo` |
| `quizzes` | Đề thi: thời gian, số lượt, camera, xáo trộn |
| `questions` / `question_options` | Câu hỏi & đáp án (có `is_correct`) |
| `quiz_category_levels` | Cấu hình điểm theo danh mục × mức độ |
| `quiz_results` | Kết quả mỗi lần thi: điểm, %, trạng thái |
| `result_answers` | Đáp án từng câu của sinh viên |
| `quiz_feedbacks` | Đánh giá 4 tiêu chí (1–5 sao) sau khi thi |

---

## License

MIT

