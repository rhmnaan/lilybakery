<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Fresh & Homemade Cakes</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet" />
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="antialiased bg-white">

    @include('layouts.header')

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-24 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg z-50 transition-opacity duration-300"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-24 right-5 bg-red-500 text-white py-2 px-4 rounded-lg shadow-lg z-50 transition-opacity duration-300"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <main class="pt-20">
        <!-- Hero Section -->
        <section class="py-16 relative overflow-hidden h-auto md:h-[900px] overflow-hidden"
            style="background: linear-gradient(90deg, rgb(255, 235, 239) 10%, rgb(241, 61, 104) 300%);">
            <!-- Gambar Banner - versi desktop -->
            <div class="hidden md:block">
                <img src="/images/bannerCake.png" alt="Banner Cake"
                    class="absolute top-0 left-[62%] transform -translate-x-1/3 w-full max-w-[1200px] z-30 opacity-100 drop-shadow-lg" />
            </div>

            <!-- Gambar Banner - versi mobile -->
            <div class="block md:hidden mt-10">
                <img src="/images/bannerCake.png" alt="Banner Cake"
                    class="w-full max-w-md mx-auto opacity-100 drop-shadow-lg" />
            </div>
            <div class="w-full max-w-[1440px] mx-auto px-4 md:px-8 relative z-20">
                <div class="flex flex-col md:flex-row items-center">
                    <!-- Konten Kiri -->
                    <div class="md:w-1/2 mb-8 md:mb-0 pt-1">
                        <h3 class="text-3xl font-normal ">Rasa Autentik, Kualitas Premium</h3>
                        <h1 class="text-4xl md:text-7xl font-semibold mb-6">Manisnya <span
                                class="text-lily-pink-dark">Setiap</span> <br>Gigitan</h1>
                        <p class="text-gray-700 mb-6">
                            Nikmati kue lezat dengan cita rasa istimewa. Fresh, homemade, dan selalu siap menemani momen
                            spesialmu!
                        </p>
                    </div>

                    <!-- Konten Kanan -->
                    <div class="md:w-1/2 relative h-[500px]">
                        <img src="/images/elemencke.png" alt="Chocolate cake" class="elemen-cake" />
                    </div>
                </div>

                <!-- Sosmed -->
                <div class="mt-3">
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
        <section class="py-16 relative overflow-hidden md:h-[650px]" style="background-color: #EFECEA;">
            <img src="/images/elemenrecom1.png" alt="Dekorasi Kiri Atas"
                class="absolute top-0 left-0 w-32 md:w-40 opacity-70 z-0">
            <img src="/images/elemenrecom2.png" alt="Dekorasi Kanan Bawah"
                class="absolute bottom-0 right-0 w-36 md:w-56 opacity-70 z-0 transform rotate-90">

            <div class="container mx-auto px-4 md:px-0 relative z-10">
                <div class="flex flex-col md:flex-row md:items-start items-center gap-8 md:gap-12">
                    <div class="w-full md:w-1/3 text-center md:text-left md:ml-16">
                        {{-- Judul dikembalikan menjadi Rekomendasi --}}
                        <h2 class="text-xl font-bold mb-2 mt-6 md:mt-10 text-[#BC828D]">Recommended Cakes</h2>
                        <p class="text-[#2A2B2A] opacity-50 mb-8 text-sm">
                            Discover our Signature Cakes that make us legendary! <br>
                            Perfect for birthdays, special occasions or simply indulging in a sweet moment just for you.
                        </p>
                    </div>

                    <div class="w-full md:w-2/3 relative md:ml-10">
                        <div id="cakes-container"
                            class="flex gap-6 overflow-x-auto scroll-smooth cursor-grab pr-4 md:pr-10">

                            {{-- [MODIFIKASI] Menggunakan variabel $recommendedProducts --}}
                            @if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
                                @foreach($recommendedProducts as $produk)
                                    <div
                                        class="bg-white rounded-lg overflow-hidden shadow-md w-[300px] h-[450px] flex-shrink-0">

                                        <img src="{{ $produk->gambar ? asset('images/products/' . $produk->gambar) : asset('images/previewcake.png') }}"
                                            alt="{{ $produk->nama_produk }}" class="w-full h-50 object-cover p-4">

                                        <div class="p-4 pt-1">
                                            <h3 class="font-questrial text-[16px] font-normal mb-1">{{ $produk->nama_produk }}
                                            </h3>
                                            <div class="flex space-x-2 items-baseline mb-1">
                                                <p class="font-questrial text-[16px] font-normal mb-0">From</p>
                                                <p class="font-questrial text-[19.05px] font-normal">Rp
                                                    {{ number_format($produk->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div class="flex mb-4">
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <i class="fas fa-star text-yellow-400"></i>
                                            </div>
                                            <form action="{{ route('keranjang.tambah') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="kode_produk" value="{{ $produk->kode_produk }}">
                                                <input type="hidden" name="jumlah" value="1">
                                                <button type="submit"
                                                    class="relative w-full py-2 rounded-full text-black font-semibold overflow-hidden group bg-[#dceae2] opacity-100">
                                                    <span
                                                        class="font-questrial text-[16px] font-normal relative z-10 transition duration-300 group-hover:text-black">Add
                                                        to cart</span>
                                                    <span
                                                        class="absolute inset-0 bg-[#C0CCC6] opacity-100 scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="w-full text-center py-20">
                                    <p class="text-gray-500">Belum ada produk untuk direkomendasikan.</p>
                                </div>
                            @endif
                        </div>

                        <button id="scroll-right"
                            class="hidden md:block absolute top-1/2 right-[-10px] bg-transparent p-3 rounded-full transform -translate-y-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="50" viewBox="0 0 24 24"
                                fill="none" stroke="#D6A4B8" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="10 8 14 12 10 16" />
                            </svg>
                        </button>
                        <div class="flex justify-center mt-4 md:hidden">
                            <button id="scroll-right-mobile" class="bg-transparent p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                                    fill="none" stroke="#D6A4B8" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="10 8 14 12 10 16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Custom Cake Section -->
        <section class="py-16 bg-gray-200">
            <div class="max-w-[95%] mx-auto px-4 text-center">
                <h2 class="text-4xl font-bold mb-2 text-[#585767]">CUSTOM CAKE</h2>
                <p class="text-gray-600 mb-8">
                    Ingin menikmati kue idaman tanpa batas? Anda sendiri! Jangan khawatir!
                </p>
                <button
                    class="bg-[#5E5C70] text-white px-6 py-2 rounded-md hover:bg-gray-800 transition duration-300 mb-12">
                    Lihat Selengkapnya
                </button>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Custom Option 1 -->
                    <div class="bg-white rounded-lg max-w-[90%] mx-auto min-h-[500px]">
                        <div class="bg-blue-100 rounded-t-lg h-64 mb-4 overflow-hidden">
                            <img src="/images/fondantcake.png" alt="Kue Fondant" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[#5E5C70] text-3xl font-bold mb-3 text-left px-4">Kue Fondant</h3>
                        <p class="text-gray-600 text-left px-4 pb-4">
                            Kue fondant menawarkan kebebasan berkreasi tanpa batas, dengan detail tinggi, mulai dari
                            karakter kartun lucu hingga tampilan elegan yang kompleks. Cocok untuk tampilan elegan dan
                            artistik.
                        </p>
                    </div>

                    <!-- Custom Option 2 -->
                    <div class="bg-white rounded-lg max-w-[90%] mx-auto min-h-[500px]">
                        <div class="bg-pink-100 rounded-t-lg h-64 mb-4 overflow-hidden">
                            <img src="/images/buttercream.png" alt="Kue Buttercream" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[#5E5C70] text-3xl font-bold mb-3 text-left px-4">Kue Buttercream</h3>
                        <p class="text-gray-600 text-left px-4 pb-4">
                            Menyajikan kelembutan klasik buttercream dengan sentuhan modern yang akan memuaskan
                            imajinasi! Cocok bagi Anda yang menginginkan tampilan kue yang lebih alami, lembut, namun
                            tetap estetik.
                        </p>
                    </div>

                    <!-- Custom Option 3 -->
                    <div class="bg-white rounded-lg max-w-[90%] mx-auto min-h-[500px]">
                        <div class="bg-yellow-100 rounded-t-lg h-64 mb-4 overflow-hidden">
                            <img src="/images/customlettering.png" alt="Kustom Tulisan"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[#5E5C70] text-3xl font-bold mb-3 text-left px-4">Kustom Tulisan</h3>
                        <p class="text-gray-600 text-left px-4 pb-4">
                            Tambahkan sentuhan personal pada kue dengan tulisan tangan indah. Bisa berupa nama, ucapan
                            selamat, atau kutipan favorit Anda dengan gaya huruf dan warna teks bervariasi. Membuat kue
                            yang terasa lebih bermakna dan berkesan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('layouts.wa')
    @include('layouts.footer')
</body>

</html>