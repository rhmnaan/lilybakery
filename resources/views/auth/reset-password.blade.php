<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Lily Bakery</title>
       @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-white min-h-screen font-inter">

    {{-- Memuat header dari layout --}}
    @include('layouts.header')

    <!-- Reset Password Section - Konten utama form -->
    <section class="flex items-center justify-center py-12 px-4 pt-40">
        <div class="w-full max-w-sm sm:max-w-md md:max-w-lg">
            <div class="bg-[#EDF3F7] rounded-2xl shadow-lg p-6 sm:p-8 md:p-14">
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Reset Password</h2>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                        Silakan masukkan password baru Anda.
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
                {{-- Tambahan untuk menampilkan error validasi bawaan Laravel --}}
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/forgot-password/reset" method="POST" class="space-y-6">
                    {{-- CSRF token (penting untuk Laravel) --}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{-- Pastikan email tersembunyi juga disertakan jika dibutuhkan oleh backend --}}
                    {{-- <input type="hidden" name="email" value="{{ $email ?? '' }}"> --}}
                    {{-- Token reset password jika digunakan oleh Laravel --}}
                    {{-- <input type="hidden" name="token" value="{{ $token ?? '' }}"> --}}


                    <!-- Password Baru -->
                    <div class="relative">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password Baru</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password baru Anda"
                            class="w-full px-4 py-3 bg-white rounded-full border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-400 transition duration-300 text-sm sm:text-base pr-12"
                            required
                        />
                        <span id="togglePassword" class="absolute inset-y-0 right-4 flex items-center cursor-pointer text-gray-600 top-8">
                            <span id="eyeIconWrapper">
                                <!-- Default: mata tertutup -->
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-eye-closed-icon lucide-eye-closed">
                                    <path d="m15 18-.722-3.25"/>
                                    <path d="M2 8a10.645 10.645 0 0 0 20 0"/>
                                    <path d="m20 15-1.726-2.05"/>
                                    <path d="m4 15 1.726-2.05"/>
                                    <path d="m9 18 .722-3.25"/>
                                </svg>
                            </span>
                        </span>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="relative">
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Konfirmasi password baru Anda"
                            class="w-full px-4 py-3 bg-white rounded-full border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-400 transition duration-300 text-sm sm:text-base pr-12"
                            required
                        />
                        <span id="togglePasswordConfirmation" class="absolute inset-y-0 right-4 flex items-center cursor-pointer text-gray-600 top-8">
                            <span id="eyeIconWrapperConfirmation">
                                <!-- Default: mata tertutup -->
                                <svg id="eyeIconConfirmation" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-eye-closed-icon lucide-eye-closed">
                                    <path d="m15 18-.722-3.25"/>
                                    <path d="M2 8a10.645 10.645 0 0 0 20 0"/>
                                    <path d="m20 15-1.726-2.05"/>
                                    <path d="m4 15 1.726-2.05"/>
                                    <path d="m9 18 .722-3.25"/>
                                </svg>
                            </span>
                        </span>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-[#E59CAA] hover:bg-[#D88D9A] text-white py-3 rounded-full font-medium transition duration-300 shadow-md"
                    >
                        Reset Password
                    </button>
                </form>

                <!-- Kembali ke Login -->
                <div class="text-center mt-6 text-sm sm:text-base">
                    <p class="text-gray-600">
                        Password berhasil diubah?
                        <a href="{{ url('/login') }}" class="text-pink-400 hover:underline font-medium">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Memuat footer dari layout --}}
    @include('layouts.footer')

    <script>
        // Script untuk toggle password visibility
        function setupPasswordToggle(toggleId, inputId, eyeIconWrapperId, eyeIconId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            const eyeIconWrapper = document.getElementById(eyeIconWrapperId);

            let isVisible = false;

            const eyeClosedSVG = `
                <svg id="${eyeIconId}" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-eye-closed-icon lucide-eye-closed">
                    <path d="m15 18-.722-3.25"/>
                    <path d="M2 8a10.645 10.645 0 0 0 20 0"/>
                    <path d="m20 15-1.726-2.05"/>
                    <path d="m4 15 1.726-2.05"/>
                    <path d="m9 18 .722-3.25"/>
                </svg>
            `;

            const eyeOpenSVG = `
                <svg id="${eyeIconId}" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucude-eye-icon lucide-eye">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            `;

            toggle.addEventListener("click", function () {
                isVisible = !isVisible;
                input.setAttribute("type", isVisible ? "text" : "password");
                eyeIconWrapper.innerHTML = isVisible ? eyeOpenSVG : eyeClosedSVG;
            });

            // Initial state based on current input type
            eyeIconWrapper.innerHTML = input.type === 'password' ? eyeClosedSVG : eyeOpenSVG;
        }

        // Setup for Password Baru
        setupPasswordToggle('togglePassword', 'password', 'eyeIconWrapper', 'eyeIcon');
        // Setup for Konfirmasi Password
        setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation', 'eyeIconWrapperConfirmation', 'eyeIconConfirmation');

    </script>
</body>
</html>
