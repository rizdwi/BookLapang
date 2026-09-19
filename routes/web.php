<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/lapangan/{id}', [PublicController::class, 'show'])->name('lapangan.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Booking untuk customer
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/history', [BookingController::class, 'customerHistory'])->name('booking.history');
    Route::get('/dashboard', [BookingController::class, 'customerHistory'])->name('customer.dashboard');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Lapangan
    Route::resource('lapangan', LapanganController::class);
    
    // Kelola Jadwal Slot Lapangan
    Route::get('lapangan/{lapangan}/jadwal', [JadwalController::class, 'index'])->name('lapangan.jadwal.index');
    Route::post('lapangan/{lapangan}/jadwal/generate', [JadwalController::class, 'generate'])->name('lapangan.jadwal.generate');
    Route::patch('jadwal/{slot}/toggle', [JadwalController::class, 'toggle'])->name('jadwal.toggle');
    Route::delete('jadwal/{slot}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // Kelola Booking
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::patch('/booking/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('booking.update-status');
});

require __DIR__.'/auth.php';
