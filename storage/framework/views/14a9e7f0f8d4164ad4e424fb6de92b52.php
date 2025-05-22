<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Stores</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Our Stores</h1>
        <p class="text-gray-600 mb-8 max-w-3xl">
        Kami berupaya untuk membuat hidup Anda jauh lebih mudah. Toko-toko kami yang terus berkembang tersebar di seluruh Indonesia, tempat Anda dapat memanjakan diri atau menghabiskan waktu berkualitas bersama orang-orang tercinta dalam lingkungan yang mewah dengan suasana yang menyenangkan.
        </p>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filter Sidebar -->
            <aside class="w-full lg:w-1/4">
                <div class="flex flex-col gap-2">
                <button class="text-left bg-pink-200 text-black font-medium px-4 py-2 rounded">Semua</button>
                <button class="text-left border border-gray-300 px-4 py-2 rounded hover:bg-gray-100">Bali</button>
                <button class="text-left border border-gray-300 px-4 py-2 rounded hover:bg-gray-100">Jakarta</button>
                <button class="text-left border border-gray-300 px-4 py-2 rounded hover:bg-gray-100">Surabaya</button>
                </div>
            </aside>

            <!-- Store Cards -->
            <div class="w-full lg:w-3/4 grid sm:grid-cols-2 gap-6">
                <div class="border rounded-lg overflow-hidden shadow-sm bg-white">
                    <img src="<?php echo e($store['image']); ?>" alt="<?php echo e($store['name']); ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1"><?php echo e($store['name']); ?></h3>
                    <p class="text-sm text-gray-700 mb-3"><?php echo e($store['address']); ?></p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-center gap-2">
                        <i class="fas fa-phone text-pink-500"></i> 1500581
                        </li>
                        <li class="flex items-center gap-2">
                        <i class="fas fa-clock text-pink-500"></i> 08:00 - 22:00
                        </li>
                        <li class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-pink-500"></i>
                        <a href="#" class="text-pink-600 hover:underline">View Location &gt;</a>
                        </li>
                    </ul>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_0): ?>
                <p class="text-gray-500 col-span-full">Tidak ada store yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/stores.blade.php ENDPATH**/ ?>