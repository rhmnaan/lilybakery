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

    /* Style untuk leaflet map */
    #map {
    width: 100%;
    height: 16rem;
    border-radius: 0.375rem;
    }

    #location-search-input {
      width: 150px;
      transition: width 0.3s ease;
    }

    /* CSS untuk dropdown profil */
    #profile-dropdown-menu {
        opacity: 0;
        transform: translateY(-10px);
        /* Efek slide dari atas */
        transition: opacity 0.25s ease-out, transform 0.25s ease-out, visibility 0s linear 0.25s;
        /* Transisi lebih lambat & tunda visibility saat hilang */
        visibility: hidden;
        /* Sembunyikan & tidak bisa diklik saat opacity 0 */
        pointer-events: none;
    }

    /* Saat parent (.group) di-hover, tampilkan dropdown profil */
    .group:hover #profile-dropdown-menu {
        opacity: 1;
        transform: translateY(0);
        transition-delay: 0s;
        /* Tidak ada penundaan saat muncul */
        visibility: visible;
        /* Bisa dilihat & diklik */
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
                    <a href="{{ url('/custom-cakes') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-20">
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
                    <a href="{{ url('/keranjang') }}"
                        class="bg-[#EDF3F7] px-5 py-2 rounded-full text-[#707070] hover:bg-lily-pink transition duration-300 font-bold">
                        CART <i class="fas fa-shopping-cart ml-1"></i>
                    </a>

                    @auth('pelanggan')
                        {{-- Jika pelanggan sudah login --}}
                        <div class="relative group">
                            <a href="{{ url('/profil-pelanggan') }}"
                                class="bg-lily-pink-dark text-white px-6 py-2 rounded-full hover:bg-lily-pink transition duration-300 font-bold flex items-center space-x-2">
                                <span>{{ Str::limit(Auth::guard('pelanggan')->user()->nama_pelanggan, 12) }}</span>
                                <svg class="w-8 h-6" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24">
                                  <path fill-rule="evenodd" d="M12 2a5 5 0 100 10 5 5 0 000-10zm-7 18a7 7 0 0114 0H5z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    @else
                        {{-- Jika pengguna adalah tamu (belum login) --}}
                        <a id="login-btn" href="{{ route('pelanggan.login.form') }}"
                            class="bg-lily-pink-dark text-white px-10 py-2 rounded-full hover:bg-lily-pink transition duration-300 font-bold">
                            LOGIN/SIGN UP
                        </a>
                    @endauth
                </div>

              <div class="flex items-center mt-2 space-x-2 text-sm justify-end text-[#707070] hover:text-lily-pink-dark relative" id="location-search-wrapper">
                <!-- Input search, sembunyi default -->
                <input
                  type="text"
                  id="search-input"
                  placeholder="Search..."
                  class="hidden px-3 py-1 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-lily-pink"
                  style="width: 180px;"
                />
                <!-- Tombol location + nama lokasi -->
                <button id="location-trigger" class="flex items-center mt-2 space-x-2 text-sm justify-end text-[#707070] hover:text-lily-pink-dark relative">
                  <span class="font-medium" id="location-name">Location</span>
                  <i class="fas fa-map-marker-alt"></i>
                  
                  <!-- Input search, awalnya sembunyi -->
                  <input type="text" id="location-search-input" placeholder="Search location..." 
                        class="hidden ml-2 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none" />
                </button>

                <!-- Tombol search -->
                <button id="search-trigger" class="flex items-center ml-2 text-[#707070] hover:text-lily-pink-dark" type="button">
                  <i class="fas fa-search"></i>
                </button>
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
            <div id="mobile-dropdown-menu"
                class="hidden flex-col space-y-2 mt-2 transition-all duration-300 ease-in-out transform opacity-0 scale-y-95 origin-top">

                <a href="{{ url('/menu/bread') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/bread.jpg" alt="Bread" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Bread</span>
                </a>
                <a href="{{ url('/menu/cake') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
                    <img src="/images/menu/cake.jpg" alt="Cake" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-questrial text-[16px] font-normal ml-3 text-gray-700">Cake</span>
                </a>
                <a href="{{ url('/custom-cakes') }}" class="flex items-center py-2 hover:bg-gray-100 rounded pl-4">
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

            @auth('pelanggan')
                {{-- Jika pelanggan sudah login (Mobile) --}}
                {{-- Jika pelanggan sudah login --}}
                <div class="relative group">
                    <a href="{{ url('/profil-pelanggan') }}"
                        class="bg-lily-pink-dark text-white px-6 py-2 rounded-full hover:bg-lily-pink transition duration-300 font-bold flex items-center space-x-2">
                        <span>{{ Str::limit(Auth::guard('pelanggan')->user()->nama_pelanggan, 12) }}</span>
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            @else
                {{-- Jika pengguna adalah tamu (belum login) (Mobile) --}}
                <a href="{{ route('pelanggan.login.form') }}" class="text-[#707070] hover:text-lily-pink-dark">LOGIN/SIGN
                    UP</a>
            @endauth
        </nav>
    </div>
