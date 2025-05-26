<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lychee Rose - Lily Bakery</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white text-gray-800">

    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Product Detail -->
    <section class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Image -->
            <div class="bg-pink-50 rounded-lg p-4">
                <img src="#" alt="Lychee Rose" class="w-full  rounded-lg object-cover">
            </div>
            <!-- Breadcrumb -->
            <div class="container mx-auto px-4 mt-6 text-sm text-gray-600">
                <span>Menu</span> &gt; <span class="font-semibold">Cake</span>
                <h1 class="text-3xl font-bold mb-2">Lychee Rose</h1>
                <div class="flex items-center text-yellow-400 mb-4">
                    <i class="fas fa-star mr-1"></i>
                    <i class="fas fa-star mr-1"></i>
                    <i class="fas fa-star mr-1"></i>
                    <i class="fas fa-star mr-1"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    rendy ganteng banget enak dan mantap semoga mendapat rezeki lancar cewe cakep yang punya mobil sepuluh
                    guwa juga pengen dapat 10t bang apalah prabowo kocak bgt dan ditanyain najwa jawabnya apa wo wo
                </p>

                <div class="text-sm bg-lily-pink text-white inline-block px-3 py-1 rounded-full mb-4">
                    Stock : 70
                </div>

                <div class="text-2xl font-bold mb-6">Rp 250.000</div>
            </div>
            <!-- Quantity & Order -->
            <div class="bg-gray-50 p-4 rounded-lg border shadow-sm max-w-sm self-start">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center border rounded-md px-3 py-1">
                        <button class="text-xl text-gray-600">-</button>
                        <span class="mx-4">1</span>
                        <button class="text-xl text-gray-600">+</button>
                    </div>
                    <div class="text-xl font-semibold">Rp 250.000</div>
                </div>
                <p class="text-red-500 text-sm mb-3">Pre-order</p>
                <button class="w-full bg-lily-pink hover:bg-lily-pink-dark text-white py-2 rounded-md mb-3 transition duration-300">
                    Add to Cart
                </button>
                <button class="w-full border border-lily-pink-dark text-lily-pink-dark hover:bg-lily-pink-dark hover:text-white py-2 rounded-md transition duration-300">
                    Buy Now
                </button>
            </div>
        </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\lilybakery\resources\views/product-detail.blade.php ENDPATH**/ ?>