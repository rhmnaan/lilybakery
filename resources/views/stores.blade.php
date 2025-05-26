<<<<<<< HEAD
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Stores</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">

@include('layouts.header')

<section class="max-w-7xl mx-auto lg:ml-16 lg:mr-auto px-4 pt-40 pb-20">
    <h1 class="text-4xl font-bold mb-4 text-center lg:text-left">Our Stores</h1>
    <p class="font-inter font-semibold mb-7 text-gray-700 max-w-4xl text-center lg:text-justify mx-auto lg:mx-0">
        Kami berupaya untuk membuat hidup Anda jauh lebih mudah. Toko-toko kami yang terus berkembang tersebar di seluruh Indonesia, tempat Anda dapat memanjakan diri atau menghabiskan waktu berkualitas bersama orang-orang tercinta dalam lingkungan yang mewah dengan suasana yang menyenangkan.
    </p>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Filter -->
        <div class="w-full lg:w-1/5 mx-auto lg:mx-0">
            <div class="border rounded-lg overflow-hidden font-inter font-semibold" id="cityFilter">
                <button data-city="all" class="w-full py-2 px-4 text-left bg-[#D6A1A1] text-black border-b city-btn active">Semua</button>
                <button data-city="BALI" class="w-full py-2 px-4 text-left hover:bg-gray-50 border-b city-btn">Bali</button>
                <button data-city="JAKARTA" class="w-full py-2 px-4 text-left hover:bg-gray-50 border-b city-btn">Jakarta</button>
                <button data-city="SURABAYA" class="w-full py-2 px-4 text-left hover:bg-gray-50 city-btn">Surabaya</button>
            </div>
        </div>


        <!-- Store Cards -->
        <div class="w-full lg:w-4/5 grid grid-cols-1 md:grid-cols-2 gap-6" id="storeContainer">
            @php
                $stores = [
                    [
                        'city' => 'JAKARTA',
                        'address' => 'Jl. MH Thamrin No. 10, Kel. Gondangdia, Kec. Menteng, Jakarta Pusat, DKI Jakarta 10350',
                    ],
                    [
                        'city' => 'SURABAYA',
                        'address' => 'Jl. Tunjungan No. 45, Kel. Genteng, Kec. Genteng, Surabaya, Jawa Timur 60275',
                    ],
                    [
                        'city' => 'BALI',
                        'address' => 'Jl. Raya Legian No. 88, Kel. Legian, Kec. Kuta, Badung, Bali 80361',
                    ],
                ];
            @endphp

            @foreach($stores as $store)
            <div class="border rounded-lg overflow-hidden shadow-sm store-card" data-city="{{ $store['city'] }}">
                <div class="px-3 pt-3">
                    <img src="/images/store.png" alt="Lily Bakery {{ $store['city'] }}" class="w-full h-64 object-cover rounded-md">
                </div>
                <div class="p-4 space-y-2">
                    <h2 class="text-lg font-semibold">LILY BAKERY {{ $store['city'] }}</h2>
                    <p class="text-sm text-gray-600">{{ $store['address'] }}</p>
                    <div class="flex items-center text-sm text-gray-700 gap-2 mt-2">
                        <i class="fas fa-phone-alt"></i> <span>1500581</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-700 gap-2">
                        <i class="fas fa-clock"></i> <span>08:00 - 22:00</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-700 gap-2">
                        <i class="fas fa-map-marker-alt"></i> <span>View Location ></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@include('layouts.footer')

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const buttons = document.querySelectorAll('.city-btn');
        const cards = document.querySelectorAll('.store-card');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const selectedCity = button.dataset.city;

                // Hapus semua highlight
                buttons.forEach(btn => {
                    btn.classList.remove('bg-[#D6A1A1]', 'text-black', 'active');
                });

                // Tambahkan highlight ke tombol yang diklik
                button.classList.add('bg-[#D6A1A1]', 'text-black', 'active');

                // Filter kartu toko
                cards.forEach(card => {
                    const cardCity = card.dataset.city;
                    if (selectedCity === 'all' || cardCity === selectedCity) {
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
=======
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Stores</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    @include('layouts.header')

    <section class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Our Stores</h1>
        <p class="text-gray-600 mb-8 max-w-3xl">
        Kami berupaya untuk membuat hidup Anda jauh lebih mudah. Toko-toko kami yang terus berkembang tersebar di seluruh Indonesia, tempat Anda dapat memanjakan diri atau menghabiskan waktu berkualitas bersama orang-orang tercinta dalam lingkungan yang mewah dengan suasana yang menyenangkan.
        </p>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filter Sidebar -->
            <aside class="w-full lg:w-1/4">
                <div class="flex flex-col gap-2">
                <button class="text-left bg-pink-200 text-black font-medium px-4 py-2 rounded">Semua</button>
                <button class="text-left border border-gray-300 px-4 py-2 rounded hover:bg-gray-100">Bali</button>
                <button class="text-left border border-gray-300 px-4 py-2 rounded hover:bg-gray-100">Jakarta</button>
                <button class="text-left border border-gray-300 px-4 py-2 rounded hover:bg-gray-100">Surabaya</button>
                </div>
            </aside>

            <!-- Store Cards -->
            <div class="w-full lg:w-3/4 grid sm:grid-cols-2 gap-6">
                <div class="border rounded-lg overflow-hidden shadow-sm bg-white">
                    <img src="{{ $store['image'] }}" alt="{{ $store['name'] }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">{{ $store['name'] }}</h3>
                    <p class="text-sm text-gray-700 mb-3">{{ $store['address'] }}</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-center gap-2">
                        <i class="fas fa-phone text-pink-500"></i> 1500581
                        </li>
                        <li class="flex items-center gap-2">
                        <i class="fas fa-clock text-pink-500"></i> 08:00 - 22:00
                        </li>
                        <li class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-pink-500"></i>
                        <a href="#" class="text-pink-600 hover:underline">View Location &gt;</a>
                        </li>
                    </ul>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 col-span-full">Tidak ada store yang tersedia saat ini.</p>
                @endforelse
            </div>
        </div>
    </section>

    @include('layouts.footer')
</body>
</html>
>>>>>>> 23eb2fc99bc707a55f2da3544cca01a9f0c3831a
