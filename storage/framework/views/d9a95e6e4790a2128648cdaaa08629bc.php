<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Promotion</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



    <section class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-8">PROMOTION</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        
        <?php for($i = 0; $i < 12; $i++): ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="relative">
            <img src="/images/promo-placeholder.jpg" alt="Product Image" class="w-full h-48 object-cover">
            <span class="absolute top-2 left-2 bg-pink-600 text-white text-xs px-2 py-1 rounded">Up to 11% off</span>
        </div>
        <div class="p-4">
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Eid Raspberry Honey Cake</h3>
            <p class="text-gray-600 text-sm">
            From <span class="font-bold text-gray-800">Rp 825.000</span>
            <span class="line-through text-gray-400 text-xs ml-1">Rp 925.000</span>
            </p>
            <div class="flex items-center mt-2 mb-4 text-yellow-500 text-sm">
            ★★★★☆
            </div>
            <button class="w-full bg-gray-100 text-gray-700 py-1 rounded hover:bg-gray-200">Add to cart</button>
        </div>
        </div>
        <?php endfor; ?>

    </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/promotion.blade.php ENDPATH**/ ?>