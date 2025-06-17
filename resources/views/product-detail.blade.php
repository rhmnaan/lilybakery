<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} - Lily Bakery</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white text-gray-800 font-poppins">

    @include('layouts.header')

    {{-- Notifikasi untuk pesan sukses/error --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            class="fixed top-28 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg z-50"
            x-transition:enter="transform ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full">
            <p>{{ session('success') }}</p>
        </div>
    @elseif (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            class="fixed top-28 right-5 bg-red-500 text-white py-2 px-4 rounded-lg shadow-lg z-50"
            x-transition:enter="transform ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-40">
        <div class="grid md:grid-cols-3 gap-12 lg:gap-16 items-start">

            {{-- Kolom 1: Gambar Produk --}}
            <div class="w-full md:col-span-1">
                <div class="bg-pink-50 rounded-lg p-4 shadow-sm">
                    <img src="{{ $produk->gambar ? asset('images/products/' . $produk->gambar) : asset('images/placeholder.png') }}"
                        alt="{{ $produk->nama_produk }}" class="w-full h-auto aspect-square object-cover rounded-lg">
                </div>
            </div>

            {{-- Kolom 2: Informasi Produk --}}
            <div class="w-full md:col-span-1 space-y-4">
                <p class="text-sm text-gray-500">
                    Menu &gt; <span
                        class="font-semibold capitalize">{{ $produk->kategori->nama_kategori ?? 'Kategori' }}</span>
                </p>
                <h1 class="text-4xl font-bold text-gray-900">{{ $produk->nama_produk }}</h1>
                <div class="flex items-center">
                    @php $rating = round($averageRating ?? 0); @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star text-yellow-400"></i>
                    @endfor
                </div>
                <p class="text-gray-600 leading-relaxed pb-2">
                    {{ $produk->deskripsi ?? 'Deskripsi untuk produk ini belum tersedia.' }}
                </p>
                <div class="text-sm bg-pink-100 text-pink-800 font-semibold inline-block px-3 py-1 rounded-full">
                    Stok : {{ $produk->stok }}
                </div>
                <p class="text-3xl font-bold text-gray-900 pt-2">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>
            </div>

            {{-- Kolom 3: Aksi (Pemesanan) --}}
            <div class="w-full md:col-span-1">
                {{-- [MODIFIKASI] Tampilkan blok yang berbeda berdasarkan kategori --}}
                {{-- TAMPILAN NORMAL UNTUK PRODUK LAIN --}}
                <div class="bg-gray-50 p-6 rounded-lg border shadow-sm space-y-5">

                    {{-- TAMPILAN KHUSUS JIKA KATEGORI ADALAH CUSTOM CAKE --}}
                    @if (Str::lower($produk->kategori->nama_kategori ?? '') === 'custom cake')
                        <div class="text-center space-y-4">
                            <h3 class="text-xl font-semibold text-gray-800">Pemesanan Khusus</h3>
                            <p class="text-gray-600 text-sm">
                                Untuk kue kustom, silakan hubungi kami melalui WhatsApp untuk konsultasi desain.
                            </p>
                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20untuk%20memesan%20custom%20cake%20'{{ urlencode($produk->nama_produk) }}'"
                                target="_blank"
                                class="w-full inline-block bg-green-500 hover:bg-green-600 text-white py-3 rounded-full transition duration-300 font-semibold">
                                <i class="fab fa-whatsapp mr-2"></i> Hubungi untuk Pesan
                            </a>
                        </div>
                    @endif

                    {{-- TETAP TAMPILKAN QUANTITY DAN TOMBOL PEMBELIAN --}}
                    <div class="flex items-center justify-between pt-4">
                        <div class="flex items-center border rounded-full overflow-hidden">
                            <button type="button" onclick="updateQty(-1)"
                                class="text-xl text-gray-600 px-4 py-2 hover:bg-gray-100">-</button>
                            <span id="quantity_display" class="w-12 text-center font-semibold border-x">1</span>
                            <button type="button" onclick="updateQty(1)"
                                class="text-xl text-gray-600 px-4 py-2 hover:bg-gray-100">+</button>
                        </div>
                        <div id="price-total" class="text-xl font-bold">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="flex flex-col space-y-3 pt-4">
                        @auth('pelanggan')
                            {{-- Jika pelanggan sudah login --}}
                            <form action="{{ route('keranjang.tambah') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kode_produk" value="{{ $produk->kode_produk }}">
                                <input type="hidden" name="jumlah" id="add_to_cart_quantity_input" value="1">
                                <button type="submit"
                                    class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-full transition duration-300 font-semibold">
                                    Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('order.buyNow') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kode_produk" value="{{ $produk->kode_produk }}">
                                <input type="hidden" name="jumlah" id="buy_now_quantity_input" value="1">
                                <button type="submit"
                                    class="w-full bg-lily-pink hover:bg-lily-pink-dark text-white py-3 rounded-full transition duration-300 font-semibold">
                                    Buy Now
                                </button>
                            </form>
                        @else
                            {{-- Jika belum login --}}
                            <button onclick="return checkLogin(false)"
                                class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-full transition duration-300 font-semibold">
                                Add to Cart
                            </button>

                            <button onclick="return checkLogin(false)"
                                class="w-full bg-lily-pink hover:bg-lily-pink-dark text-white py-3 rounded-full transition duration-300 font-semibold">
                                Buy Now
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    {{-- Script hanya akan dimuat jika produk BUKAN custom cake --}}
    @if (!isset($is_custom_cake) || !$is_custom_cake)
        <script>
            const unitPrice = {{ $produk->harga }};
            const maxStock = {{ $produk->stok }};
            const qtyDisplay = document.getElementById('quantity_display');
            const addToCartQtyInput = document.getElementById('add_to_cart_quantity_input');
            const buyNowQtyInput = document.getElementById('buy_now_quantity_input');
            const priceTotalElement = document.getElementById('price-total');

            function updateQty(change) {
                let currentQty = parseInt(addToCartQtyInput.value);
                let newQty = currentQty + change;

                if (newQty < 1) newQty = 1;
                if (newQty > maxStock) {
                    newQty = maxStock;
                    alert('Kuantitas melebihi stok yang tersedia!');
                }

                qtyDisplay.textContent = newQty;
                addToCartQtyInput.value = newQty;
                buyNowQtyInput.value = newQty;

                const total = newQty * unitPrice;
                priceTotalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        </script>
    @endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function checkLogin(isLoggedIn) {
        if (!isLoggedIn) {
            Swal.fire({
                icon: 'warning',
                title: 'Login Diperlukan',
                text: 'Silakan login terlebih dahulu untuk melakukan tindakan ini.',
                confirmButtonText: 'Login Sekarang'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('pelanggan.login.form') }}";
                }
            });
            return false;
        }
        return true;
    }
</script>


</body>

</html>