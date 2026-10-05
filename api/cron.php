<?php
// Vercel Cron endpoint: /api/cron
// Dijadwalkan via vercel.json -> akan dipanggil otomatis oleh Vercel.
// Juga bisa dipanggil manual untuk self-healing jadwal & expire pending.

$tmp = '/tmp';
$storage = $tmp . '/storage';
$dirs = [
    $storage . '/framework/views',
    $storage . '/framework/cache/data',
    $storage . '/framework/sessions',
    $storage . '/logs',
    $storage . '/app/public',
    $tmp . '/bootstrap/cache',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0777, true);
}

$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = $tmp . '/database.sqlite';
if (file_exists($sourceDb) && (!file_exists($targetDb) || filesize($targetDb) === 0 || filemtime($sourceDb) > filemtime($targetDb))) {
    @copy($sourceDb, $targetDb);
}

putenv('VERCEL=1');
putenv('VIEW_COMPILED_PATH=' . $storage . '/framework/views');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=' . $targetDb);
putenv('APP_NAME=BookLapang');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $targetDb;
$_SERVER['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_DATABASE'] = $targetDb;

if (empty($_ENV['APP_KEY']) && empty(getenv('APP_KEY'))) {
    $fallbackKey = 'base64:PF0TuxyMcBeuawZO8dLqA4agIUJQTDmb6xiRPVVAomY=';
    putenv('APP_KEY=' . $fallbackKey);
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

header('Content-Type: application/json');

$out = [];
$exit1 = Artisan::call('jadwal:generate-upcoming', ['--days' => 30]);
$out['jadwal:generate-upcoming'] = ['exit' => $exit1, 'output' => Artisan::output()];
$exit2 = Artisan::call('booking:expire-pending');
$out['booking:expire-pending'] = ['exit' => $exit2, 'output' => Artisan::output()];

// Inline expire safety: jika scheduler belum sempat, release manual via SQL (idempotent)
try {
    $pdo = new PDO('sqlite:' . $targetDb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("UPDATE jadwal_slots SET tersedia = 1 WHERE id IN (SELECT jadwal_slot_id FROM bookings WHERE status = 'pending' AND expires_at IS NOT NULL AND datetime(expires_at) < datetime('now'))");
    $stmt->execute();
    $pdo->exec("UPDATE bookings SET status = 'cancelled' WHERE status = 'pending' AND expires_at IS NOT NULL AND datetime(expires_at) < datetime('now')");
} catch (Throwable $e) {
    $out['inline_expire_error'] = $e->getMessage();
}

echo json_encode(['ok' => true, 'time' => now()->toDateTimeString(), 'results' => $out], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
