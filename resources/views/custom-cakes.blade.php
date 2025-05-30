<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Custom Cakes</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">

    @include('layouts.header')

    <!-- Hero Banner -->
    <section class="relative overflow-hidden pt-36 px-4 sm:pl-20"> <!-- padding kiri versi mobile dikurangi -->
        <div class="container mx-auto">
            <h1 class="text-2xl text-center md:text-left">CUSTOM CAKES COLLECTION</h1>
        </div>
    </section>

    <!-- Custom Cakes Gallery -->
    <section class="py-4 bg-white px-2 sm:px-20 mb-10"> <!-- padding horizontal responsif -->
        <div class="container mx-auto px-0">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6"> <!-- grid kolom & gap responsif -->
                @foreach($cakes as $cake)
                <div class="aspect-square max-w-xs mx-auto overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ asset('images/custom-cakes/' . $cake['image']) }}" alt="{{ $cake['title'] }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('layouts.footer')

</body>
</html>
