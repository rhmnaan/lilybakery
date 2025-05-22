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

    <!-- Header section -->
    <section class="py-16 bg-white"> 
        <div class="container mx-auto px-4"> 
            <div class="flex flex-col md:flex-row md:space-x-8">
                <!-- Informasi Kontak -->
                <div class="bg-[#D89CA2] text-black rounded-xl shadow-md px-6 py-10 mb-10 md:mb-0 w-full md:w-1/2">
                    <div class="space-y-10 text-center text-lg font-semibold">
                    <div>
                        <div class="text-7xl mb-2"><i class="fas fa-headphones-alt"></i></div>
                        <div>Hotline</div>
                        <div class="text-2xl font-bold">1500581</div>
                    </div>
                    <div>
                        <div class="text-7xl mb-2"><i class="fab fa-whatsapp"></i></div>
                        <div>Whatsapp</div>
                        <div class="text-2xl font-bold">+6282123456789</div>
                    </div>
                    <div>
                        <div class="text-7xl mb-2"><i class="fas fa-envelope"></i></div>
                        <div>Email</div>
                        <div class="text-2xl font-bold break-words">info@lilybakery.id</div>
                    </div>
                    </div>
                </div>

                <!-- Form Kontak -->
                <div class="bg-white border rounded-xl px-6 py-10 w-full md:w-1/2">
                    <h2 class="text-2xl font-bold mb-6">Contact</h2>
                    <form action="#" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="nama" class="block text-gray-700 font-medium">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="w-full border rounded px-3 py-2 mt-1 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="telepon" class="block text-gray-700 font-medium">Nomor Telepon</label>
                        <input type="text" id="telepon" name="telepon" class="w-full border rounded px-3 py-2 mt-1 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-medium">Email</label>
                        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 mt-1 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="pesan" class="block text-gray-700 font-medium">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="4" class="w-full border rounded px-3 py-2 mt-1 focus:outline-none" required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#D89CA2] text-white px-6 py-2 rounded hover:bg-[#c4868d] transition-colors">Kirim</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> 
    </section>


    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/contact.blade.php ENDPATH**/ ?>