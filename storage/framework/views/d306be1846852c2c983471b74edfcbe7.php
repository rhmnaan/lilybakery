<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - About Us</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



    <!-- About Section -->
    <section class="text-center py-12 px-6">
        <h1 class="text-4xl font-bold mb-4">About Us</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Dibuat dengan cinta dan inspirasi dari pâtisserie Prancis, Lily Bakery menghadirkan kelezatan elegan dalam setiap gigitan.
            Temukan momen manis tak terlupakan bersama kami.
        </p>
    </section>

    <!-- Image + Description -->
    <section class="max-w-6xl mx-auto px-6 md:px-12 pb-16">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <img src="" alt="Wheat Field" class="rounded-lg shadow-md bg-gray-200 h-64 w-full object-cover">
            <div>
                <p class="mb-4 text-justify">
                    Didirikan pada tahun 2025, Lily Bakery merupakan nama baru yang segar dan inspiratif di dunia pâtisserie bergaya Eropa di Indonesia.
                    Bermula dari toko pertama kami di Jakarta, kami berkomitmen untuk menghadirkan pastry yang elegan dan berkualitas tinggi dengan penuh cinta —
                    menyuguhkan pengalaman manis dan pelayanan hangat kepada setiap pelanggan.
                </p>
                <p class="text-justify">
                    Lily Bakery selalu menghadirkan janji konsisten akan kualitas premium, tampilan yang elegan, dan kemasan yang penuh perhatian —
                    semua dibuat dengan layanan hangat dan penuh kepedulian. Dengan semangat terhadap kreativitas dan inovasi,
                    kami terus mengeksplorasi dan mengembangkan kreasi pastry baru, memadukan seni dan cita rasa dalam setiap produk yang kami tawarkan.
                </p>
            </div>
        </div>

        <div class="mt-12">
            <img src="" alt="Chocolate Cake" class="rounded-lg shadow-md mx-auto w-full md:w-2/3 bg-gray-200 h-80 object-cover">
        </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/about-us.blade.php ENDPATH**/ ?>