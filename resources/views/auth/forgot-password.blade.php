<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forget Password - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-white min-h-screen font-inter">

    {{-- Memuat header dari layout --}}
    @include('layouts.header')

    <!-- Login Section - Konten utama form -->
    <section class="flex items-center justify-center py-12 px-4 pt-40">
        <div class="w-full max-w-sm sm:max-w-md md:max-w-lg">
            <div class="bg-[#EDF3F7] rounded-2xl shadow-lg p-6 sm:p-8 md:p-14">
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Lupa Password?</h2>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                        Masukkan email terdaftar Anda untuk menerima kode OTP.
                    </p>
                </div>

                {{-- Tampilkan pesan sukses --}}
                @if(session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                {{-- Tampilkan pesan error --}}
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('forgot.password.sendOtp') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email Terdaftar -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Terdaftar</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Masukkan email Anda"
                            class="w-full px-4 py-3 bg-white rounded-full border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-400 transition duration-300 text-sm sm:text-base"
                            value="{{ old('email') }}"
                            required
                        />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kirim OTP Button -->
                    <button
                        type="submit"
                        class="w-full bg-[#E59CAA] hover:bg-[#D88D9A] text-white py-3 rounded-full font-medium transition duration-300 shadow-md"
                    >
                        Kirim OTP
                    </button>
                </form>

                <!-- Kembali ke Login -->
                <div class="text-center mt-6 text-sm sm:text-base">
                    <p class="text-gray-600">
                        Kembali ke halaman login?
                        <a href="{{ url('/login') }}" class="text-pink-400 hover:underline font-medium">Klik di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Memuat footer dari layout --}}
    @include('layouts.footer')

</body>
</html>
