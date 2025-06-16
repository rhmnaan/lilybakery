<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - About Us</title>    
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')      
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    @include('layouts.header')
    <!-- About Section -->
    <section class="text-center py-10 px-6 mt-36">
        <h1 class="text-5xl mb-4 font-inter font-bold">About Us</h1>
        <p class=" font-inter font-medium text-gray-600 max-w-6xl mx-auto">
            Dibuat dengan cinta dan inspirasi dari pâtisserie Prancis, Lily Bakery menghadirkan kelezatan elegan dalam setiap gigitan.
            Temukan momen manis tak terlupakan bersama kami.
        </p>
    </section>

    <div>
            <img src="/images/bannerAbout.jpg" alt="Chocolate Cake" class="rounded-lg shadow-md mx-auto w-full md:w-11/12 bg-gray-200 h-[400px] object-cover mb-10">
    </div>

    <!-- Image + Description -->
    <section class="mx-auto px-6 md:px-12 pb-16" style="max-width: 1490px;">
        <div class="grid md:grid-cols-2 gap-10 items-start">
            <div>
                <p class="mb-4 text-justify font-inter text-gray-600">
                    Didirikan pada tahun 2025, Lily Bakery merupakan nama baru yang segar dan inspiratif di dunia pâtisserie bergaya Eropa di Indonesia.
                    Bermula dari toko pertama kami di Jakarta, kami berkomitmen untuk menghadirkan pastry yang elegan dan berkualitas tinggi dengan penuh cinta —
                    menyuguhkan pengalaman manis dan pelayanan hangat kepada setiap pelanggan.
                </p>
                <p class="text-justify font-inter text-gray-600">
                    Lily Bakery selalu menghadirkan janji konsisten akan kualitas premium, tampilan yang elegan, dan kemasan yang penuh perhatian —
                    semua dibuat dengan layanan hangat dan penuh kepedulian. Dengan semangat terhadap kreativitas dan inovasi,
                    kami terus mengeksplorasi dan mengembangkan kreasi pastry baru, memadukan seni dan cita rasa dalam setiap produk yang kami tawarkan.
                </p>
            </div>
            <img src="/images/lily.jpg" alt="Wheat Field" class="rounded-lg shadow-md bg-gray-200 h-[800px] w-full object-cover">
        </div>
    </section>
    @include('layouts.wa')
    @include('layouts.footer')
</body>
</html>