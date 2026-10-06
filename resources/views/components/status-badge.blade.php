@props(['status'])

@php
    $base = 'px-2.5 py-1 inline-flex items-center gap-1.5 text-xs font-bold rounded-full border shadow-xs tracking-wide ';
    
    switch($status) {
        case 'pending':
            $classes = $base . 'bg-amber-50 text-amber-900 border-amber-300';
            $dotColor = 'bg-amber-500';
            $label = 'Menunggu Pembayaran';
            break;
        case 'confirmed':
            $classes = $base . 'bg-emerald-50 text-emerald-900 border-emerald-300';
            $dotColor = 'bg-emerald-500';
            $label = 'Terkonfirmasi';
            break;
        case 'done':
            $classes = $base . 'bg-blue-50 text-blue-900 border-blue-300';
            $dotColor = 'bg-blue-500';
            $label = 'Selesai (Check-in)';
            break;
        case 'cancelled':
            $classes = $base . 'bg-rose-50 text-rose-900 border-rose-300';
            $dotColor = 'bg-rose-500';
            $label = 'Dibatalkan';
            break;
        default:
            $classes = $base . 'bg-slate-100 text-slate-900 border-slate-300';
            $dotColor = 'bg-slate-500';
            $label = ucfirst($status);
    }
@endphp

<span class="{{ $classes }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    <span>{{ $label }}</span>
</span>
