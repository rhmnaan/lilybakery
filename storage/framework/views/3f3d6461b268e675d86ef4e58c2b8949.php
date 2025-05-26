<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Custom Cakes</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Hero Banner -->
    <section class="bg-lily-pink py-12 relative overflow-hidden">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">CUSTOM CAKES COLLECTION</h1>
            <p class="text-gray-700 max-w-2xl mx-auto mb-6">            
    Temukan koleksi kue rancangan khusus kami yang menakjubkan untuk setiap acara spesial.
    Dari ulang tahun hingga pernikahan, kami menciptakan seni makanan yang indah hanya untuk Anda!
            </p>
        </div>
        <!-- Decorative elements -->
        <div class="absolute -bottom-10 left-10 w-32 h-32 bg-white rounded-full opacity-20"></div>
        <div class="absolute top-5 right-10 w-24 h-24 bg-white rounded-full opacity-20"></div>
    </section>

    <!-- Custom Cakes Gallery -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Cake 1 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/candy-superhero-cake.jpg" alt="Candy Superhero Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Candy & Superhero Cake</h3>
                        <p class="text-gray-600 mb-4">Perfect themed cake for children's birthdays with colorful candy and superhero decorations.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 450.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 2 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/ocean-theme-cake.jpg" alt="Ocean Theme Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Ocean Adventure Cake</h3>
                        <p class="text-gray-600 mb-4">Dive into fun with this ocean-themed cake featuring underwater characters and decorations.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 500.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 3 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/character-cake.jpg" alt="Character Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Character Collection Cake</h3>
                        <p class="text-gray-600 mb-4">Featuring your favorite cartoon or movie characters beautifully crafted with fondant details.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 550.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 4 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/hot-wheels-cake.jpg" alt="Hot Wheels Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Racing Car Cake</h3>
                        <p class="text-gray-600 mb-4">Racing-themed cake with Hot Wheels design, perfect for car enthusiasts and little racers.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 450.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 5 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/elegant-ruffle-cake.jpg" alt="Elegant Ruffle Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Elegant Ruffle Cake</h3>
                        <p class="text-gray-600 mb-4">Sophisticated cake with beautiful buttercream ruffles, perfect for elegant celebrations.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 480.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 6 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/dinosaur-cake.jpg" alt="Dinosaur Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Dinosaur Adventure Cake</h3>
                        <p class="text-gray-600 mb-4">Prehistoric fun with this vibrant dinosaur-themed cake for your little explorer.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 470.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 7 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/quilted-cake.jpg" alt="Quilted Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Elegant Quilted Cake</h3>
                        <p class="text-gray-600 mb-4">Sophisticated quilted design with delicate flower accents for an elegant celebration.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 520.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 8 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/black-gold-cake.jpg" alt="Black and Gold Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Luxurious Black & Gold</h3>
                        <p class="text-gray-600 mb-4">Modern and sophisticated design with gold leaf accents for an upscale celebration.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 550.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 9 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/unicorn-cake.jpg" alt="Unicorn Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Magical Unicorn Cake</h3>
                        <p class="text-gray-600 mb-4">Whimsical pastel unicorn cake with rainbow details and magical decorations.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 490.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 10 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/marble-cake.jpg" alt="Marble Effect Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Modern Marble Cake</h3>
                        <p class="text-gray-600 mb-4">Contemporary design with beautiful marble effect and gold accents for a stylish celebration.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 480.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 11 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/cherry-cake.jpg" alt="Cherry Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Cherry Delight Cake</h3>
                        <p class="text-gray-600 mb-4">Sweet pink cake topped with fresh cherries and delicate buttercream decorations.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 420.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cake 12 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="/images/custom-cakes/floral-cake.jpg" alt="Floral Cake" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">Elegant Floral Cake</h3>
                        <p class="text-gray-600 mb-4">Beautiful watercolor effect with delicate floral accents and personalized cake topper.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lily-pink-dark font-medium">From Rp 460.000</span>
                            <button class="bg-lily-pink hover:bg-lily-pink-dark text-white px-4 py-2 rounded-md transition duration-300">
                                Order Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom Cake Order Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">BUAT KUE IMPIANMU BERSAMA KAMI HARI INI!</h2>
            <p class="text-gray-600 max-w-3xl mx-auto mb-8">
                Tim ahli pembuat kue kami yang berdedikasi akan bekerja sama dengan Anda untuk menciptakan dan 
                membuat kue yang sesuai dengan selera dan preferensi Anda.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                <button class="bg-lily-pink-dark text-white px-6 py-3 rounded-md hover:bg-pink-800 transition duration-300 flex items-center justify-center">
                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp for Custom Order
                </button>
            </div>
        </div>
    </section>
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/custome-cake.blade.php ENDPATH**/ ?>