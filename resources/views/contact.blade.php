<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Contact</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    @include('layouts.header')

    <!-- Contact Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-16 bg-white pt-40">
        <div class="container mx-auto flex flex-col md:flex-row gap-6">
            <!-- Contact Info -->
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


            <!-- Contact Form -->
            <div class="bg-white border border-gray-300 rounded-xl w-full md:w-2/3 p-8">
                <h2 class="text-5xl font-bold text-black text-center mb-8">Contact</h2>
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block font-medium mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full border rounded-md px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Nomor Telepon</label>
                        <input type="text" name="telepon" class="w-full border rounded-md px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" name="email" class="w-full border rounded-md px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Pesan</label>
                        <textarea name="pesan" rows="5" class="w-full border rounded-md px-4 py-2" required></textarea>
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
</body>
</html>
