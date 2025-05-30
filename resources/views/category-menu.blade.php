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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-20">
        <!-- Breadcrumb -->
        <nav class="flex justify-center items-center space-x-2 text-lg text-gray-500 mb-5">
            <a href="{{ url('/') }}" class="hover:text-gray-700">Home</a>
            <span>></span>
            <a href="{{ url('/category-menu') }}" class="hover:text-gray-700">Menu</a>
            <span>></span>
            <span class="text-gray-900 font-bold">{{ ucfirst($category) }}</span>
        </nav>

        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $header['title'] }}</h1>
            <p class="text-lg text-gray-600">{{ $header['subtitle'] }}</p>
        </div>


        <!-- Sort Dropdown -->
        <div class="flex justify-end mb-8">
            <div class="relative inline-block text-left">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Products</label>
                <div class="relative">
                    <select class="appearance-none w-full px-4 py-2 pr-10 border border-gray-300 rounded-xl bg-white text-gray-700 shadow-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition duration-200 ease-in-out hover:border-pink-400">
                        <option disabled selected>Sort By</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Name: A-Z</option>
                        <option>Popularity</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-pink-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>



        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
           @foreach ($products as $product)
                <a href="{{ route('product.detail', ['category' => $category, 'productName' => strtolower(str_replace(' ', '-', $product['name']))]) }}">
                    <div>
                        <div class="aspect-square bg-pink-50 rounded-t-lg flex items-center justify-center">
                            <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover rounded">
                        </div>
                        <div class="pt-2">
                            <h3 class="font-bold text-gray-900 mb-2">{{ $product['name'] }}</h3>
                            <p class="text-sm text-gray-600 mb-1">Starts From Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                            <div class="text-yellow-400 text-sm mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $product['rating'])
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>


    </main>

    @include('layouts.footer')

</body>
</html>
