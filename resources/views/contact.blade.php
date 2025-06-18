<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Contact</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="antialiased bg-white">

    @include('layouts.header')

    <section class="py-16 px-4 sm:px-6 lg:px-16 bg-white pt-40">
        <div class="container mx-auto flex flex-col md:flex-row gap-6">
            <div class="bg-[#D6929F] text-black w-full md:w-1/2 rounded-2xl shadow-xl p-12 flex flex-col justify-center items-center gap-14">
                <div class="flex flex-col items-center text-center">
                    <i class="fas fa-headset text-5xl mb-3"></i>
                    <p class="text-2xl">Hotline</p>
                    <p class="font-bold text-2xl">1500581</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <i class="fab fa-whatsapp text-5xl mb-3"></i>
                    <p class="text-2xl">Whatsapp</p>
                    <p class="font-bold text-2xl">+6282123456789</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <i class="fas fa-envelope text-5xl mb-3"></i>
                    <p class="text-2xl">Email</p>
                    <p class="font-bold text-2xl">info@lilybakery.id</p>
                </div>
            </div>

            <div class="bg-white border border-gray-300 rounded-xl w-full md:w-2/3 p-8">
                <h2 class="text-5xl font-bold text-black text-center mb-8">Contact</h2>
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="nama_lengkap" class="block font-medium mb-1">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="w-full border rounded-md px-4 py-2" required>
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nomor_telepon" class="block font-medium mb-1">Nomor Telepon</label>
                        <input type="text" id="nomor_telepon" name="nomor_telepon" class="w-full border rounded-md px-4 py-2" required>
                        @error('nomor_telepon')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block font-medium mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full border rounded-md px-4 py-2" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pesan" class="block font-medium mb-1">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="5" class="w-full border rounded-md px-4 py-2" required></textarea>
                        @error('pesan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-rose-300 hover:bg-rose-400 text-black font-semibold px-6 py-2 rounded-full">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script>
        // SweetAlert2 notifikasi
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
            });
        @endif
    </script>
</body>
</html>