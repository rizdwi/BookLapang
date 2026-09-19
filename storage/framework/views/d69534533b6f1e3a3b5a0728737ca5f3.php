<?php $__env->startSection('content'); ?>
<form class="mt-8 space-y-6" action="<?php echo e(route('login')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    
    <div class="rounded-md shadow-sm space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-[#1a1a1a]">Alamat Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="email@contoh.com" value="<?php echo e(old('email')); ?>">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-[#dc2626]"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-[#1a1a1a]">Kata Sandi</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="••••••••">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-[#dc2626]"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-[#0d9488] focus:ring-[#0d9488] border-gray-300 rounded">
            <label for="remember_me" class="ml-2 block text-sm text-[#1a1a1a]">
                Ingat saya
            </label>
        </div>
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
            Masuk
        </button>
    </div>
    
    <div class="text-sm text-center">
        <a href="<?php echo e(route('register')); ?>" class="font-medium text-[#0d9488] hover:text-[#0f766e]">
            Belum punya akun? Daftar di sini
        </a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rizz\Documents\BookLapang\resources\views/auth/login.blade.php ENDPATH**/ ?>