<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Lapangan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $total_lapangan = Lapangan::count();
        
        $booking_hari_ini = Booking::whereDate('tanggal_booking', $today)->count();
        
        $booking_bulan_ini = Booking::whereBetween('tanggal_booking', [$startOfMonth . ' 00:00:00', $endOfMonth . ' 23:59:59'])->count();
        
        $pendapatan_bulan_ini = Booking::whereIn('status', ['confirmed', 'done'])
            ->whereBetween('tanggal_booking', [$startOfMonth . ' 00:00:00', $endOfMonth . ' 23:59:59'])
            ->sum('total_harga');

        $recent_bookings = Booking::with(['user', 'lapangan', 'jadwalSlot'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'total_lapangan',
            'booking_hari_ini',
            'booking_bulan_ini',
            'pendapatan_bulan_ini',
            'recent_bookings'
        ));
    }
}
