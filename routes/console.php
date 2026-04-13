<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Commands
|--------------------------------------------------------------------------
|
| quiz:expire chạy mỗi phút để phát hiện bài thi đã hết giờ nhưng chưa
| được nộp (client mất mạng, đóng trình duyệt...) và set status='expired'.
|
*/
Schedule::command('quiz:expire')->everyMinute()->withoutOverlapping(5);
