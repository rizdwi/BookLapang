<?php

// 1. Inisialisasi folder /tmp untuk Vercel Serverless
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
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Salin SQLite database dengan data lapangan ke /tmp
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = $tmp . '/database.sqlite';

if (file_exists($sourceDb) && (!file_exists($targetDb) || filesize($targetDb) === 0)) {
    copy($sourceDb, $targetDb);
}

// 3. Konfigurasi runtime environment overrides untuk Vercel
putenv('VERCEL=1');
putenv('VIEW_COMPILED_PATH=' . $storage . '/framework/views');
putenv('APP_CONFIG_CACHE=' . $tmp . '/bootstrap/cache/config.php');
putenv('APP_EVENTS_CACHE=' . $tmp . '/bootstrap/cache/events.php');
putenv('APP_PACKAGES_CACHE=' . $tmp . '/bootstrap/cache/packages.php');
putenv('APP_ROUTES_CACHE=' . $tmp . '/bootstrap/cache/routes.php');
putenv('APP_SERVICES_CACHE=' . $tmp . '/bootstrap/cache/services.php');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=' . $targetDb);
putenv('APP_NAME=BookLapang');
putenv('APP_URL=https://book-lapang.vercel.app');
putenv('SESSION_DRIVER=cookie');
putenv('SESSION_LIFETIME=120');
putenv('CACHE_STORE=array');

$_ENV['APP_NAME'] = 'BookLapang';
$_ENV['APP_URL'] = 'https://book-lapang.vercel.app';
$_ENV['VERCEL'] = '1';
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $targetDb;
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['SESSION_LIFETIME'] = '120';
$_ENV['CACHE_STORE'] = 'array';

$_SERVER['VERCEL'] = '1';
$_SERVER['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_DATABASE'] = $targetDb;
$_SERVER['SESSION_DRIVER'] = 'cookie';
$_SERVER['SESSION_LIFETIME'] = '120';
$_SERVER['CACHE_STORE'] = 'array';

if (empty($_ENV['APP_KEY']) && empty(getenv('APP_KEY'))) {
    $fallbackKey = 'base64:PF0TuxyMcBeuawZO8dLqA4agIUJQTDmb6xiRPVVAomY=';
    putenv('APP_KEY=' . $fallbackKey);
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

// 4. Delegasikan eksekusi request ke Front Controller Laravel
require __DIR__ . '/../public/index.php';
