<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class QuizTestSeeder extends Seeder
{
    public function run(): void
    {
        // ═══════════════════════════════════
        //  1. FACULTIES
        // ═══════════════════════════════════
        $faculties = [
            ['id' => 'cntt',  'name' => 'Công nghệ Thông tin'],
            ['id' => 'qtkd',  'name' => 'Quản trị Kinh doanh'],
            ['id' => 'ckhi',  'name' => 'Cơ khí – Điện'],
        ];
        foreach ($faculties as $f) {
            DB::table('faculties')->updateOrInsert(['id' => $f['id']], ['name' => $f['name']]);
        }

        // ═══════════════════════════════════
        //  2. CLASSES
        // ═══════════════════════════════════
        $classes = [
            ['id' => 'CNTT22A', 'name' => 'CNTT K2022 Lớp A', 'faculty_id' => 'cntt'],
            ['id' => 'CNTT22B', 'name' => 'CNTT K2022 Lớp B', 'faculty_id' => 'cntt'],
            ['id' => 'QTKD22A', 'name' => 'QTKD K2022 Lớp A', 'faculty_id' => 'qtkd'],
        ];
        foreach ($classes as $c) {
            DB::table('classes')->updateOrInsert(
                ['id' => $c['id']],
                ['name' => $c['name'], 'faculty_id' => $c['faculty_id'],
                 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // ═══════════════════════════════════
        //  3. USER GROUPS
        // ═══════════════════════════════════
        $groups = [
            ['name' => 'CNTT K2022 – Nhóm A', 'description' => 'Sinh viên CNTT khóa 2022, lớp A'],
            ['name' => 'CNTT K2022 – Nhóm B', 'description' => 'Sinh viên CNTT khóa 2022, lớp B'],
        ];
        $groupIds = [];
        foreach ($groups as $g) {
            $existing = DB::table('user_groups')->where('name', $g['name'])->first();
            if ($existing) {
                $groupIds[] = $existing->id;
            } else {
                $groupIds[] = DB::table('user_groups')->insertGetId($g);
            }
        }
        [$groupA, $groupB] = $groupIds;

        // ═══════════════════════════════════
        //  4. USERS – admin + 5 sinh viên
        // ═══════════════════════════════════
        // Admin
       DB::table('users')->updateOrInsert(
            ['student_code' => 'ADMIN001'], // Điều kiện tìm kiếm
            [
                'email' => 'admin@stu.edu.vn',
                'first_name' => 'Admin',
                'last_name' => 'Hệ thống',
                'role' => 1,
                'status' => 'active',
                'password' => Hash::make('password'), // Hoặc pass gì đó Duy đặt
            ]
        );

        $students = [
            ['code' => 'STU2022001', 'email' => 'nguyen.van.a@stu.edu.vn',    'last' => 'Nguyễn Văn', 'first' => 'An',    'class' => 'CNTT22A', 'faculty' => 'cntt', 'group' => $groupA],
            ['code' => 'STU2022002', 'email' => 'tran.thi.b@stu.edu.vn',     'last' => 'Trần Thị',   'first' => 'Bình',  'class' => 'CNTT22A', 'faculty' => 'cntt', 'group' => $groupA],
            ['code' => 'STU2022003', 'email' => 'le.van.c@stu.edu.vn',       'last' => 'Lê Văn',     'first' => 'Cường', 'class' => 'CNTT22A', 'faculty' => 'cntt', 'group' => $groupA],
            ['code' => 'STU2022004', 'email' => 'pham.thi.d@stu.edu.vn',     'last' => 'Phạm Thị',   'first' => 'Dung',  'class' => 'CNTT22B', 'faculty' => 'cntt', 'group' => $groupB],
            ['code' => 'STU2022005', 'email' => 'hoang.van.e@stu.edu.vn',    'last' => 'Hoàng Văn',  'first' => 'Em',    'class' => 'CNTT22B', 'faculty' => 'cntt', 'group' => $groupB],
            // Sinh viên demo dễ nhớ
            ['code' => 'STU0001',    'email' => 'student@stu.edu.vn',         'last' => 'Sinh',       'first' => 'Viên',  'class' => 'CNTT22A', 'faculty' => 'cntt', 'group' => $groupA],
        ];

        foreach ($students as $s) {
            DB::table('users')->updateOrInsert(
                ['email' => $s['email']],
                [
                    'student_code' => $s['code'],
                    'password'     => Hash::make('student123'),
                    'first_name'   => $s['first'],
                    'last_name'    => $s['last'],
                    'role'         => 0,
                    'status'       => 'active',
                    'class_id'     => $s['class'],
                    'faculty_id'   => $s['faculty'],
                    'group_id'     => $s['group'],
                    'academic_year'=> '2022-2026',
                    'degree_type'  => 'Đại học',
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }

        // ═══════════════════════════════════
        //  5. QUESTION CATEGORIES
        // ═══════════════════════════════════
        $categories = [
            1 => 'Lập trình Web – Laravel & PHP',
            2 => 'JavaScript & Frontend',
            3 => 'Cơ sở dữ liệu',
            4 => 'Mạng máy tính & Bảo mật',
            5 => 'Cấu trúc dữ liệu & Giải thuật',
        ];
        foreach ($categories as $id => $name) {
            DB::table('question_categories')->updateOrInsert(['id' => $id], ['name' => $name]);
        }

        // ═══════════════════════════════════
        //  6. QUESTION LEVELS
        // ═══════════════════════════════════
        $levels = [1 => 'Dễ', 2 => 'Trung bình', 3 => 'Khó'];
        foreach ($levels as $id => $name) {
            DB::table('question_levels')->updateOrInsert(['id' => $id], [
                'name'       => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ═══════════════════════════════════
        //  7. QUESTIONS + OPTIONS  (60 câu)
        // ═══════════════════════════════════
        // Xóa dữ liệu cũ của QuestionSeeder (nếu có) để tránh trùng
        // (không xóa ở đây – dùng insertGetId để tạo mới)

        $questions = [
            // ─── Category 1: Laravel/PHP ─── Level 1 (Dễ) ×6
            [1, 1, 'Laravel là framework PHP theo mô hình kiến trúc nào?',
             ['MVC', 'MVVM', 'MVP', 'Event-Driven'], 0],
            [1, 1, 'Lệnh Artisan nào dùng để tạo một Migration mới?',
             ['php artisan make:migration', 'php artisan migration:create', 'php artisan db:migrate', 'php artisan schema:make'], 0],
            [1, 1, 'Tệp nào chứa cấu hình kết nối cơ sở dữ liệu trong Laravel?',
             ['.env', 'config/app.php', 'bootstrap/app.php', 'routes/web.php'], 0],
            [1, 1, 'Route::get() trong Laravel nhận tham số thứ mấy là callback/controller?',
             ['Tham số thứ hai', 'Tham số thứ nhất', 'Tham số thứ ba', 'Tham số đầu tiên hoặc cuối'], 0],
            [1, 1, 'Blade directive nào dùng để hiển thị dữ liệu và tự động escape HTML?',
             ['{{ $var }}', '{!! $var !!}', '@echo $var', '@print $var'], 0],
            [1, 1, 'ORM (Object-Relational Mapping) mặc định của Laravel là gì?',
             ['Eloquent', 'Doctrine', 'Hibernate', 'Propel'], 0],

            // ─── Category 1: Laravel/PHP ─── Level 2 (TB) ×5
            [1, 2, 'Middleware trong Laravel dùng để làm gì?',
             ['Lọc HTTP request trước/sau khi vào controller', 'Kết nối database', 'Render giao diện Blade', 'Gửi email tự động'], 0],
            [1, 2, 'Phương thức nào trong Eloquent dùng để lấy kết quả đầu tiên hoặc trả về null?',
             ['first()', 'find()', 'get()', 'all()'], 0],
            [1, 2, 'Eager loading trong Eloquent được thực hiện bằng method nào?',
             ['with()', 'load()', 'include()', 'attach()'], 0],
            [1, 2, 'Service Provider trong Laravel có vai trò gì?',
             ['Đăng ký binding vào Service Container', 'Xử lý request đến', 'Render view Blade', 'Quản lý session'], 0],
            [1, 2, '<code>$request->validate()</code> sẽ ném ra exception gì khi thất bại?',
             ['ValidationException', 'HttpException', 'ModelNotFoundException', 'AuthorizationException'], 0],

            // ─── Category 1: Laravel/PHP ─── Level 3 (Khó) ×4
            [1, 3, 'Khi dùng <code>Route::resource()</code>, action nào tương ứng với HTTP DELETE?',
             ['destroy()', 'delete()', 'remove()', 'drop()'], 0],
            [1, 3, 'Laravel Queue dùng để giải quyết vấn đề gì chính?',
             ['Xử lý tác vụ nặng bất đồng bộ', 'Cache dữ liệu truy vấn', 'Nén file tĩnh', 'Quản lý phiên đăng nhập'], 0],
            [1, 3, 'Trait <code>SoftDeletes</code> trong Eloquent thêm cột nào vào bảng?',
             ['deleted_at', 'is_deleted', 'removed_at', 'trash_at'], 0],
            [1, 3, 'Trong Laravel, <code>php artisan optimize</code> thực hiện điều gì?',
             ['Cache config, route và view để tăng tốc', 'Xóa tất cả file cache', 'Chạy migration mới nhất', 'Tạo symbolic link storage'], 0],

            // ─── Category 2: JS/Frontend ─── Level 1 (Dễ) ×6
            [2, 1, 'Phương thức JavaScript nào dùng để chọn một phần tử theo ID?',
             ['document.getElementById()', 'document.querySelector()', 'document.getElement()', 'document.byId()'], 0],
            [2, 1, 'Kiểu dữ liệu nào KHÔNG tồn tại trong JavaScript?',
             ['character', 'string', 'number', 'boolean'], 0],
            [2, 1, 'Từ khóa nào khai báo biến block-scope trong ES6+?',
             ['let', 'var', 'dim', 'int'], 0],
            [2, 1, 'Arrow function <code>const f = x => x * 2</code> trả về gì khi gọi <code>f(5)</code>?',
             ['10', '5', '25', 'undefined'], 0],
            [2, 1, 'CSS property nào dùng để căn giữa theo trục ngang trong Flexbox?',
             ['justify-content: center', 'align-items: center', 'text-align: center', 'margin: auto'], 0],
            [2, 1, 'Thẻ HTML nào dùng để nhúng script JavaScript ngoài?',
             ['<script src="..."></script>', '<link href="..." />', '<style src="..."></style>', '<js src="..." />'], 0],

            // ─── Category 2: JS/Frontend ─── Level 2 (TB) ×4
            [2, 2, 'Promise trong JavaScript dùng để xử lý vấn đề gì?',
             ['Lập trình bất đồng bộ', 'Tạo vòng lặp vô hạn', 'Khai báo hàm inline', 'Quản lý DOM'], 0],
            [2, 2, '<code>fetch(url).then(r => r.json())</code> trả về gì?',
             ['Promise chứa object JSON', 'String JSON thuần', 'XML object', 'undefined'], 0],
            [2, 2, 'Trong React, Hook nào dùng để quản lý state của component function?',
             ['useState', 'useEffect', 'useRef', 'useContext'], 0],
            [2, 2, 'Event delegation là kỹ thuật gán event listener vào đâu thay vì từng phần tử con?',
             ['Phần tử cha', 'document.body', 'window', 'Phần tử gốc HTML'], 0],

            // ─── Category 3: Database ─── Level 1 (Dễ) ×5
            [3, 1, 'SQL lệnh nào dùng để lấy tất cả dữ liệu từ bảng students?',
             ['SELECT * FROM students', 'GET ALL FROM students', 'FETCH students', 'SHOW students'], 0],
            [3, 1, 'Khóa ngoại (Foreign Key) dùng để làm gì?',
             ['Liên kết dữ liệu giữa hai bảng', 'Tăng tốc truy vấn', 'Mã hóa dữ liệu', 'Tạo index tự động'], 0],
            [3, 1, 'Lệnh SQL nào xóa dữ liệu nhưng giữ cấu trúc bảng?',
             ['DELETE FROM table', 'DROP TABLE table', 'TRUNCATE TABLE table', 'REMOVE FROM table'], 0],
            [3, 1, 'Kiểu dữ liệu VARCHAR(255) lưu tối đa bao nhiêu ký tự?',
             ['255', '256', '128', '512'], 0],
            [3, 1, 'JOIN nào lấy tất cả bản ghi từ bảng trái kể cả không khớp bảng phải?',
             ['LEFT JOIN', 'INNER JOIN', 'FULL JOIN', 'RIGHT JOIN'], 0],

            // ─── Category 3: Database ─── Level 2 (TB) ×4
            [3, 2, 'Chỉ mục (Index) trong database giúp cải thiện điều gì?',
             ['Tốc độ truy vấn SELECT', 'Tốc độ INSERT', 'Tính toàn vẹn dữ liệu', 'Tiết kiệm dung lượng'], 0],
            [3, 2, 'Chuẩn hóa (Normalization) 1NF yêu cầu điều gì?',
             ['Mỗi cột chứa giá trị nguyên tử, không trùng hàng', 'Không có khóa ngoại', 'Tất cả cột phụ thuộc khóa chính', 'Không có giá trị NULL'], 0],
            [3, 2, 'Câu lệnh GROUP BY kết hợp với hàm nào để đếm số bản ghi mỗi nhóm?',
             ['COUNT()', 'SUM()', 'MAX()', 'AVG()'], 0],
            [3, 2, 'ACID trong database là viết tắt của?',
             ['Atomicity, Consistency, Isolation, Durability', 'Access, Control, Index, Database', 'Add, Copy, Insert, Delete', 'Async, Cache, Integrate, Deploy'], 0],

            // ─── Category 4: Network/Security ─── Level 1 (Dễ) ×5
            [4, 1, 'HTTP status code 404 có nghĩa là gì?',
             ['Không tìm thấy tài nguyên', 'Lỗi server nội bộ', 'Yêu cầu thành công', 'Không có quyền truy cập'], 0],
            [4, 1, 'Giao thức nào dùng để truyền tệp an toàn qua mạng?',
             ['SFTP', 'FTP', 'HTTP', 'SMTP'], 0],
            [4, 1, 'IP address 192.168.x.x thuộc dải địa chỉ nào?',
             ['Private (nội bộ)', 'Public (công cộng)', 'Loopback', 'Multicast'], 0],
            [4, 1, 'Cổng mặc định của giao thức HTTPS là bao nhiêu?',
             ['443', '80', '22', '21'], 0],
            [4, 1, 'DNS (Domain Name System) có chức năng chính là gì?',
             ['Dịch tên miền sang địa chỉ IP', 'Mã hóa dữ liệu truyền', 'Gán địa chỉ IP tự động', 'Lọc gói tin mạng'], 0],

            // ─── Category 4: Network/Security ─── Level 2 (TB) ×3
            [4, 2, 'SQL Injection có thể ngăn chặn hiệu quả bằng cách nào?',
             ['Sử dụng Prepared Statements / Parameterized Queries', 'Thêm CAPTCHA vào form', 'Ẩn tên bảng trong URL', 'Dùng HTTPS'], 0],
            [4, 2, 'CSRF (Cross-Site Request Forgery) tấn công bằng cách nào?',
             ['Giả mạo request hợp lệ từ trình duyệt đã đăng nhập', 'Tiêm script độc vào trang web', 'Đánh cắp cookie session', 'Từ chối dịch vụ (DoS)'], 0],
            [4, 2, 'Firewall hoạt động ở tầng nào của mô hình OSI (phổ biến)?',
             ['Tầng 3–4 (Network/Transport)', 'Tầng 1 (Physical)', 'Tầng 7 (Application) duy nhất', 'Tầng 2 (Data Link)'], 0],

            // ─── Category 5: DSA ─── Level 1 (Dễ) ×5
            [5, 1, 'Độ phức tạp thời gian của thuật toán tìm kiếm nhị phân (Binary Search) là?',
             ['O(log n)', 'O(n)', 'O(n²)', 'O(1)'], 0],
            [5, 1, 'Stack hoạt động theo nguyên tắc nào?',
             ['LIFO – Last In First Out', 'FIFO – First In First Out', 'Random Access', 'Priority-based'], 0],
            [5, 1, 'Queue hoạt động theo nguyên tắc nào?',
             ['FIFO – First In First Out', 'LIFO – Last In First Out', 'Priority-based', 'Random Access'], 0],
            [5, 1, 'Cây nhị phân tìm kiếm (BST) có tính chất gì?',
             ['Node trái < node gốc < node phải', 'Node trái > node gốc', 'Tất cả node có cùng giá trị', 'Không có node con'], 0],
            [5, 1, 'Thuật toán sắp xếp nào có độ phức tạp trung bình tốt nhất O(n log n)?',
             ['Merge Sort', 'Bubble Sort', 'Selection Sort', 'Insertion Sort'], 0],

            // ─── Category 5: DSA ─── Level 2 (TB) ×3
            [5, 2, 'Để tìm đường đi ngắn nhất trong đồ thị có trọng số không âm, dùng thuật toán nào?',
             ["Dijkstra's Algorithm", 'Bellman-Ford', 'DFS', 'Kruskal'], 0],
            [5, 2, 'Hash table (bảng băm) cho phép truy cập phần tử với độ phức tạp trung bình là?',
             ['O(1)', 'O(n)', 'O(log n)', 'O(n²)'], 0],
            [5, 2, 'Linked List khác Array ở điểm gì cơ bản nhất?',
             ['Các phần tử không liên tục trong bộ nhớ, nối bằng con trỏ', 'Có kích thước cố định', 'Truy cập ngẫu nhiên O(1)', 'Không thể thêm/xóa phần tử'], 0],
        ];

        foreach ($questions as [$catId, $lvlId, $content, $options, $correctIdx]) {
            $qId = DB::table('questions')->insertGetId([
                'content'          => $content,
                'type'             => 'single',
                'category_id'      => $catId,
                'level_id'         => $lvlId,
                'times_served'     => 0,
                'times_correct'    => 0,
                'times_incorrect'  => 0,
                'created_at'       => now(),
            ]);

            foreach ($options as $i => $opt) {
                DB::table('question_options')->insert([
                    'question_id' => $qId,
                    'content'     => $opt,
                    'is_correct'  => ($i === $correctIdx) ? 1 : 0,
                ]);
            }
        }

        // ═══════════════════════════════════
        //  8. QUIZZES
        // ═══════════════════════════════════
        // Xóa quiz cũ do seeder này quản lý (nếu chạy lại)
        DB::table('quizzes')->whereIn('name', [
            'Kiểm tra Giữa kỳ: Lập trình Web Nâng cao',
            'Bài Kiểm tra Cơ sở Dữ liệu',
            'Thi Cuối kỳ: Mạng & Bảo mật',
            'Demo – Ôn tập Cấu trúc Dữ liệu',
        ])->delete();

        $quizzes = [
            // Quiz 1 – ĐANG MỞ (active)
            [
                'name'              => 'Kiểm tra Giữa kỳ: Lập trình Web Nâng cao',
                'description'       => 'Bao gồm nội dung Laravel, PHP, JavaScript và Frontend. Kiểm tra kiến thức từ tuần 1–8.',
                'start_date'        => now()->subHours(2),
                'end_date'          => now()->addHours(22),
                'duration_minutes'  => 60,
                'max_attempts'      => 1,
                'pass_percent'      => 50,
                'show_answer'       => false,
                'require_camera'    => false,
                'shuffle_questions' => true,
                'require_login'     => true,
                'is_demo'           => false,
                // category_levels: cat1-lvl1 (6q), cat1-lvl2 (4q), cat2-lvl1 (4q), cat2-lvl2 (2q) = 16 câu
                '_levels' => [
                    ['cat' => 1, 'lvl' => 1, 'count' => 6, 'score_correct' => 0.5, 'score_incorrect' => 0],
                    ['cat' => 1, 'lvl' => 2, 'count' => 4, 'score_correct' => 0.5, 'score_incorrect' => 0],
                    ['cat' => 2, 'lvl' => 1, 'count' => 4, 'score_correct' => 0.5, 'score_incorrect' => 0],
                    ['cat' => 2, 'lvl' => 2, 'count' => 2, 'score_correct' => 0.5, 'score_incorrect' => 0],
                ],
                '_groups' => [$groupA, $groupB],
            ],
            // Quiz 2 – SẮP DIỄN RA (upcoming, 3 ngày nữa)
            [
                'name'              => 'Bài Kiểm tra Cơ sở Dữ liệu',
                'description'       => 'Kiểm tra kiến thức SQL, chuẩn hóa, index và transaction. Mang theo máy tính cá nhân.',
                'start_date'        => now()->addDays(3)->setTime(14, 0),
                'end_date'          => now()->addDays(3)->setTime(16, 0),
                'duration_minutes'  => 45,
                'max_attempts'      => 2,
                'pass_percent'      => 60,
                'show_answer'       => false,
                'require_camera'    => false,
                'shuffle_questions' => true,
                'require_login'     => true,
                'is_demo'           => false,
                '_levels' => [
                    ['cat' => 3, 'lvl' => 1, 'count' => 5, 'score_correct' => 1, 'score_incorrect' => 0],
                    ['cat' => 3, 'lvl' => 2, 'count' => 4, 'score_correct' => 1, 'score_incorrect' => 0],
                ],
                '_groups' => [$groupA],
            ],
            // Quiz 3 – ĐÃ KẾT THÚC (ended)
            [
                'name'              => 'Thi Cuối kỳ: Mạng & Bảo mật',
                'description'       => 'Giao thức mạng, bảo mật ứng dụng, phòng chống tấn công SQL Injection & XSS.',
                'start_date'        => now()->subDays(10)->setTime(8, 0),
                'end_date'          => now()->subDays(10)->setTime(10, 0),
                'duration_minutes'  => 60,
                'max_attempts'      => 1,
                'pass_percent'      => 50,
                'show_answer'       => true,
                'require_camera'    => false,
                'shuffle_questions' => false,
                'require_login'     => true,
                'is_demo'           => false,
                '_levels' => [
                    ['cat' => 4, 'lvl' => 1, 'count' => 5, 'score_correct' => 1, 'score_incorrect' => 0],
                    ['cat' => 4, 'lvl' => 2, 'count' => 3, 'score_correct' => 1, 'score_incorrect' => 0],
                ],
                '_groups' => [$groupA, $groupB],
            ],
            // Quiz 4 – DEMO, KHÔNG CÓ GIỚI HẠN GIỜ, có camera
            [
                'name'              => 'Demo – Ôn tập Cấu trúc Dữ liệu',
                'description'       => 'Bài ôn tập không giới hạn thời gian. Yêu cầu bật camera để mô phỏng thi chính thức.',
                'start_date'        => now()->subHour(),
                'end_date'          => now()->addDays(30),
                'duration_minutes'  => 30,
                'max_attempts'      => 5,
                'pass_percent'      => 40,
                'show_answer'       => true,
                'require_camera'    => true,
                'shuffle_questions' => true,
                'require_login'     => true,
                'is_demo'           => true,
                '_levels' => [
                    ['cat' => 5, 'lvl' => 1, 'count' => 5, 'score_correct' => 1, 'score_incorrect' => 0],
                    ['cat' => 5, 'lvl' => 2, 'count' => 3, 'score_correct' => 1, 'score_incorrect' => 0],
                ],
                '_groups' => [$groupA, $groupB],
            ],
        ];

        foreach ($quizzes as $quizData) {
            $levels = $quizData['_levels'];
            $grps   = $quizData['_groups'];
            unset($quizData['_levels'], $quizData['_groups']);

            $quizData['created_at'] = now();

            $quizId = DB::table('quizzes')->insertGetId($quizData);

            // quiz_category_levels
            foreach ($levels as $cl) {
                DB::table('quiz_category_levels')->insert([
                    'quiz_id'        => $quizId,
                    'category_id'    => $cl['cat'],
                    'level_id'       => $cl['lvl'],
                    'question_count' => $cl['count'],
                    'score_correct'  => $cl['score_correct'],
                    'score_incorrect'=> $cl['score_incorrect'],
                ]);
            }

            // quiz_groups
            foreach ($grps as $gId) {
                DB::table('quiz_groups')->updateOrInsert(
                    ['quiz_id' => $quizId, 'group_id' => $gId],
                    []
                );
            }
        }

        $this->command->info('✅ QuizTestSeeder hoàn tất!');
        $this->command->info('   Tài khoản admin   : admin@stu.edu.vn / admin123');
        $this->command->info('   Tài khoản demo SV : student@stu.edu.vn / student123');
        $this->command->info('   SV khác           : nguyen.van.a@stu.edu.vn ... / student123');
        $this->command->info('   Bài thi đang mở   : Kiểm tra Giữa kỳ Web (Nhóm A + B)');
    }
}
