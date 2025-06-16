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
        
        <div class="h-[1000px] overflow-y-auto">
            @if(isset($promos) && $promos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($promos as $promoItem)
                        @php
                            // Ensure product exists before trying to access its properties
                            if (!$promoItem->produk) {
                                continue; // Skip this iteration if product is not found
                            }
                            $originalPrice = $promoItem->produk->harga;
                            $discountPercentage = $promoItem->diskon_persen;
                            $discountedPrice = $originalPrice * (1 - ($discountPercentage / 100));
                        @endphp
                        <div class="bg-[#F5F4F4] shadow-md overflow-hidden">
                            <div class="relative p-3">
                                <img src="{{ asset($promoItem->produk->gambar ? 'images/products/' . $promoItem->produk->gambar : '/images/previewcake.png') }}" alt="{{ $promoItem->produk->nama_produk ?? 'Product Image' }}" class="w-full h-50 object-cover">
                                @if($discountPercentage > 0)
                                <span class="absolute top-2 left-2 bg-pink-600 text-white text-xs px-2 py-1 rounded">{{ round($discountPercentage) }}% off</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-questrial text-gray-800 mb-1 truncate" title="{{ $promoItem->produk->nama_produk ?? 'Product Name' }}">{{ $promoItem->produk->nama_produk ?? 'Product Name' }}</h3>
                                <p class="font-questrial text-gray-600">
                                    From 
                                    <span class="text-lg text-gray-800">Rp {{ number_format($discountedPrice, 0, ',', '.') }}</span>
                                    @if($discountPercentage > 0)
                                    <span class="line-through text-gray-400 ml-1">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
                                    @endif
                                </p>
                                <div class="flex items-center mt-2 mb-4 text-yellow-400">
                                    {{-- Static stars for now, implement dynamic rating if needed --}}
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    {{-- You can add a (X reviews) text here --}}
                                </div>
                                <button class="relative w-full py-2 rounded-full text-black font-semibold overflow-hidden group bg-[#dceae2] opacity-100">
                                    <span class="font-questrial text-[16px] font-normal relative z-10 transition duration-300 group-hover:text-black">Add to cart</span>
                                    <span class="absolute inset-0 bg-[#C0CCC6] opacity-100 scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100"></span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 col-span-full">No active promotions at the moment. Check back soon!</p>
            @endif
        </div>
    </section>
    @include('layouts.wa')
    @include('layouts.footer')
</body>
</html>