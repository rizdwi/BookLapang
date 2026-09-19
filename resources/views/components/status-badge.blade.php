@props(['status'])

@php
    $classes = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full ';
    
    switch($status) {
        case 'pending':
            $classes .= 'bg-yellow-100 text-yellow-800';
            $label = 'Menunggu';
            break;
        case 'confirmed':
            $classes .= 'bg-blue-100 text-blue-800';
            $label = 'Dikonfirmasi';
            break;
        case 'done':
            $classes .= 'bg-green-100 text-green-800';
            $label = 'Selesai';
            break;
        case 'cancelled':
            $classes .= 'bg-red-100 text-red-800';
            $label = 'Dibatalkan';
            break;
        default:
            $classes .= 'bg-gray-100 text-gray-800';
            $label = ucfirst($status);
    }
@endphp

<span class="{{ $classes }}">
    {{ $label }}
</span>
