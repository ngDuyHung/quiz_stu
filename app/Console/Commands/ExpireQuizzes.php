<?php

namespace App\Console\Commands;

use App\Models\QuizResult;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireQuizzes extends Command
{
    protected $signature   = 'quiz:expire {--dry-run : Xem danh sách sẽ bị expire mà không thay đổi DB}';
    protected $description = 'Đổi quiz_results status="open" đã quá giờ làm bài sang status="expired" và tính điểm.';

    public function handle(): int
    {
        // Lấy tất cả bài đang open quá duration
        // Dùng JOIN để tránh N+1 khi kiểm tra duration_minutes
        $expiredResults = QuizResult::query()
            ->where('status', 'open')
            ->join('quizzes', 'quizzes.id', '=', 'quiz_results.quiz_id')
            ->whereRaw('TIMESTAMPDIFF(SECOND, quiz_results.started_at, NOW()) > quizzes.duration_minutes * 60 + 60')
            ->select('quiz_results.*')
            ->with('quiz')
            ->get();

        if ($expiredResults->isEmpty()) {
            $this->info('[quiz:expire] Không có bài nào cần expire.');
            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->table(
                ['result_id', 'quiz', 'user_id', 'started_at', 'duration_minutes'],
                $expiredResults->map(fn ($r) => [
                    $r->id,
                    $r->quiz->name,
                    $r->user_id,
                    $r->started_at,
                    $r->quiz->duration_minutes,
                ])
            );
            $this->warn('Dry-run: không có thay đổi nào được thực hiện.');
            return self::SUCCESS;
        }

        $count = 0;
        foreach ($expiredResults as $result) {
            try {
                // Tính điểm với những gì đã trả lời, đóng bài với status='expired'
                app(\App\Http\Controllers\Client\StudentQuizController::class)
                    ->expireResult($result);
                $count++;
            } catch (\Throwable $e) {
                $this->error("Lỗi result #{$result->id}: " . $e->getMessage());
            }
        }

        $this->info("[quiz:expire] Đã expire {$count} bài thi.");
        return self::SUCCESS;
    }
}
