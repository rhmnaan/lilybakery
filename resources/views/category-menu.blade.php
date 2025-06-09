<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ ucfirst($category) }} - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body class="antialiased font-inter">

    @include('layouts.header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-20">
        <nav class="flex justify-center items-center space-x-2 text-lg text-gray-500 mb-5">
            <a href="{{ url('/') }}" class="hover:text-gray-700">Home</a>
            <span>></span>
            <span class="text-gray-900 font-bold">{{ ucfirst($category) }}</span>
        </nav>

        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $header['title'] }}</h1>
            <p class="text-lg text-gray-600">{{ $header['subtitle'] }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
           @forelse ($products as $product)
                {{-- Menggunakan nama rute 'produk.show' yang benar --}}
                <a href="{{ route('produk.show', ['produk' => $product->kode_produk]) }}" class="group">
                    <div>
                        <div class="aspect-square bg-pink-50 rounded-lg flex items-center justify-center overflow-hidden">
                            <img src="{{ $product->gambar ? asset('images/products/' . $product->gambar) : asset('images/placeholder.png') }}" 
                                 alt="{{ $product->nama_produk }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="pt-2">
                            {{-- Menggunakan sintaks object -> --}}
                            <h3 class="font-bold text-gray-900 mb-2">{{ $product->nama_produk }}</h3>
                            <p class="text-sm text-gray-600 mb-1">Starts From Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            <div class="text-yellow-400 text-sm mb-2">
                                @php
                                    $rating = round($product->ulasan_avg_rating ?? 0);
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500">Produk dalam kategori ini belum tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </main>

    @include('layouts.footer')

</body>
</html>