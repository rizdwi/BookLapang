<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
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
?>

<span class="<?php echo e($classes); ?>">
    <?php echo e($label); ?>

</span>
<?php /**PATH C:\Users\Rizz\Documents\BookLapang\resources\views/components/status-badge.blade.php ENDPATH**/ ?>