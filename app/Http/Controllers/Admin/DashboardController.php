<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Lapangan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'done'])->sum('total_harga');
        $lapanganCount = Lapangan::count();
        
        $recentBookings = Booking::with(['user', 'lapangan'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalBookings', 'totalRevenue', 'lapanganCount', 'recentBookings'));
    }
}
