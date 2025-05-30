<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Akun Profil</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">

    @include('layouts.header')

    @auth('pelanggan')
    <section class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-10 px-6 sm:px-10 mt-24 ml-0 sm:ml-9">
        <h1 class="text-2xl sm:text-3xl mb-4 font-inter font-bold">Hi, <span>{{ Str::limit(Auth::guard('pelanggan')->user()->nama_pelanggan, 12) }}</span></h1>
        <div id="profile-form-alert" class="w-full sm:w-auto">
            {{-- Alert will be injected here by JS --}}
        </div>
    </section>

    <div class="px-6 pb-10 lg:flex gap-10 ml-0 sm:ml-10 mr-0 sm:mr-20">
        <div class="w-full lg:w-1/5 mb-5 lg:mb-0">
            <div class="border rounded-lg overflow-hidden font-inter text-sm" id="sidebar-menu">
                <button data-section="account" class="sidebar-btn block w-full text-left py-3 px-4 bg-[#D6A1A1] text-black font-semibold border-b">Account</button>
                <a href="{{ url('pesanan') }}" class="block py-3 px-4 hover:bg-gray-100 border-b">Pesanan</a>
                {{-- Make sure your pelanggan.logout route is correctly defined and uses POST --}}
                <form method="POST" action="{{ route('pelanggan.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-3 px-4 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>

        <div class="w-full lg:w-4/5 space-y-6">
            <h2 class="text-lg font-bold mb-2">EDIT PROFILE</h2>
            <section class ="border border-lily-pink rounded-lg p-6">
                @if(session('successProfile'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('successProfile') }}</span>
                    </div>
                @endif
                @if ($errors->any() && old('form_type') === 'profile')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('pelanggan.profile.updateProfile') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="form_type" value="profile"> {{-- For error differentiation --}}
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-9">
                        <label for="nama" class="block text-base font-medium text-gray-700 sm:pt-4 w-full sm:w-auto mb-1 sm:mb-0">Nama</label>
                        <input type="text" name="nama" id="nama" class="w-full border border-lily-pink rounded-xl px-3 py-2" value="{{ old('nama', Auth::guard('pelanggan')->user()->nama_pelanggan) }}">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-6">
                        <label for="alamat" class="block text-base font-medium text-gray-700 sm:pt-4 w-full sm:w-auto mb-1 sm:mb-0">Alamat</label>
                        <textarea name="alamat" id="alamat" class="w-full border border-lily-pink rounded-xl px-3 py-2" rows="3">{{ old('alamat', Auth::guard('pelanggan')->user()->alamat) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-10 pb-4 sm:pl-10">
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', Auth::guard('pelanggan')->user()->jenis_kelamin) === 'Laki-laki' ? 'checked' : '' }} class="mr-2 form-radio text-lily-pink-dark focus:ring-lily-pink-dark"> Laki-Laki
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', Auth::guard('pelanggan')->user()->jenis_kelamin) === 'Perempuan' ? 'checked' : '' }} class="mr-2 form-radio text-lily-pink-dark focus:ring-lily-pink-dark"> Perempuan
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="bg-[#D89CA2] text-white px-6 py-3 rounded hover:bg-[#c4868d] transition-colors">Save Changes</button>
                </form>
            </section>

            <h2 class="text-lg font-bold mb-2 mt-6">ACCOUNT INFO</h2>
            <section class="border border-lily-pink rounded-lg p-6">
                 @if(session('successAccountInfo'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('successAccountInfo') }}</span>
                    </div>
                @endif
                 @if ($errors->any() && old('form_type') === 'account_info')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                         <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('pelanggan.profile.updateAccountInfo') }}" method="POST" class="space-y-4">
                    @csrf
                     <input type="hidden" name="form_type" value="account_info">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <label for="telp" class="block text-base font-medium text-gray-700 sm:w-44 mb-1 sm:mb-0 sm:pt-4">Mobile Number</label>
                        <input type="text" name="telp" id="telp" class="w-full border border-lily-pink rounded-xl px-3 py-2" value="{{ old('telp', Auth::guard('pelanggan')->user()->telp) }}">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-[7.5rem]"> {{-- Adjusted gap for alignment --}}
                        <label for="email" class="block text-base font-medium text-gray-700 sm:pt-4 mb-1 sm:mb-0">Email</label>
                        <input type="email" name="email" id="email" class="w-full border border-lily-pink rounded-xl px-3 py-2" value="{{ old('email', Auth::guard('pelanggan')->user()->email) }}">
                    </div>
                    <button type="submit" class="bg-[#D89CA2] text-white px-6 py-2 rounded hover:bg-[#c4868d] transition-colors">Save Changes</button>
                </form>
            </section>

            <h2 class="text-lg font-bold mb-2 mt-6">CHANGE PASSWORD</h2>
            <section class="border border-lily-pink rounded-lg p-6">
                @if(session('successPassword'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('successPassword') }}</span>
                    </div>
                @endif
                @if ($errors->any() && old('form_type') === 'change_password')
                     <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                         <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('pelanggan.profile.changePassword') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="form_type" value="change_password">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-9">
                        <label for="old_password" class="block text-base font-medium text-gray-700 sm:w-48 mb-1 sm:mb-0">Old password</label>
                        <input type="password" name="old_password" id="old_password" class="w-full border border-lily-pink rounded-xl px-3 py-2">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-9">
                        <label for="new_password" class="block text-base font-medium text-gray-700 sm:w-48 mb-1 sm:mb-0">New password</label>
                        <input type="password" name="new_password" id="new_password" class="w-full border border-lily-pink rounded-xl px-3 py-2">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-9">
                        <label for="new_password_confirmation" class="block text-base font-medium text-gray-700 sm:w-48 mb-1 sm:mb-0">Confirm password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full border border-lily-pink rounded-xl px-3 py-2">
                    </div>
                    <button type="submit" class="bg-[#D89CA2] text-white px-6 py-2 rounded hover:bg-[#c4868d] transition-colors">Save Changes</button>
                </form>
            </section>
        </div>
    </div>
    @endauth

    @guest('pelanggan')
        <div class="text-center py-20">
            <p class="text-xl">Please <a href="{{-- {{ route('pelanggan.login') }} --}}" class="text-lily-pink-dark underline">login</a> to view your profile.</p>
            {{-- Make sure you have a login route named 'pelanggan.login' or adjust as needed --}}
        </div>
    @endguest


    @include('layouts.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarButtons = document.querySelectorAll('#sidebar-menu .sidebar-btn, #sidebar-menu a');

        sidebarButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                // If it's a button (not the logout form submit or a link to another page)
                if (this.tagName === 'BUTTON' && this.type !== 'submit') {
                    // Prevent default for non-submit buttons if they have any default action
                    event.preventDefault(); 
                    
                    sidebarButtons.forEach(btn => {
                        btn.classList.remove('bg-[#D6A1A1]', 'text-black', 'font-semibold');
                        if (btn.tagName === 'BUTTON') { // Only add hover back to buttons
                             btn.classList.add('hover:bg-gray-100');
                        }
                    });

                    this.classList.add('bg-[#D6A1A1]', 'text-black', 'font-semibold');
                    this.classList.remove('hover:bg-gray-100');
                }
                // For anchor tags that navigate, let them do so.
                // For the logout button, the form submission will handle it.
            });
        });

        // Make the "Account" button active by default if no other section is active
        // (This logic might need adjustment based on how you handle active sections on page load/navigation)
        const accountButton = document.querySelector('#sidebar-menu button[data-section="account"]');
        if (accountButton) {
             accountButton.classList.add('bg-[#D6A1A1]', 'text-black', 'font-semibold');
             accountButton.classList.remove('hover:bg-gray-100');
        }
        

        // Inject alert message
        const alertContainer = document.getElementById("profile-form-alert");
        // Check if the user's email is verified (this part is tricky without knowing your exact email verification setup)
        // For now, let's assume if the user is logged in, this message might be relevant.
        // You'd typically have a flag like `email_verified_at` on your Pelanggan model.
        @auth('pelanggan')
            @if(Auth::guard('pelanggan')->user() && !Auth::guard('pelanggan')->user()->email_verified_at) // Example check
                const alertHTML = `
                    <div class="bg-pink-100 border border-lily-pink text-xs sm:text-sm text-gray-600 p-2 sm:p-3 rounded-md mb-4 w-full">
                        <i class="fas fa-info-circle mr-2"></i>Complete your profile & verify your email to complete your registration.
                    </div>
                `;
                alertContainer.innerHTML = alertHTML;
            @endif
        @endauth
    });
    </script>

</body>
</html>