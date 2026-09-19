<?php $__env->startSection('content'); ?>
<div class="mb-10 text-center">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-[#0d9488] text-xs font-semibold uppercase tracking-wider mb-3">
        Reservasi Lapangan Olahraga Mudah & Instan
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1e3a5f] tracking-tight mb-3">
        Temukan & Booking Lapangan Olahraga Favoritmu
    </h1>
    <p class="text-base text-[#64748b] max-w-2xl mx-auto">
        Pilih jadwal yang tersedia secara real-time, dapatkan konfirmasi instan dengan proteksi sistem bebas jadwal bentrok.
    </p>
</div>


<div class="mb-8 flex flex-wrap justify-center gap-2">
    <?php
        $categories = [
            'semua' => 'Semua Lapangan',
            'futsal' => 'Futsal',
            'badminton' => 'Badminton',
            'basket' => 'Basket',
            'tenis' => 'Tenis',
            'voli' => 'Bola Voli',
        ];
        $currentType = request('tipe', 'semua');
    ?>

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e($key === 'semua' ? route('home') : route('home', ['tipe' => $key])); ?>"
           class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-150 <?php echo e($currentType === $key ? 'bg-[#1e3a5f] text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-200 hover:border-gray-400 hover:bg-gray-50'); ?>">
            <?php echo e($label); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="mb-12">
    <?php if(isset($lapangan) && count($lapangan) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $lapangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                    
                    <div class="relative h-48 w-full bg-gray-100 overflow-hidden">
                        <?php if($lap->foto): ?>
                            <img src="<?php echo e(asset('storage/' . $lap->foto)); ?>" alt="<?php echo e($lap->nama); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                Tidak ada foto
                            </div>
                        <?php endif; ?>
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-[#1e3a5f]/90 text-white backdrop-blur-sm">
                            <?php echo e(ucfirst($lap->tipe)); ?>

                        </span>
                    </div>

                    
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="mb-2">
                            <h3 class="text-xl font-bold text-[#1e3a5f] leading-snug"><?php echo e($lap->nama); ?></h3>
                            <p class="text-xs text-[#64748b] flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="truncate"><?php echo e($lap->alamat ?? 'Lokasi Terdaftar'); ?></span>
                            </p>
                        </div>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                            <?php echo e($lap->deskripsi); ?>

                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-[#64748b] block">Tarif Sewa</span>
                                <span class="text-lg font-extrabold text-[#1e3a5f]">
                                    Rp <?php echo e(number_format($lap->harga_per_jam, 0, ',', '.')); ?>

                                    <span class="text-xs font-normal text-[#64748b]">/jam</span>
                                </span>
                            </div>
                            <a href="<?php echo e(route('lapangan.show', $lap->id)); ?>" 
                               class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488] shadow-sm transition-colors">
                                Cek Jadwal &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="text-base font-bold text-gray-900">Tidak ada lapangan pada kategori ini</h3>
            <p class="mt-1 text-sm text-gray-500">Silakan pilih kategori olahraga lainnya atau kembali ke semua lapangan.</p>
            <div class="mt-4">
                <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#1e3a5f] rounded-lg hover:bg-opacity-90">
                    Lihat Semua Lapangan
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rizz\Documents\BookLapang\resources\views/public/index.blade.php ENDPATH**/ ?>