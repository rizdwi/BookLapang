@props(['status'])

@php
    $base = 'px-2.5 py-0.5 inline-flex items-center text-xs font-bold rounded-full border ';
    
    switch($status) {
        case 'pending':
            $classes = $base . 'bg-amber-50 text-amber-800 border-amber-200';
            $label = 'Menunggu';
            break;
        case 'confirmed':
            $classes = $base . 'bg-teal-50 text-teal-800 border-teal-200';
            $label = 'Dikonfirmasi';
            break;
        case 'done':
            $classes = $base . 'bg-emerald-50 text-emerald-800 border-emerald-200';
            $label = 'Selesai';
            break;
        case 'cancelled':
            $classes = $base . 'bg-rose-50 text-rose-800 border-rose-200';
            $label = 'Dibatalkan';
            break;
        default:
            $classes = $base . 'bg-gray-100 text-gray-800 border-gray-200';
            $label = ucfirst($status);
    }
@endphp

<span class="{{ $classes }}">
    {{ $label }}
</span>
