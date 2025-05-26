<<<<<<< HEAD
<style>
    /* Animasi fade dan slide untuk dropdown */
#dropdown-menu {
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.3s ease, transform 0.3s ease;
  pointer-events: none; /* supaya tidak bisa diklik saat tersembunyi */
}

#dropdown-menu.show {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}

/* Transisi warna untuk menu utama */
nav > a, #menu-btn {
  transition: color 0.3s ease;
}

nav > a:hover, #menu-btn:hover {
  color: #d67a8f; /* warna pink gelap untuk hover */
}

/* Transisi untuk animasi rotasi panah */
#menu-btn svg {
  transition: transform 0.3s ease;
  transform-origin: center;
}

/* Ketika dropdown aktif, panah berputar 180 derajat */
#menu-btn.active svg {
  transform: rotate(180deg);
}

</style>

<header class="bg-white shadow-md fixed top-0 left-0 right-0 z-50 pb-4" style="font-family: 'Inter', sans-serif;">
    <!-- Garis pink atas -->
    <div class="bg-[#E59CAA] h-3"></div>

    <!-- Kontainer Header -->
    <div class="w-full max-w-[1400px] mx-auto px-4 flex items-center justify-between">
        <!-- Kiri: Logo + Navigasi -->
        <div class="flex items-center w-full md:w-auto">
            <!-- Logo -->
            <div class="bg-[#E59CAA] px-5 py-3 shadow-lg rounded-bl-2xl rounded-br-2xl m-0">
                <a href="/" class="flex items-center">
                    <img src="/images/logo.png" alt="Lily Bakery" class="h-16">
                </a>
            </div>

            <!-- Navigasi Desktop -->
            <nav class="hidden md:flex ml-8 max-w-full px-8 pt-3 font-bold space-x-8 relative">
                <!-- Menu dropdown -->
                <div class="relative group text-left">
                    <!-- Tombol MENU dengan klik -->
                    <button id="menu-btn" class="text-[#707070] hover:text-lily-pink-dark focus:outline-none flex items-center">
                        <span>MENU</span>
                        <svg class="w-6 h-6 text-[#707070] group-hover:text-lily-pink-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M5.23 7.21a.85.85 0 011.06.02L10 10.94l3.71-3.71a.85.85 0 111.08 1.04l-4.25 4.25a.85.85 0 01-1.08 0L5.21 8.27a.85.85 0 01.02-1.06z"/>
                        </svg>
                    </button>
                </div>
                
                <a href="{{ url('/promotion') }}" class="text-[#707070] hover:text-lily-pink-dark">PROMOTION</a>
                <a href="{{ url('/stores') }}" class="text-[#707070] hover:text-lily-pink-dark">STORES</a>
                <a href="{{ url('/about-us') }}" class="text-[#707070] hover:text-lily-pink-dark">ABOUT US</a>
            </nav>
            <!-- Dropdown Menu -->
            <div id="dropdown-menu" class="absolute left-0 top-full w-full bg-white shadow-lg z-50 py-4 ">
                <div class="flex flex-col space-y-2 text-left ">
                    <a href="{{ url('/menu/bread') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-20">
                        <img src="/images/menu/bread.jpg" alt="Bread" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Bread</span>
                    </a>
                    <a href="{{ url('/menu/cake') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-20">
                        <img src="/images/menu/cake.jpg" alt="Cake" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Cake</span>
                    </a>
                    <a href="{{ url('/custome-cake') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-20">
                        <img src="/images/menu/customCake.jpg" alt="Custom Cake" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Custom Cake</span>
                    </a>
                    <a href="{{ url('/menu/cookies') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-20">
                        <img src="/images/menu/cookies.jpg" alt="Cookies" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Cookies</span>
                    </a>
                    <a href="{{ url('/menu/donat') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-20">
                        <img src="/images/menu/donat.jpg" alt="Donat" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Donat</span>
                    </a>
                    <a href="{{ url('/menu/macaroon') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-20">
                        <img src="/images/menu/Macaroon.jpg" alt="Macaroon" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Macaroon</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kanan: Cart (Mobile) + Toggle (Mobile) + Login (Desktop) -->
        <div class="flex items-center space-x-3">
            <!-- CART versi mobile -->
            <a href="#" class="md:hidden bg-[#EDF3F7] px-4 py-3 rounded-full text-[#707070] hover:bg-lily-pink transition duration-300 font-bold text-sm">
                <i class="fas fa-shopping-cart"></i>
            </a>

            <!-- Toggle Button -->
            <button id="menu-toggle" class="md:hidden text-[#707070] focus:outline-none text-2xl">
                ☰
            </button>

            <!-- Bagian kanan desktop -->
            <div class="hidden md:flex flex-col items-end mt-2">
                <div class="flex items-center space-x-4">
                    <a href="#" class="bg-[#EDF3F7] px-5 py-2 rounded-full text-[#707070] hover:bg-lily-pink transition duration-300 font-bold">
                        CART <i class="fas fa-shopping-cart ml-1"></i>
                    </a>
                    <a id="login-btn" href="{{ url('/login') }}" class="bg-lily-pink-dark text-white px-10 py-2 rounded-full hover:bg-lily-pink transition duration-300 font-bold">
                        LOGIN/SIGN UP
                    </a>
                </div>
                <div class="flex items-center mt-2 space-x-2 text-sm justify-end">
                    <span class="text-[#707070] font-medium">Location</span>
                    <i class="fas fa-map-marker-alt text-[#707070]"></i>
                    <i class="fas fa-search text-[#707070]"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigasi Mobile (Dropdown) -->
    <div id="mobile-menu" class="md:hidden hidden px-6 pb-4">
        <nav class="flex flex-col space-y-2 font-bold mt-4">
            <!-- Tombol dropdown untuk MENU -->
            <button id="mobile-menu-btn" class="flex items-center justify-between w-full text-[#707070] hover:text-lily-pink-dark focus:outline-none">
                MENU
                <svg id="mobile-menu-arrow" class="w-5 h-5 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <!-- Submenu untuk mobile -->
            <div id="mobile-dropdown-menu" class="hidden flex flex-col space-y-2 mt-2">
                <a href="{{ url('/menu/bread') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/bread.jpg" alt="Bread" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Bread</span>
                </a>
                <a href="{{ url('/menu/cake') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/cake.jpg" alt="Cake" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Cake</span>
                </a>
                <a href="{{ url('/custome-cake') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/customCake.jpg" alt="Custom Cake" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Custom Cake</span>
                </a>
                <a href="{{ url('/menu/cookies') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/cookies.jpg" alt="Cookies" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Cookies</span>
                </a>
                <a href="{{ url('/menu/donat') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/donat.jpg" alt="Donat" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Donat</span>
                </a>
                <a href="{{ url('/menu/macaroon') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/Macaroon.jpg" alt="Macaroon" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Macaroon</span>
                </a>
            </div>

            <a href="{{ url('/promotion') }}" class="text-[#707070] hover:text-lily-pink-dark">PROMOTION</a>
            <a href="{{ url('/stores') }}" class="text-[#707070] hover:text-lily-pink-dark">STORES</a>
            <a href="{{ url('/about-us') }}" class="text-[#707070] hover:text-lily-pink-dark">ABOUT US</a>
        </nav>
        <div class="mt-4 flex flex-col space-y-3">
            <a href="{{ url('/login') }}" class="bg-lily-pink-dark text-white px-10 py-2 rounded-full hover:bg-lily-pink transition duration-300 font-bold w-full text-center">
                LOGIN/SIGN UP
            </a>
        </div>
    </div>
