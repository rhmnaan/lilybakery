<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product['name'] }} - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white text-gray-800">

    @include('layouts.header')

    <!-- Product Detail -->
    <section class="flex justify-center items-center min-h-screen pt-36 px-4">
        <div class="grid md:grid-cols-3 gap-12 max-w-7xl w-full">
            <!-- Image -->
            <div class="rounded-lg p-4">
                <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full rounded-lg object-cover">
            </div>
            <!-- Breadcrumb and Info -->
            <div class="container mx-auto px-4 mt-6 text-sm text-gray-600">
                <span><a href="{{ url('/menu') }}" class="hover:underline">Menu</a></span> &gt; 
                <span class="font-semibold capitalize">{{ $category }}</span>
                <h1 class="text-3xl font-bold mb-2">{{ $product['name'] }}</h1>
                <div class="flex items-center text-yellow-400 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($product['rating'] >= $i)
                            <i class="fas fa-star mr-1"></i>
                        @elseif ($product['rating'] > $i - 1)
                            <i class="fas fa-star-half-alt mr-1"></i>
                        @else
                            <i class="far fa-star mr-1"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-gray-700 mb-4 leading-relaxed text-justify">
                    {{ $product['description'] ?? 'Delicious product from our bakery.' }}
                </p>

                <div class="text-sm bg-lily-pink text-white inline-block px-3 py-1 rounded-full mb-4">
                    Stock : 70
                </div>

                <div class="text-2xl font-bold mb-6">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
            </div>
            <!-- Quantity & Order -->
            <div class="bg-gray-50 p-4 rounded-lg border shadow-sm max-w-sm self-start">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center border rounded-full overflow-hidden">
                        <button onclick="decrementQty()" class="text-xl text-gray-600 px-3 py-1">-</button>
                        <span id="quantity" class="px-4 py-1 border-l border-r border-gray-300">1</span>
                        <button onclick="incrementQty()" class="text-xl text-gray-600 px-3 py-1">+</button>
                    </div>
                    <div id="price-total" class="text-xl font-semibold">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </div>
                </div>
                <p class="text-red-500 text-sm mb-3">Pre-order</p>
                <button class="w-full bg-lily-pink hover:bg-lily-pink-dark text-white py-2 rounded-full mb-3 transition duration-300">
                    Add to Cart
                </button>
                <button class="w-full border border-lily-pink-dark text-lily-pink-dark hover:bg-lily-pink-dark hover:text-white py-2 rounded-full transition duration-300">
                    Buy Now
                </button>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script>
        let qty = 1;
        const qtyElement = document.getElementById('quantity');
        const priceTotalElement = document.getElementById('price-total');
        const unitPrice = {{ $product['price'] }};

        function updatePrice() {
            const total = qty * unitPrice;
            priceTotalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function incrementQty() {
            qty++;
            qtyElement.textContent = qty;
            updatePrice();
        }

        function decrementQty() {
            if (qty > 1) {
                qty--;
                qtyElement.textContent = qty;
                updatePrice();
            }
        }
    </script>

</body>
</html>