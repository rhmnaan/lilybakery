<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Fresh & Homemade Cakes</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



    <!-- Hero Section -->
    <section class="bg-lily-pink py-16 hero-pattern relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h3 class="text-xl font-medium mb-2">Rasa Autentik, Kualitas Premium</h3>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Manisnya <span class="text-lily-pink-dark">Setiap Gigitan</span></h1>
                    <p class="text-gray-700 mb-6">
                        Nikmati kue lezat dengan cita rasa istimewa. Fresh, homemade, dan selalu siap menemani momen spesialmu!
                    </p>
                </div>
                <div class="md:w-1/2 relative">
                    <img src="/images/hero-cake.png" alt="Chocolate cake" class="mx-auto max-w-full">
                    <div class="absolute bottom-10 right-0 bg-white rounded-lg p-3 shadow-md w-48">
                        <p class="text-xs">Welcome to Lily Bakery! How can we help you? Tap here to chat with us!</p>
                        <div class="absolute -right-3 -bottom-3 bg-green-600 rounded-full p-2">
                            <i class="fab fa-whatsapp text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <p class="text-sm text-gray-600 mb-2">Social media</p>
                <div class="flex space-x-3">
                    <a href="#" class="text-gray-600 hover:text-lily-pink-dark"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-600 hover:text-lily-pink-dark"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-gray-600 hover:text-lily-pink-dark"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-600 hover:text-lily-pink-dark"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommended Cakes Section -->
    <section class="py-16 bg-gray-100 relative">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-2 text-gray-800">Recommended Cakes</h2>
            <p class="text-gray-600 mb-8">
                Discover our Signature Cakes that make us legendary! <br>
                Perfect for birthdays, special occasions or simply indulging in a sweet moment just for you.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Cake 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="/images/cake-lychee.jpg" alt="Lychee Rose Cake" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">Lychee Rose</h3>
                        <p class="text-lily-pink-dark font-medium mb-2">From Rp 250.000</p>
                        <div class="flex mb-3">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <button class="w-full bg-lily-pink hover:bg-lily-pink-dark text-white py-2 rounded-md transition duration-300">
                            Add to cart
                        </button>
                    </div>
                </div>
                
                <!-- Cake 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="/images/cake-caramel.jpg" alt="Popcorn Caramello Cake" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">Popcorn Caramello</h3>
                        <p class="text-lily-pink-dark font-medium mb-2">From Rp 250.000</p>
                        <div class="flex mb-3">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <button class="w-full bg-lily-pink hover:bg-lily-pink-dark text-white py-2 rounded-md transition duration-300">
                            Add to cart
                        </button>
                    </div>
                </div>
                
                <!-- Cake 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="/images/cake-garden.jpg" alt="Cosette's Garden Cake" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">Cosette's Garden</h3>
                        <p class="text-lily-pink-dark font-medium mb-2">From Rp 300.000</p>
                        <div class="flex mb-3">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <button class="w-full bg-lily-pink hover:bg-lily-pink-dark text-white py-2 rounded-md transition duration-300">
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <button class="bg-white text-lily-pink-dark border border-lily-pink-dark px-6 py-2 rounded-full hover:bg-lily-pink hover:text-white transition duration-300">
                    View All Cakes
                </button>
            </div>
        </div>
        
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-0 w-32 h-32 bg-lily-pink rounded-br-full opacity-50"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-lily-pink rounded-tl-full opacity-50"></div>
    </section>

    <!-- Custom Cake Section -->
    <section class="py-16 bg-gray-200">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-2">CUSTOM CAKE</h2>
            <p class="text-gray-600 mb-8">
                Ingin menikmati kue idaman tanpa batas? Anda sendiri! Jangan khawatir!
            </p>
            <button class="bg-gray-700 text-white px-6 py-2 rounded-md hover:bg-gray-800 transition duration-300 mb-12">
                Lihat Selengkapnya
            </button>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Custom Option 1 -->
                <div>
                    <div class="bg-blue-100 rounded-lg h-48 mb-4 overflow-hidden">
                        <img src="/images/fondant-cake.png" alt="Kue Fondant" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold mb-2">Kue Fondant</h3>
                    <p class="text-gray-600">
                        Kue fondant menawarkan kebebasan berkreasi tanpa batas, dengan detail tinggi, mulai dari karakter kartun lucu hingga tampilan elegan yang kompleks. Cocok untuk tampilan elegan dan artistik.
                    </p>
                </div>
                
                <!-- Custom Option 2 -->
                <div>
                    <div class="bg-pink-100 rounded-lg h-48 mb-4 overflow-hidden">
                        <img src="/images/buttercream-cake.png" alt="Kue Buttercream" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold mb-2">Kue Buttercream</h3>
                    <p class="text-gray-600">
                        Menyajikan kelembutan klasik buttercream dengan sentuhan modern yang akan memuaskan imajinasiÂ! Cocok bagi Anda yang menginginkan tampilan kue yang lebih alami, lembut, namun tetap estetik.
                    </p>
                </div>
                
                <!-- Custom Option 3 -->
                <div>
                    <div class="bg-yellow-100 rounded-lg h-48 mb-4 overflow-hidden">
                        <img src="/images/custom-text.png" alt="Kustom Tulisan" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold mb-2">Kustom Tulisan</h3>
                    <p class="text-gray-600">
                        Tambahkan sentuhan personal pada kue dengan tulisan tangan indah. Bisa berupa nama, ucapan selamat, atau kutipan favorit Anda dengan gaya huruf dan warna teks bervariasiÂ. Membuat kue yang terasa lebih bermakna dan berkesan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/index.blade.php ENDPATH**/ ?>