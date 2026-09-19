<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Halaman Publik dengan Rate Limiter (60 request/menit untuk mencegah DoS/Scraping)
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('home');
    Route::get('/lapangan/{id}', [PublicController::class, 'show'])->name('lapangan.show');
});

// Jalur Pelanggan (Customer)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BookingController::class, 'customerHistory'])->name('customer.dashboard');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    
    // Rate limiter khusus proteksi brute-force & race condition booking (10 transaksi/menit)
    Route::post('/booking/store', [BookingController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('booking.store');
        
    Route::get('/booking/history', function () {
        return redirect()->route('customer.dashboard');
    })->name('booking.history');
    
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// Jalur Pengelola (Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Lapangan
    Route::resource('lapangan', LapanganController::class);
    
    // Kelola Jadwal Slot
    Route::get('/jadwal', [JadwalController::class, 'all'])->name('jadwal.index');
    Route::post('/jadwal/generate-bulk', [JadwalController::class, 'generateBulk'])->name('jadwal.generate-bulk');
    Route::get('/lapangan/{lapangan}/jadwal', [JadwalController::class, 'index'])->name('lapangan.jadwal.index');
    Route::post('/lapangan/{lapangan}/jadwal/generate', [JadwalController::class, 'generate'])->name('lapangan.jadwal.generate');
    Route::patch('/jadwal/{slot}/toggle', [JadwalController::class, 'toggle'])->name('jadwal.toggle');
    Route::delete('/jadwal/{slot}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // Kelola Pemesanan (Booking)
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::patch('/booking/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('booking.update-status');
    Route::patch('/booking/{booking}', [AdminBookingController::class, 'updateStatus'])->name('booking.update');
});

require __DIR__.'/auth.php';
