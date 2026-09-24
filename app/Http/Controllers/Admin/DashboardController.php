<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $total_lapangan = Lapangan::count();
        
        $booking_hari_ini = Booking::whereDate('tanggal_booking', $today)->count();
        
        $booking_bulan_ini = Booking::whereBetween('tanggal_booking', [$startOfMonth, $endOfMonth])->count();
        
        $pendapatan_bulan_ini = Booking::whereIn('status', ['confirmed', 'done'])
            ->whereBetween('tanggal_booking', [$startOfMonth, $endOfMonth])
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

    /**
     * Tampilan Visual Timetable Grid / Kalender Kasir Harian
     */
    public function timetable(Request $request)
    {
        $selectedDate = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $tipeFilter = $request->get('tipe');

        $lapanganQuery = Lapangan::aktif()->with(['jadwalSlots' => function ($q) use ($selectedDate) {
            $q->whereDate('tanggal', $selectedDate)->orderBy('jam_mulai');
        }]);

        if (!empty($tipeFilter)) {
            $lapanganQuery->where('tipe', $tipeFilter);
        }

        $lapanganList = $lapanganQuery->get();

        // Ambil semua booking pada tanggal tersebut untuk pencocokan status slot
        $bookings = Booking::with(['user', 'bookingSlots'])
            ->whereDate('tanggal_booking', $selectedDate)
            ->whereIn('status', ['pending', 'confirmed', 'done'])
            ->get();

        // Buat map booking per jadwal_slot_id
        $slotBookingMap = [];
        foreach ($bookings as $b) {
            if ($b->jadwal_slot_id) {
                $slotBookingMap[$b->jadwal_slot_id] = $b;
            }
            foreach ($b->bookingSlots as $bSlot) {
                $slotBookingMap[$bSlot->jadwal_slot_id] = $b;
            }
        }

        // Daftar jam operasional standar (07:00 s/d 23:00)
        $operationalHours = [];
        for ($h = 7; $h <= 23; $h++) {
            $operationalHours[] = sprintf('%02d:00', $h);
        }

        return view('admin.timetable', compact(
            'lapanganList',
            'selectedDate',
            'tipeFilter',
            'slotBookingMap',
            'operationalHours'
        ));
    }
}