</header>

<!-- Popup Location -->
<div id="location-popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
  <div class="bg-white p-6 rounded shadow-lg w-96 max-w-full relative">
    <button id="close-popup" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg font-bold">&times;</button>
    <h2 class="text-xl font-bold mb-4">Select Your Location</h2>
    <div id="map" class="rounded mb-4"></div>

    <!-- Tombol Set Location (deteksi lokasi user) -->
    <button id="set-location-btn" class="bg-lily-pink text-white font-bold py-2 px-4 rounded w-full mb-2">
      Set Location (Detect My Location)
    </button>

    <!-- Tombol Confirm Location -->
    <button id="confirm-location-btn" class="bg-lily-pink-dark hover:bg-lily-pink text-white font-bold py-2 px-4 rounded w-full">
      Confirm Location
    </button>
  </div>
</div>


<!-- Leaflet CSS dan JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Script gabungan: Toggle menu, dropdown, dan lokasi -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // ===============================
    // 1. Toggle Menu Mobile (hamburger)
    // ===============================
    document.getElementById('menu-toggle').addEventListener('click', function () {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('hidden');
    });

    // ===============================
    // 2. Dropdown Menu Desktop (navbar user dropdown)
    // ===============================
    const menuBtn = document.getElementById('menu-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');

    menuBtn.addEventListener('click', function (e) {
      e.stopPropagation(); // agar klik tidak menutup dropdown
      dropdownMenu.classList.toggle('show');
      menuBtn.classList.toggle('active'); // animasi rotasi panah
    });

    // Tutup dropdown jika klik di luar
    window.addEventListener('click', function () {
      dropdownMenu.classList.remove('show');
      menuBtn.classList.remove('active');
    });

    dropdownMenu.addEventListener('click', function (e) {
      e.stopPropagation(); // cegah penutupan saat klik isi dropdown
    });

    // ===============================
    // 3. Dropdown Menu Mobile (dengan animasi Tailwind)
    // ===============================
    const mobileBtn = document.getElementById("mobile-menu-btn");
    const mobileDropdown = document.getElementById("mobile-dropdown-menu");
    const arrowIcon = document.getElementById("mobile-menu-arrow");

    mobileBtn.addEventListener("click", function () {
      const isHidden = mobileDropdown.classList.contains("hidden");

      if (isHidden) {
        // Tampilkan dropdown dengan animasi
        mobileDropdown.classList.remove("hidden");
        setTimeout(() => {
          mobileDropdown.classList.remove("opacity-0", "scale-y-95");
          mobileDropdown.classList.add("opacity-100", "scale-y-100");
        }, 10);
        arrowIcon.classList.add("rotate-180"); // rotasi panah ke atas
      } else {
        // Sembunyikan dengan animasi keluar
        mobileDropdown.classList.remove("opacity-100", "scale-y-100");
        mobileDropdown.classList.add("opacity-0", "scale-y-95");
        arrowIcon.classList.remove("rotate-180");
        setTimeout(() => {
          mobileDropdown.classList.add("hidden");
        }, 300); // delay sesuai durasi animasi
      }
    });

    // ===============================
    // 4. Peta Lokasi (Leaflet + Geolokasi)
    // ===============================
    let selectedLatLng = null;
    let marker = null;

    const locationPopup = document.getElementById('location-popup');
    const locationTrigger = document.getElementById('location-trigger');
    const closePopup = document.getElementById('close-popup');
    const setLocationBtn = document.getElementById('set-location-btn');
    const confirmLocationBtn = document.getElementById('confirm-location-btn');
    const locationNameSpan = document.getElementById('location-name');

    // Inisialisasi peta dengan posisi default Jakarta
    const map = L.map('map').setView([-6.200000, 106.816666], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Buka popup lokasi
    locationTrigger.addEventListener('click', () => {
      locationPopup.classList.remove('hidden');
      setTimeout(() => map.invalidateSize(), 100); // refresh peta setelah muncul
    });

    // Tutup popup lokasi
    closePopup.addEventListener('click', () => {
      locationPopup.classList.add('hidden');
    });

    // Klik peta untuk pilih lokasi manual
    map.on('click', function(e) {
      selectedLatLng = e.latlng;
      if (marker) {
        marker.setLatLng(e.latlng);
      } else {
        marker = L.marker(e.latlng).addTo(map);
      }
    });

    // Tombol 'Set Location': deteksi lokasi user
    setLocationBtn.addEventListener('click', () => {
      if (!navigator.geolocation) {
        alert("Geolocation is not supported by your browser.");
        return;
      }
      setLocationBtn.textContent = "Detecting location...";
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const lat = position.coords.latitude;
          const lng = position.coords.longitude;
          selectedLatLng = L.latLng(lat, lng);

          map.setView(selectedLatLng, 15);
          if (marker) {
            marker.setLatLng(selectedLatLng);
          } else {
            marker = L.marker(selectedLatLng).addTo(map);
          }

          setLocationBtn.textContent = "Set Location (Detect My Location)";
        },
        (error) => {
          alert("Unable to retrieve your location: " + error.message);
          setLocationBtn.textContent = "Set Location (Detect My Location)";
        },
        {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0
        }
      );
    });

    // Fungsi reverse geocoding ambil nama kota dari lat lng
    async function getRegionName(lat, lng) {
      const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;
      try {
        const response = await fetch(url, { headers: { 'Accept-Language': 'id' } });
        const data = await response.json();
        const addr = data.address || {};
        return addr.city || addr.town || addr.village || addr.county || addr.state || 'Nama daerah tidak ditemukan';
      } catch {
        return 'Gagal mengambil nama daerah';
      }
    }

    // Tombol 'Confirm Location': tampilkan nama daerah & tutup popup
    confirmLocationBtn.addEventListener('click', async () => {
      if (selectedLatLng) {
        const regionName = await getRegionName(selectedLatLng.lat, selectedLatLng.lng);
        locationNameSpan.textContent = regionName;
        locationPopup.classList.add('hidden');
      } else {
        alert("Silakan pilih lokasi terlebih dahulu di peta atau gunakan 'Set Location' untuk mendeteksi lokasi Anda.");
      }
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
  const searchTrigger = document.getElementById('search-trigger');
  const searchInput = document.getElementById('search-input');
  const locationTrigger = document.getElementById('location-trigger');

  searchTrigger.addEventListener('click', function () {
    if (searchInput.classList.contains('hidden')) {
      // Tampilkan input dan fokus
      searchInput.classList.remove('hidden');
      searchInput.focus();
    } else {
      // Jika sudah tampil, sembunyikan lagi
      searchInput.classList.add('hidden');
      searchInput.value = '';
    }
  });

  // Optional: sembunyikan input search saat klik di luar
  document.addEventListener('click', function (event) {
    if (!document.getElementById('location-search-wrapper').contains(event.target)) {
      searchInput.classList.add('hidden');
      searchInput.value = '';
    }
  });
});

</script>
