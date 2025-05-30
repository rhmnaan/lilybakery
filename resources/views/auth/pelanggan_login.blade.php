<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-white min-h-screen font-inter">

    @include('layouts.header')

    <!-- Login Section -->
    <section class="flex items-center justify-center py-12 px-4 pt-40">
        <div class="w-full max-w-sm sm:max-w-md md:max-w-lg">
            <!-- Login Card -->
            <div class="bg-[#EDF3F7] rounded-2xl shadow-lg p-6 sm:p-8 md:p-14">
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Welcome!</h2>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                        Enter your email / mobile number and<br />password to login
                    </p>
                </div>

                <form method="POST" action="{{ route('pelanggan.login.attempt') }}" class="space-y-4">
                    @csrf

                    <!-- Email / Mobile Number -->
                    <div>
                        <input
                            type="email"
                            name="email"
                            placeholder="Email / Mobile Number"
                            class="w-full px-4 py-3 bg-white rounded-full border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-400 transition duration-300 text-sm sm:text-base"
                            value="{{ old('email') }}"
                            required
                        />
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Your Password"
                            class="w-full px-4 py-3 bg-white rounded-full border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-400 transition duration-300 text-sm sm:text-base pr-12"
                            required
                        />
                        <span id="togglePassword" class="absolute inset-y-0 right-4 flex items-center cursor-pointer text-gray-600">
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


                    <!-- Forgot Password -->
                    <div class="text-left">
                        <a href="" class="text-gray-600 hover:text-pink-400 text-sm">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button
                        type="submit"
                        class="w-full bg-[#E59CAA] hover:bg-[#D88D9A] text-white py-3 rounded-full font-medium transition duration-300 shadow-md"
                    >
                        Login
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6 text-sm sm:text-base">
                    <p class="text-gray-600">
                        Don't have account?
                        <a href="{{ url('/register') }}" class="text-pink-400 hover:underline font-medium">Register</a>
                    </p>
                    <p class="text-gray-600 mt-2">
                        Login As Admin?
                        <a href="{{ url('/admin-login') }}" class="text-pink-400 hover:underline font-medium">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        const eyeIconWrapper = document.getElementById("eyeIconWrapper");

        let isVisible = false;

        const eyeClosedSVG = `
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
        `;

        const eyeOpenSVG = `
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-eye-off-icon lucide-eye-off">
                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696
                10.747 10.747 0 0 1-1.444 2.49"/>
                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151
                1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
                <path d="m2 2 20 20"/>
            </svg>
        `;

        togglePassword.addEventListener("click", function () {
            isVisible = !isVisible;
            passwordInput.setAttribute("type", isVisible ? "text" : "password");
            eyeIconWrapper.innerHTML = isVisible ? eyeOpenSVG : eyeClosedSVG;
        });

    </script>


</body>
</html>