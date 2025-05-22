<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Lily Bakery</title>
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
        .register-bg {
            background: linear-gradient(135deg, #f8b4c4 0%, #e879a0 100%);
        }
        .step-active {
            background-color: #e879a0;
            color: white;
        }
        .step-inactive {
            background-color: #f3f4f6;
            color: #6b7280;
        }
    </style>
</head>
<body class="antialiased bg-gray-100 min-h-screen">
    
    @include('layouts.header')

    <!-- Register Section -->
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                
                <!-- Step 1: Choose OTP Method -->
                <div id="step1" class="step-container">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                        <p class="text-gray-600">Kirim OTP dengan :</p>
                    </div>

                    <form id="chooseOtpForm" method="POST" action="">
                        @csrf
                        
                        <!-- Phone Number Button -->
                        <div class="mb-4">
                            <button 
                                type="button"
                                onclick="selectOtpMethod('phone')"
                                class="w-full px-4 py-4 lily-pink text-white rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                            >
                                Nomor Telepon
                            </button>
                        </div>

                        <!-- Email Button -->
                        <div class="mb-6">
                            <button 
                                type="button"
                                onclick="selectOtpMethod('email')"
                                class="w-full px-4 py-4 lily-pink text-white rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                            >
                                Email
                            </button>
                        </div>

                        <input type="hidden" id="otp_method" name="otp_method" value="">
                    </form>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Already have account? 
                            <a href="" class="text-lily-pink-dark hover:underline font-medium">Login</a>
                        </p>
                    </div>
                </div>

                <!-- Step 2: Enter Contact Info -->
                <div id="step2" class="step-container hidden">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                        <p class="text-gray-600" id="step2-subtitle">Kirim OTP dengan :</p>
                    </div>

                    <form id="sendOtpForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="otp_method" id="selected_method" value="">
                        
                        <!-- Contact Input -->
                        <div class="mb-6">
                            <input 
                                type="text" 
                                name="contact" 
                                id="contact_input"
                                placeholder="Nomor Telepon"
                                class="w-full px-4 py-4 lily-pink text-white placeholder-white rounded-full font-medium text-center focus:outline-none focus:ring-2 focus:ring-lily-pink-dark transition duration-300"
                                required
                            >
                            @error('contact')
                                <p class="text-red-500 text-sm mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Send OTP Button -->
                        <div class="mb-6">
                            <button 
                                type="submit"
                                class="w-full px-4 py-4 lily-pink-bg text-white rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                            >
                                Kirim OTP
                            </button>
                        </div>
                    </form>

                    <!-- Back Button -->
                    <div class="text-center">
                        <button 
                            onclick="goToStep(1)"
                            class="text-gray-600 hover:text-lily-pink-dark text-sm"
                        >
                            ← Kembali
                        </button>
                    </div>
                </div>

                <!-- Step 3: Verify OTP -->
                <div id="step3" class="step-container hidden">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                        <p class="text-gray-600">Input OTP</p>
                    </div>

                    <form id="verifyOtpForm" method="POST" action="">
                        @csrf
                        
                        <!-- OTP Input -->
                        <div class="mb-6">
                            <input 
                                type="text" 
                                name="otp_code"
                                placeholder="Kode OTP"
                                class="w-full px-4 py-4 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300 text-center"
                                maxlength="6"
                                required
                            >
                            @error('otp_code')
                                <p class="text-red-500 text-sm mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Verify Button -->
                        <div class="mb-6">
                            <button 
                                type="submit"
                                class="w-full px-4 py-4 lily-pink-bg text-white rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                            >
                                Kirim
                            </button>
                        </div>
                    </form>

                    <!-- Resend OTP -->
                    <div class="text-center mb-4">
                        <button 
                            onclick="resendOtp()"
                            class="text-gray-600 hover:text-lily-pink-dark text-sm"
                        >
                            Kirim ulang OTP
                        </button>
                    </div>

                    <!-- Back Button -->
                    <div class="text-center">
                        <button 
                            onclick="goToStep(2)"
                            class="text-gray-600 hover:text-lily-pink-dark text-sm"
                        >
                            ← Kembali
                        </button>
                    </div>
                </div>

                <!-- Step 4: Complete Registration -->
                <div id="step4" class="step-container hidden">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Complete Registration</h2>
                        <p class="text-gray-600">Fill in your details</p>
                    </div>

                    <form method="POST" action="">
                        @csrf
                        
                        <!-- Full Name -->
                        <div class="mb-4">
                            <input 
                                type="text" 
                                name="name" 
                                placeholder="Full Name"
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="Password"
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                                required
                            >
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                placeholder="Confirm Password"
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                                required
                            >
                        </div>

                        <!-- Register Button -->
                        <button 
                            type="submit"
                            class="w-full lily-pink-bg text-white py-3 rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                        >
                            Complete Registration
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script>
        function selectOtpMethod(method) {
            document.getElementById('otp_method').value = method;
            document.getElementById('selected_method').value = method;
            
            if (method === 'phone') {
                document.getElementById('step2-subtitle').textContent = 'Kirim OTP dengan :';
                document.getElementById('contact_input').placeholder = 'Nomor Telepon';
                document.getElementById('contact_input').type = 'tel';
            } else {
                document.getElementById('step2-subtitle').textContent = 'Kirim OTP dengan :';
                document.getElementById('contact_input').placeholder = 'Email';
                document.getElementById('contact_input').type = 'email';
            }
            
            goToStep(2);
        }

        function goToStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-container').forEach(container => {
                container.classList.add('hidden');
            });
            
            // Show target step
            document.getElementById('step' + step).classList.remove('hidden');
        }

        function resendOtp() {
            // Submit the send OTP form again
            document.getElementById('sendOtpForm').submit();
        }

        // Check if there are session variables to determine which step to show
        @if(session('otp_sent'))
            document.addEventListener('DOMContentLoaded', function() {
                goToStep(3);
            });
        @endif

        @if(session('otp_verified'))
            document.addEventListener('DOMContentLoaded', function() {
                goToStep(4);
            });
        @endif

        // Handle form submissions
        document.getElementById('sendOtpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate OTP sending (replace with actual AJAX call)
            setTimeout(() => {
                goToStep(3);
            }, 1000);
        });

        document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate OTP verification (replace with actual AJAX call)
            const otpCode = document.querySelector('input[name="otp_code"]').value;
            if (otpCode.length === 6) {
                setTimeout(() => {
                    goToStep(4);
                }, 1000);
            } else {
                alert('Please enter a valid 6-digit OTP');
            }
        });
    </script>

</body>
</html>