<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Stores</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">

<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="max-w-7xl mx-auto lg:ml-16 lg:mr-auto px-4 pt-40 pb-20">
    <h1 class="text-4xl font-bold mb-4 text-center lg:text-left">Our Stores</h1>
    <p class="font-inter font-semibold mb-7 text-gray-700 max-w-4xl text-center lg:text-justify mx-auto lg:mx-0">
        Kami berupaya untuk membuat hidup Anda jauh lebih mudah. Toko-toko kami yang terus berkembang tersebar di seluruh Indonesia, tempat Anda dapat memanjakan diri atau menghabiskan waktu berkualitas bersama orang-orang tercinta dalam lingkungan yang mewah dengan suasana yang menyenangkan.
    </p>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-1/5 mx-auto lg:mx-0">
            <div class="border rounded-lg overflow-hidden font-inter font-semibold" id="cityFilter">
                <button data-city="all" class="w-full py-2 px-4 text-left bg-[#D6A1A1] text-black border-b city-btn active">Semua</button>
                <button data-city="BALI" class="w-full py-2 px-4 text-left hover:bg-gray-50 border-b city-btn">Bali</button>
                <button data-city="JAKARTA" class="w-full py-2 px-4 text-left hover:bg-gray-50 border-b city-btn">Jakarta</button>
                <button data-city="SURABAYA" class="w-full py-2 px-4 text-left hover:bg-gray-50 city-btn">Surabaya</button>
                </div>
        </div>  

        <div class="w-full lg:w-4/5 grid grid-cols-1 md:grid-cols-2 gap-6" id="storeContainer">
            <?php if(isset($stores) && $stores->count() > 0): ?>
                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded-lg overflow-hidden shadow-sm store-card" data-city="<?php echo e(strtoupper(trim($store->nama_toko))); ?>"> 
                    
                    <div class="px-3 pt-3">
                        
                        <img src="<?php echo e(asset('images/store/store.png')); ?>" alt="Lily Bakery <?php echo e($store->nama_toko); ?>" class="w-full h-64 object-cover rounded-md">
                    </div>
                    <div class="p-4 space-y-2">
                        <h2 class="text-lg font-semibold">LILY BAKERY <?php echo e(strtoupper($store->nama_toko)); ?></h2>
                        <p class="text-sm text-gray-600"><?php echo e($store->alamat); ?></p>
                        <div class="flex items-center text-sm text-gray-700 gap-2 mt-2">
                            <i class="fas fa-phone-alt"></i> <span><?php echo e($store->telp); ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700 gap-2">
                            <i class="fas fa-clock"></i> <span>08:00 - 22:00</span> 
                        </div>
                        <div class="flex items-center text-sm text-gray-700 gap-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php if($store->link_location): ?>
                                <a href="<?php echo e($store->link_location); ?>" target="_blank" class="hover:underline">View Location ></a>
                            <?php else: ?>
                                <span>Location Not Available</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p class="col-span-full text-center text-gray-500">No stores found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const buttons = document.querySelectorAll('.city-btn');
        const cards = document.querySelectorAll('.store-card');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const selectedCity = button.dataset.city;

                buttons.forEach(btn => {
                    btn.classList.remove('bg-[#D6A1A1]', 'text-black', 'active');
                    // Add back default hover effect for non-active buttons
                    if (!btn.classList.contains('active')) {
                        btn.classList.add('hover:bg-gray-50');
                    }
                });

                button.classList.add('bg-[#D6A1A1]', 'text-black', 'active');
                button.classList.remove('hover:bg-gray-50'); // Remove hover for active button

                cards.forEach(card => {
                    const cardCity = card.dataset.city.toUpperCase(); // Ensure comparison is case-insensitive
                    if (selectedCity === 'all' || cardCity === selectedCity.toUpperCase()) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

</body>
</html>