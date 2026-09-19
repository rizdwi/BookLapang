<?php

// 1. Inisialisasi direktori penulisan di /tmp untuk lingkungan Vercel Serverless (Read-Only Root)
$tmpStorage = '/tmp/storage';
$dirs = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
    $tmpStorage . '/app/public',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Salin SQLite database dengan 5 lapangan & 490 slot ke /tmp agar bisa dibaca & ditulis di Vercel
$sqliteSource = __DIR__ . '/../database/database.sqlite';
$sqliteTarget = '/tmp/database.sqlite';

if (file_exists($sqliteSource) && (!file_exists($sqliteTarget) || filesize($sqliteTarget) === 0)) {
    copy($sqliteSource, $sqliteTarget);
}

// 3. Konfigurasi path runtime ke direktori /tmp
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=' . $sqliteTarget);

// 4. Delegasikan request ke Laravel Front Controller
require __DIR__ . '/../public/index.php';
