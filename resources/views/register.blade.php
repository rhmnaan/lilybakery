<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register - Lily Bakery</title>
@vite('resources/css/app.css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
  /* Label default tetap left-4 (1rem) */
  label {
    left: 1rem;
  }

  /* Saat input focus atau tidak kosong (floating), pindahkan label ke kiri */
  input:focus + label,
  input:not(:placeholder-shown) + label,
  textarea:focus + label,
  textarea:not(:placeholder-shown) + label {
    left: 0.25rem !important; /* Pindah ke kiri */
    top: -1.25rem !important; /* Naik ke atas */
    font-size: 0.75rem !important;
    color: #e879a0 !important;
  }
</style>
</head>
<body class="antialiased min-h-screen flex flex-col font-inter bg-white">

@include('layouts.header')

<section class="flex-1 flex items-center justify-center py-12 px-6 sm:px-4 pt-36">
  <div class="w-full max-w-md sm:max-w-lg">
    <div class="bg-[#EDF3F7] rounded-2xl shadow-lg p-8 sm:p-12">
      <div class="text-center mb-8 px-2 sm:px-0">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2 sm:mb-4">Register</h2>
        <p class="text-gray-600 text-sm sm:text-base">Mohon isi semua data yang diminta untuk menyelesaikan pendaftaran.</p>
      </div>

      <form method="POST" action="">
        @csrf

        <!-- Name -->
        <div class="mb-5 relative">
          <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name') }}"
            required
            placeholder=" "
            class="peer block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 placeholder-transparent focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition"
          />
          <label
            for="name"
            class="absolute left-4 top-3 text-gray-400 text-base transition-all
                   peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400
                   peer-focus:-top-5 peer-focus:text-sm peer-focus:text-[#e879a0] cursor-text"
          >
            Nama :
          </label>
          @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div class="mb-5 relative">
          <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email') }}"
            required
            placeholder=" "
            class="peer block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 placeholder-transparent focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition"
          />
          <label
            for="email"
            class="absolute left-4 top-3 text-gray-400 text-base transition-all
                   peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400
                   peer-focus:-top-5 peer-focus:text-sm peer-focus:text-[#e879a0] cursor-text"
          >
            Email :
          </label>
          @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div class="mb-5 relative">
        <input
            type="password"
            name="password"
            id="password"
            required
            placeholder=" "
            class="peer block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 placeholder-transparent focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition pr-12"
        />
        <label
            for="password"
            class="absolute left-4 top-3 text-gray-400 text-base transition-all
                peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400
                peer-focus:-top-5 peer-focus:text-sm peer-focus:text-[#e879a0] cursor-text"
        >
            Password :
        </label>

        <!-- Toggle Password Icon -->
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


        <!-- Phone -->
        <div class="mb-5 relative">
          <input
            type="tel"
            name="phone"
            id="phone"
            value="{{ old('phone') }}"
            required
            placeholder=" "
            class="peer block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 placeholder-transparent focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition"
          />
          <label
            for="phone"
            class="absolute left-4 top-3 text-gray-400 text-base transition-all
                   peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400
                   peer-focus:-top-5 peer-focus:text-sm peer-focus:text-[#e879a0] cursor-text"
          >
            Telepon :
          </label>
          @error('phone')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Address -->
        <div class="mb-5 relative">
          <textarea
            name="address"
            id="address"
            rows="3"
            required
            placeholder=" "
            class="peer block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 placeholder-transparent resize-none focus:ring-2 focus:ring-[#e879a0] focus:outline-none transition"
          >{{ old('address') }}</textarea>
          <label
            for="address"
            class="absolute left-4 top-3 text-gray-400 text-base transition-all
                   peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400
                   peer-focus:-top-5 peer-focus:text-sm peer-focus:text-[#e879a0] cursor-text"
          >
            Alamat :
          </label>
          @error('address')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Gender -->
        <div class="mb-8 px-1 sm:px-0">
          <p class="text-gray-600 mb-3 font-medium">Jenis Kelamin :</p>
          <div class="flex flex-col sm:flex-row sm:space-x-12 pl-1 -ml-5 sm:-ml-0 space-y-4 sm:space-y-0">
            <label class="flex items-center cursor-pointer relative pl-8">
              <input
                type="radio"
                name="gender"
                value="male"
                required
                class="peer absolute left-0 top-1/2 -translate-y-1/2 w-5 h-5 opacity-0 cursor-pointer"
                {{ old('gender') == 'male' ? 'checked' : '' }}
              />
              <span
                class="w-5 h-5 rounded-full border-2 border-[#E59CAA] flex items-center justify-center
                       shadow-[0_0_8px_rgba(229,156,170,0.4)]
                       before:content-[''] before:w-3 before:h-3 before:rounded-full before:bg-[#E59CAA]
                       before:scale-0 peer-checked:before:scale-100
                       before:transition-transform before:duration-300 before:ease-out"
              ></span>
              <span class="ml-3 text-gray-700 select-none">Laki-Laki</span>
            </label>

            <label class="flex items-center cursor-pointer relative pl-8">
              <input
                type="radio"
                name="gender"
                value="female"
                required
                class="peer absolute left-0 top-1/2 -translate-y-1/2 w-5 h-5 opacity-0 cursor-pointer"
                {{ old('gender') == 'female' ? 'checked' : '' }}
              />
              <span
                class="w-5 h-5 rounded-full border-2 border-[#E59CAA] flex items-center justify-center
                       shadow-[0_0_8px_rgba(229,156,170,0.4)]
                       before:content-[''] before:w-3 before:h-3 before:rounded-full before:bg-[#E59CAA]
                       before:scale-0 peer-checked:before:scale-100
                       before:transition-transform before:duration-300 before:ease-out"
              ></span>
              <span class="ml-3 text-gray-700 select-none">Wanita</span>
            </label>
          </div>
          @error('gender')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Register Button -->
        <button
          type="submit"
          class="w-full bg-[#E59CAA] hover:bg-[#d7688f] text-white py-3 rounded-full font-semibold transition duration-300 shadow-md"
        >
          Register
        </button>
      </form>

      <div class="text-center mt-6 px-2 sm:px-0">
        <p class="text-gray-600 text-sm sm:text-base">
          Do you have account?
          <a href="" class="text-[#e879a0] hover:underline font-semibold">Login</a>
        </p>
      </div>
    </div>
  </div>
</section>

@include('layouts.footer')

</body>
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

</html>
