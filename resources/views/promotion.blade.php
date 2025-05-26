<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Promotion</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet" />
</head>
<body class="antialiased bg-white">

    @include('layouts.header')
    <section class="max-w-7xl mx-auto px-4 pt-40 pb-20">
        <h1 class="text-4xl text-center mb-12 font-outfit">PROMOTION</h1>
        
        <!-- Wrapper scrollable -->
        <div class="h-[1000px] overflow-y-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @for($i = 0; $i < 16; $i++)
                <div class="bg-[#F5F4F4] shadow-md overflow-hidden">
                    <div class="relative p-3">
                        <img src="/images/previewcake.png" alt="Product Image" class="w-full h-50 object-cover">
                        <span class="absolute top-2 left-2 bg-pink-600 text-white text-xs px-2 py-1 rounded">Up to 11% off</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-questrial text-gray-800 mb-1">Eid Raspberry Honey Cake</h3>
                        <p class=" font-questrial text-gray-600">
                            From <span class="text-lg text-gray-800">Rp 825.000</span>
                            <span class="line-through text-gray-400 ml-1">Rp 925.000</span>
                        </p>
                        <div class="flex items-center mt-2 mb-4">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <button class="relative w-full py-2 rounded-full text-black font-semibold overflow-hidden group bg-[#dceae2] opacity-100">
                            <span class="font-questrial text-[16px] font-normal relative z-10 transition duration-300 group-hover:text-black">Add to cart</span>
                            <span class="absolute inset-0 bg-[#C0CCC6] opacity-100 scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100"></span>
                        </button>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
    @include('layouts.footer')
</body>
</html>