</header>

<!-- Script Toggle Menu Mobile -->
<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>


<script>
    const menuBtn = document.getElementById('menu-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');

    menuBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    dropdownMenu.classList.toggle('show');
    menuBtn.classList.toggle('active');  // toggle kelas aktif untuk animasi panah
    });

    window.addEventListener('click', function () {
        dropdownMenu.classList.remove('show');
        menuBtn.classList.remove('active');  // hilangkan animasi panah saat tutup
    });

    dropdownMenu.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // dropdown untuk menu untuk mobile
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileDropdownMenu = document.getElementById('mobile-dropdown-menu');
    const mobileMenuArrow = document.getElementById('mobile-menu-arrow');

    mobileMenuBtn.addEventListener('click', function(e) {
        e.preventDefault();
        mobileDropdownMenu.classList.toggle('hidden');
        // Animasi rotate panah
        if (mobileDropdownMenu.classList.contains('hidden')) {
            mobileMenuArrow.style.transform = 'rotate(0deg)';
        } else {
            mobileMenuArrow.style.transform = 'rotate(180deg)';
        }
    });

</script>

=======
<!-- header.blade.php -->
<!-- Link font Inter with weight 500 and 700 -->
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
                <!-- Menu dropdown -->
                <div class="relative group">
                    <a href="#" class="text-[#707070] hover:text-lily-pink-dark group-hover:text-lily-pink-dark">MENU</a>
                    
                    <!-- Dropdown content -->
                    <div class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50 opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 origin-top-left">
                        <div class="py-2">
                            <!-- Dropdown items -->
                            <a href="{{ url('/menu/bread') }}" class="flex items-center px-4 py-3 hover:bg-gray-50">
                                <img src="/images/menu/bread.jpg" alt="Bread" class="w-10 h-10 rounded-full object-cover">
                                <span class="ml-3 text-gray-700">Bread</span>
                            </a>
                            
                            <a href="{{ url('/menu/cake') }}" class="flex items-center px-4 py-3 hover:bg-gray-50">
                                <img src="/images/menu/cake.jpg" alt="Cake" class="w-10 h-10 rounded-full object-cover">
                                <span class="ml-3 text-gray-700">Cake</span>
                            </a>
                            
                            <a href="{{ url('/custome-cake') }}" class="flex items-center px-4 py-3 hover:bg-gray-50">
                                <img src="/images/menu/custom-cake.jpg" alt="Custom Cake" class="w-10 h-10 rounded-full object-cover">
                                <span class="ml-3 text-gray-700">Custom Cake</span>
                            </a>
                            
                            <a href="{{ url('/menu/cookies') }}" class="flex items-center px-4 py-3 hover:bg-gray-50">
                                <img src="/images/menu/cookies.jpg" alt="Cookies" class="w-10 h-10 rounded-full object-cover">
                                <span class="ml-3 text-gray-700">Cookies</span>
                            </a>
                            
                            <a href="{{ url('/menu/donat') }}" class="flex items-center px-4 py-3 hover:bg-gray-50">
                                <img src="/images/menu/donat.jpg" alt="Donat" class="w-10 h-10 rounded-full object-cover">
                                <span class="ml-3 text-gray-700">Donat</span>
                            </a>
                            
                            <a href="{{ url('/menu/macaroon') }}" class="flex items-center px-4 py-3 hover:bg-gray-50">
                                <img src="/images/menu/macaroon.jpg" alt="Macaroon" class="w-10 h-10 rounded-full object-cover">
                                <span class="ml-3 text-gray-700">Macaroon</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="{{ url('/promotion') }}" class="text-[#707070] hover:text-lily-pink-dark">PROMOTION</a>
                <a href="{{ url('/stores') }}" class="text-[#707070] hover:text-lily-pink-dark">STORES</a>
                <a href="{{ url('/about-us') }}" class="text-[#707070] hover:text-lily-pink-dark">ABOUT US</a>
            </nav>
        </div>

        <!-- Opsi Akun, Keranjang, dan Lokasi -->
        <div class="flex flex-col items-center mt-2 mr-10">
            <div class="flex items-center space-x-4 mr-5">
                <a href="{{ url('/cart') }}" class="bg-[#EDF3F7] px-5 py-2 rounded-full text-[#707070] hover:bg-lily-pink transition duration-300 font-bold">
                    CART <i class="fas fa-shopping-cart ml-1"></i>
                </a>
                
                @auth
                    <!-- Logged in user display -->
                    <a href="{{ url('/profile') }}" class="bg-lily-pink text-white px-5 py-2 rounded-full hover:bg-lily-pink-dark transition duration-300 font-bold flex items-center">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fas fa-user-circle ml-2 text-lg"></i>
                    </a>
                @else
                    <!-- Login/Sign up button for guests -->
                    <a id="login-btn" href="{{ url('/login') }}" class="bg-lily-pink-dark text-white px-10 py-2 rounded-full hover:bg-lily-pink transition duration-300 font-bold">
                        LOGIN/SIGN UP
                    </a>
                @endauth
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

<!-- Add this script at the end of your body tag to ensure dropdown works correctly -->
<script>
    // Optional: Add JavaScript to ensure dropdown remains open when clicked
    document.addEventListener('DOMContentLoaded', function() {
        const menuDropdown = document.querySelector('.group');
        
        menuDropdown.addEventListener('click', function(e) {
            if (e.target.classList.contains('group') || e.target.closest('a').textContent.trim() === 'MENU') {
                e.preventDefault(); // Prevent navigation when clicking MENU directly
            }
        });
    });
</script>
>>>>>>> 23eb2fc99bc707a55f2da3544cca01a9f0c3831a
