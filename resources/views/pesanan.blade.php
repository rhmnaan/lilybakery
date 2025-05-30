<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Pesanan</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">

    @include('layouts.header')

    @auth('pelanggan')
    <!-- Greeting Section -->
    <section class="flex gap-36 pt-10 px-10 mt-28 ml-9">
        <h1 class="text-3xl mb-4 font-inter font-bold">Hi, <span>{{ Str::limit(Auth::guard('pelanggan')->user()->nama_pelanggan, 12) }}</span></h1>
    </section>

    <div class="px-6 pb-10 lg:flex gap-10 ml-10 mr-20">
        <!-- Sidebar -->
        <div class="w-full lg:w-1/5 mb-5 lg:mb-0">
            <div class="border rounded-lg overflow-hidden font-inter text-sm">
                <a href="{{ url('profil-pelanggan') }}" class="block py-3 px-4 hover:bg-gray-100 border-b">Account</a>
                <button class="block w-full text-left py-3 px-4 bg-[#D6A1A1] text-black font-semibold border-b">Pesanan</button>
                <form method="POST" action="{{ route('pelanggan.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-3 px-4 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>

        <!-- Orders Content -->
        <div class="w-full lg:w-4/5">
            <h2 class="text-lg font-bold mb-4">PESANAN</h2>
            <section>
                <!-- Tab Menu -->
                <div class="flex space-x-32 font-semibold bg-[#D6A1A1] text-sm pb-2 pt-2 pl-4">
                    <button class="px-4 py-2 text-black hover:text-white">SEMUA</button>
                    <button class="px-4 py-2 text-black hover:text-white">BELUM BAYAR</button>
                    <button class="px-4 py-2 text-black hover:text-white">DIPROSES</button>
                    <button class="px-4 py-2 text-black hover:text-white">DIKIRIM</button>
                    <button class="px-4 py-2 text-black hover:text-white">SELESAI</button>
                </div>
                <!-- Order List -->
                <div class="space-y-4 bg-gray-300">
                    proses untuk mengambil ke database.
                </div>
            </section>
        </div>
    </div>
    @endauth

    @include('layouts.footer')

</body>
</html>