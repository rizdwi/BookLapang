<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="<?php echo e(route('lapangan.show', $lapangan->id)); ?>" class="inline-flex items-center text-sm font-semibold text-[#0d9488] hover:text-[#0f766e]">
            &larr; Kembali ke Jadwal Lapangan
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 sm:p-8 bg-[#1e3a5f] text-white">
            <span class="text-xs font-bold uppercase tracking-widest text-teal-300">Langkah Terakhir</span>
            <h1 class="text-2xl sm:text-3xl font-black mt-1">Konfirmasi Reservasi Lapangan</h1>
            <p class="text-sm text-slate-200 mt-1">Pastikan rincian pesanan dan jadwal Anda sudah sesuai.</p>
        </div>

        <form action="<?php echo e(route('booking.store')); ?>" method="POST" class="p-6 sm:p-8">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="jadwal_slot_id" value="<?php echo e($slot->id); ?>">
            <input type="hidden" name="lapangan_id" value="<?php echo e($lapangan->id); ?>">

            
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">Detail Jadwal Terpilih</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-gray-500 block">Nama Lapangan</span>
                        <span class="font-bold text-[#1e3a5f] text-base"><?php echo e($lapangan->nama); ?></span>
                        <span class="text-xs text-gray-500 block mt-0.5"><?php echo e(ucfirst($lapangan->tipe)); ?> &bull; <?php echo e($lapangan->alamat); ?></span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block">Waktu Sewa</span>
                        <span class="font-bold text-gray-900 text-base">
                            <?php echo e(\Carbon\Carbon::parse($slot->tanggal)->translatedFormat('l, d F Y')); ?>

                        </span>
                        <span class="text-xs font-semibold text-teal-700 block mt-0.5">
                            Pukul <?php echo e(substr($slot->jam_mulai, 0, 5)); ?> - <?php echo e(substr($slot->jam_selesai, 0, 5)); ?> WIB (1 Jam)
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Total Tarif</span>
                    <span class="text-2xl font-black text-[#1e3a5f]">
                        Rp <?php echo e(number_format($lapangan->harga_per_jam, 0, ',', '.')); ?>

                    </span>
                </div>
            </div>

            
            <div class="mb-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">Data Pemesan</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-xs text-gray-500 block">Nama Lengkap</span>
                        <span class="font-semibold text-gray-900"><?php echo e(auth()->user()->name); ?></span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block">Nomor HP / WhatsApp</span>
                        <span class="font-semibold text-gray-900"><?php echo e(auth()->user()->phone ?? 'Belum tertera'); ?></span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-xs text-gray-500 block">Alamat Email</span>
                        <span class="font-semibold text-gray-900"><?php echo e(auth()->user()->email); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="mb-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">
                    Metode Pembayaran
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="border rounded-lg p-3 flex flex-col cursor-pointer hover:border-teal-500 transition-colors has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-bold text-gray-900">QRIS</span>
                            <input type="radio" name="metode_pembayaran" value="qris" checked class="text-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                        <span class="text-xs text-gray-500">Scan via GoPay, OVO, Dana, BCA Mobile</span>
                    </label>

                    <label class="border rounded-lg p-3 flex flex-col cursor-pointer hover:border-teal-500 transition-colors has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-bold text-gray-900">Transfer BCA</span>
                            <input type="radio" name="metode_pembayaran" value="transfer_bca" class="text-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                        <span class="text-xs text-gray-500">Transfer Virtual Account / Manual Rekening</span>
                    </label>

                    <label class="border rounded-lg p-3 flex flex-col cursor-pointer hover:border-teal-500 transition-colors has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-bold text-gray-900">Bayar di Tempat</span>
                            <input type="radio" name="metode_pembayaran" value="cash" class="text-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                        <span class="text-xs text-gray-500">Tunai sebelum bermain di kasir lapangan</span>
                    </label>
                </div>
                <?php $__errorArgs = ['metode_pembayaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="mb-8">
                <label for="catatan" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                    Catatan Tambahan (Opsional)
                </label>
                <textarea id="catatan" 
                          name="catatan" 
                          rows="3" 
                          class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]"
                          placeholder="Contoh: Pinjam 2 bola futsal, atau sewa rompi tim..."></textarea>
                <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="<?php echo e(route('lapangan.show', $lapangan->id)); ?>" 
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                    Konfirmasi & Buat Pesanan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rizz\Documents\BookLapang\resources\views/booking/create.blade.php ENDPATH**/ ?>