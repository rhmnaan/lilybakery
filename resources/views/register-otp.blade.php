<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-gray-100 min-h-screen">
    
    @include('layouts.header')

    <!-- Register Section -->
    <section class="flex-1 flex items-center justify-center py-12 px-4 pt-36">
        <div class="w-full max-w-md">
            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                
                <!-- Step 1 -->
                <div id="step1" class="step-container">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                        <p class="text-gray-600">Kirim OTP dengan :</p>
                    </div>

                    <form id="chooseOtpForm" method="POST" action="">
                        @csrf
                        <div class="mb-6">
                            <button 
                                type="button"
                                onclick="selectOtpMethod('email')"
                                class="w-full px-4 py-4 bg-[#E59CAA] text-white rounded-full font-medium hover:bg-[#e879a0] transition duration-300 shadow-md"
                            >
                                Email
                            </button>
                        </div>
                        <input type="hidden" id="otp_method" name="otp_method" value="">
                    </form>

                    <div class="text-center">
                        <p class="text-gray-600">
                            Already have account? 
                            <a href="" class="text-[#e879a0] hover:underline font-medium">Login</a>
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div id="step2" class="step-container hidden">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                        <p class="text-gray-600" id="step2-subtitle">Kirim OTP dengan :</p>
                    </div>

                    <form id="sendOtpForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="otp_method" id="selected_method" value="">
                        <div class="mb-6">
                            <input 
                            type="text" 
                            name="contact" 
                            id="contact_input"
                            placeholder="Masukkan Kode OTP"
                            class="w-full px-4 py-4 bg-white text-black placeholder-gray-500 rounded-full font-medium text-center border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#e879a0] transition duration-300"
                            required
                            >

                            @error('contact')
                                <p class="text-red-500 text-sm mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <button 
                                type="submit"
                                class="w-full px-4 py-4 bg-[#e879a0] text-white rounded-full font-medium hover:bg-[#d96b8f] transition duration-300 shadow-md"
                            >
                                Kirim OTP
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <button 
                            onclick="goToStep(1)"
                            class="text-gray-600 hover:text-[#e879a0] text-sm"
                        >
                            ← Kembali
                        </button>
                    </div>
                </div>

                <!-- Step 3 -->
                <div id="step3" class="step-container hidden">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                        <p class="text-gray-600">Input OTP</p>
                    </div>

                    <form id="verifyOtpForm" method="POST" action="">
                        @csrf
                        <div class="mb-6">
                            <input 
                                type="text" 
                                name="otp_code"
                                placeholder="Kode OTP"
                                class="w-full px-4 py-4 bg-white text-black placeholder-gray-500 rounded-full font-medium text-center border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#e879a0] transition duration-300"
                                maxlength="6"
                                required
                            >

                            @error('otp_code')
                                <p class="text-red-500 text-sm mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <button 
                                type="submit"
                                class="w-full px-4 py-4 bg-[#e879a0] text-white rounded-full font-medium hover:bg-[#d96b8f] transition duration-300 shadow-md"
                            >
                                Kirim
                            </button>
                        </div>
                    </form>

                    <div class="text-center mb-4">
                        <button 
                            onclick="resendOtp()"
                            class="text-gray-600 hover:text-[#e879a0] text-sm"
                        >
                            Kirim ulang OTP
                        </button>
                    </div>

                    <div class="text-center">
                        <button 
                            onclick="goToStep(2)"
                            class="text-gray-600 hover:text-[#e879a0] text-sm"
                        >
                            ← Kembali
                        </button>
                    </div>
                </div>

                <!-- Step 4 -->
                <div id="step4" class="step-container hidden">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Complete Registration</h2>
                        <p class="text-gray-600">Fill in your details</p>
                    </div>

                    <form method="POST" action="">
                        @csrf
                        <div class="mb-4">
                            <input 
                                type="text" 
                                name="name" 
                                placeholder="Full Name"
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition duration-300"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="Password"
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition duration-300"
                                required
                            >
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                placeholder="Confirm Password"
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition duration-300"
                                required
                            >
                        </div>
                        <button 
                            type="submit"
                            class="w-full bg-[#e879a0] text-white py-3 rounded-full font-medium hover:bg-[#d96b8f] transition duration-300 shadow-md"
                        >
                            Complete Registration
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    @include('layouts.footer')

    <!-- JavaScript -->
    <script>
       function selectOtpMethod(method) {
        document.getElementById('otp_method').value = method;
        document.getElementById('selected_method').value = method;

        const input = document.getElementById('contact_input');

        // Kosongkan input saat memilih ulang metode OTP
        input.value = '';

        // Ubah tipe input sesuai metode
        input.type = method === 'phone' ? 'tel' : 'email';

        // Ubah placeholder jadi "Masukkan Kode OTP"
        input.placeholder = 'Masukkan Kode OTP';

        // Bersihkan kelas yang konflik dulu
        input.classList.remove('bg-[#f8b4c4]', 'text-white', 'placeholder-white');

        // Tambahkan kelas baru untuk styling yang benar
        input.classList.add(
            'bg-white',
            'text-black',
            'placeholder-gray-500',
            'border',
            'border-gray-300'
        );

        goToStep(2);
    }



    function goToStep(step) {
        // Sembunyikan semua step
        document.querySelectorAll('.step-container').forEach(container => {
            container.classList.add('hidden');
        });
        
        // Tampilkan step yang dipilih
        document.getElementById('step' + step).classList.remove('hidden');
    }

    function resendOtp() {
        // Submit ulang form kirim OTP
        document.getElementById('sendOtpForm').submit();
    }

    // Jika session OTP sudah dikirim, langsung ke step 3
    @if(session('otp_sent'))
        document.addEventListener('DOMContentLoaded', function() {
            goToStep(3);
        });
    @endif

    // Jika session OTP sudah terverifikasi, langsung ke step 4
    @if(session('otp_verified'))
        document.addEventListener('DOMContentLoaded', function() {
            goToStep(4);
        });
    @endif

    // Submit form kirim OTP
    document.getElementById('sendOtpForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simulasi pengiriman OTP, ganti dengan AJAX jika perlu
        setTimeout(() => {
            goToStep(3);
        }, 1000);
    });

    // Submit form verifikasi OTP
    document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
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
