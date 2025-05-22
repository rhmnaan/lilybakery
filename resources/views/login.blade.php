<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .lily-pink {
            background-color: #f8b4c4;
        }
        .lily-pink-dark {
            color: #e879a0;
        }
        .lily-pink-bg {
            background-color: #e879a0;
        }
        .text-lily-pink-dark {
            color: #e879a0;
        }
        .bg-lily-pink {
            background-color: #f8b4c4;
        }
        .hover\:bg-lily-pink-dark:hover {
            background-color: #e879a0;
        }
        .border-lily-pink-dark {
            border-color: #e879a0;
        }
        .login-bg {
            background: linear-gradient(135deg, #f8b4c4 0%, #e879a0 100%);
        }
    </style>
</head>
<body class="antialiased bg-gray-100 min-h-screen">
    
    @include('layouts.header')

    <!-- Login Section -->
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome!</h2>
                    <p class="text-gray-600">Enter your email / mobile number and<br>password to login</p>
                </div>

                <form method="POST" action="">
                    @csrf
                    
                    <!-- Email / Mobile Number -->
                    <div class="mb-4">
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Email / Mobile Number"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Your Password"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                            required
                        >
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-left mb-6">
                        <a href="" class="text-gray-600 hover:text-lily-pink-dark text-sm">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full lily-pink-bg text-white py-3 rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                    >
                        Login
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Don't have account? 
                        <a href="{{ url('/register') }}" class="text-lily-pink-dark hover:underline font-medium">Register</a>
                    </p>
                    <p class="text-gray-600 mt-2">
                        Login As Admin? 
                        <a href="{{ url('/admin-login') }}" class="text-lily-pink-dark hover:underline font-medium">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

</body>
</html>