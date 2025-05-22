<!-- Link font Inter dengan weight 500 dan 700 -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">

<header class="bg-white shadow-sm relative pb-4" style="font-family: 'Inter', sans-serif;">
    <div class="bg-[#E59CAA] h-3"></div>
    
    <div class="container ml-12 px-4 flex items-center justify-between">
        <!-- Logo dan Navigasi di Kiri -->
        <div class="flex items-center">
            <!-- Logo -->
            <div class="bg-[#E59CAA] px-5 py-3 shadow-lg rounded-bl-2xl rounded-br-2xl rounded-tl-none rounded-tr-none">
                <a href="/" class="flex items-center">
                    <img src="/images/logo.png" alt="Lily Bakery" class="h-16">
                </a>
            </div>
            
            <!-- Navigasi -->
            <nav class="hidden md:flex ml-20 space-x-8 pt-3 font-bold">
                <a href="#" class="text-[#707070] hover:text-lily-pink-dark">MENU</a>
                <a href="#" class="text-[#707070] hover:text-lily-pink-dark">PROMOTION</a>
                <a href="#" class="text-[#707070] hover:text-lily-pink-dark">STORES</a>
                <a href="#" class="text-[#707070] hover:text-lily-pink-dark">ABOUT US</a>
            </nav>
        </div>

        <!-- Opsi Akun, Keranjang, dan Lokasi -->
        <div class="flex flex-col items-center mt-2 mr-10">
            <div class="flex items-center space-x-4 mr-5">
                <a href="#" class="bg-[#EDF3F7] px-5 py-2 rounded-full text-[#707070] hover:bg-lily-pink transition duration-300 font-bold">
                    CART <i class="fas fa-shopping-cart ml-1"></i>
                </a>
                <a id="login-btn" href="#" class="bg-lily-pink-dark text-white px-10 py-2 rounded-full hover:bg-lily-pink transition duration-300 font-bold">
                    LOGIN/SIGN UP
                </a>
            </div>
            <div class="flex items-center mt-2 space-x-2 text-sm"
                 style="width: max-content; margin-left: 14em;">
                <span class="text-[#707070] font-medium">Location</span>
                <i class="fas fa-map-marker-alt text-[#707070]"></i>
                <i class="fas fa-search text-[#707070]"></i>
            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\Users\acer\OneDrive\Documents\DOKUMEN KULIAH\Semester 4\Kecerdasan Komputasional\lilybakery\resources\views/layouts/header.blade.php ENDPATH**/ ?>