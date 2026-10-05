<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-expire pesanan pending setiap menit (TTL 15 menit)
Schedule::command('booking:expire-pending')->everyMinute();

// Self-healing jadwal: pastikan 30 hari ke depan selalu tersedia (hapus yang kadaluarsa + generate yang kosong)
Schedule::command('jadwal:generate-upcoming --days=30')->dailyAt('00:05');
Schedule::command('jadwal:generate-upcoming --days=30')->hourly(); // safety net jika daily terlewat (command skip hari yang sudah ada, jadi murah)
