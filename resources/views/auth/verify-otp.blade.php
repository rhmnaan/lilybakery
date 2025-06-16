<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OTP - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen antialiased">

@include('layouts.header')

<section class="flex items-center justify-center py-20 px-4">
    <div class="w-full max-w-md mt-24">
        {{-- Card Container --}}
        <div class="bg-white rounded-2xl shadow-md p-8 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
            <p class="text-gray-600 mb-6">Kirim OTP dengan :</p>

            {{-- Notifikasi Error --}}
            @if (session('otp_error'))
                <div class="bg-red-100 text-red-600 text-sm px-4 py-2 rounded mb-4">
                    {{ session('otp_error') }}
                </div>
            @endif
            @if (session('otp_expired'))
                <div class="bg-yellow-100 text-yellow-700 text-sm px-4 py-2 rounded mb-4">
                    {{ session('otp_expired') }}
                </div>
            @endif

            {{-- Form Input OTP --}}
            <form action="{{ route('verify.otp') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden"
                       name="email"
                       value="{{ session('email') }}"
                       class="hidden"
                       >
                <input 
                    type="text" 
                    name="otp" 
                    placeholder="Masukkan Kode OTP"
                    maxlength="6"
                    class="w-full px-4 py-3 rounded-full border border-gray-300 text-center focus:outline-none focus:ring-2 focus:ring-pink-400"
                    required
                >
                @error('otp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <button 
                    type="submit" 
                    class="w-full mt-4 bg-pink-400 text-white font-medium py-3 rounded-full hover:bg-pink-500 transition"
                >
                    Kirim OTP
                </button>
            </form>

            {{-- Tombol Kirim Ulang --}}
            <form action="{{ route('resend.otp') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <button class="text-sm text-gray-500 hover:text-pink-500 transition" type="submit">Kirim ulang kode OTP</button>
            </form>

            <div class="mt-6">
                <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-pink-500">← Kembali</a>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')

</body>
</html>
