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