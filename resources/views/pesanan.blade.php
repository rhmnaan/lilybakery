<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Pesanan Saya</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .rating-input > input { display: none; }
        .rating-input > label {
            cursor: pointer;
            color: #d1d5db;
            transition: color 0.2s;
        }
        .rating-input > input:checked ~ label,
        .rating-input > label:hover,
        .rating-input > label:hover ~ label { color: #f59e0b; }
    </style>
</head>
<body class="antialiased bg-white font-inter">

    @include('layouts.header')

    @auth('pelanggan')
    <section class="flex gap-36 pt-10 px-10 mt-28 ml-9">
        <h1 class="text-3xl mb-4 font-bold">Hi, <span>{{ Str::limit(Auth::guard('pelanggan')->user()->nama_pelanggan, 12) }}</span></h1>
    </section>

    <div class="px-6 pb-10 lg:flex gap-10 ml-10 mr-20">
        <div class="w-full lg:w-1/5 mb-8 lg:mb-0">
            <div class="border rounded-lg overflow-hidden text-sm">
                <a href="{{ url('profil-pelanggan') }}" class="block py-3 px-4 hover:bg-gray-100 border-b">Account</a>
                <a href="{{ route('pesanan.index') }}" class="block w-full text-left py-3 px-4 bg-[#D6A1A1] text-black font-semibold border-b">Pesanan</a>
                <form method="POST" action="{{ route('pelanggan.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-3 px-4 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>

        <div class="w-full lg:w-4/5">
            <h2 class="text-2xl font-bold mb-4 uppercase">PESANAN ANDA - {{ $currentStatusView }}</h2>
            <section>
                <div class="flex flex-wrap space-x-1 sm:space-x-4 border-b mb-6">
                    @php
                        $tabs = [
                            'semua' => 'Semua',
                            'belum_bayar' => 'Belum Bayar',
                            'diproses' => 'Diproses',
                            'dikirim' => 'Dikirim',
                            'selesai' => 'Selesai',
                            'dibatalkan' => 'Dibatalkan'
                        ];
                    @endphp
                    @foreach($tabs as $status => $label)
                        <a href="{{ route('pesanan.index', ['status' => $status]) }}"
                           class="px-4 py-2 rounded-t-lg text-sm sm:text-base font-medium
                                  {{ $currentStatusFilter === $status ? 'bg-lily-pink-dark text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <div class="space-y-6">
                    @forelse ($orders as $order)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <div class="flex justify-between items-center border-b pb-3 mb-3">
                                <div>
                                    <p class="font-bold text-gray-800">Order ID: #LILY-{{ $order->id_order }}</p>
                                    <p class="text-sm text-gray-500">Tanggal: {{ \Carbon\Carbon::parse($order->tanggal_order)->isoFormat('DD MMMM YYYY, HH:mm') }}</p>
                                </div>
                                @php
                                    $displayStatus = $order->display_status_override ?? $order->status;
                                    $statusColor = match ($displayStatus) {
                                        'Diproses' => 'bg-blue-100 text-blue-800',
                                        'Dikirim' => 'bg-indigo-100 text-indigo-800',
                                        'Selesai' => 'bg-green-100 text-green-800',
                                        'Dibatalkan' => 'bg-red-100 text-red-800',
                                        'Belum Dibayar' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                    {{ $displayStatus }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                @foreach($order->detailOrder as $detail)
                                    @if($detail->produk)
                                    <div class="flex items-start gap-4">
                                        <img src="{{ $detail->produk->gambar ? asset('images/products/' . $detail->produk->gambar) : asset('images/previewcake.png') }}" alt="{{ $detail->produk->nama_produk }}" class="w-16 h-16 object-cover rounded-md">
                                        <div class="flex-grow">
                                            <p class="font-semibold text-gray-700">{{ $detail->produk->nama_produk }}</p>
                                            <p class="text-sm text-gray-500">{{ $detail->jumlah }} x Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</p>
                                            
                                            @php
                                                $isSelesai = ($order->display_status_override ?? $order->status) === 'Selesai';
                                                $sudahReview = !$detail->produk->ulasan->isEmpty();
                                            @endphp

                                            @if($isSelesai)
                                                @if($sudahReview)
                                                    <div class="mt-2 flex items-center gap-1.5 text-sm text-green-600 font-medium">
                                                        <i class="fas fa-check-circle"></i>
                                                        <span>Rating diberikan</span>
                                                    </div>
                                                @else
                                                    <button 
                                                       onclick="openRatingModal('{{ $detail->produk->kode_produk }}', '{{ $detail->produk->nama_produk }}')"
                                                       class="mt-2 inline-block bg-yellow-500 text-white text-xs font-bold py-1.5 px-3 rounded-full hover:bg-yellow-600 transition duration-200">
                                                        Beri Rating
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                        <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="border-t mt-4 pt-3 text-right">
                                <p class="text-sm text-gray-600">Ongkir: <span class="font-medium">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span></p>
                                <p class="text-lg font-bold text-gray-900">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 text-gray-500 border rounded-lg bg-gray-50">
                            <i class="fas fa-box-open text-4xl mb-3"></i>
                            <p class="text-xl">Tidak ada pesanan dalam kategori ini.</p>
                        </div>
                    @endforelse
                </div>

                 <div class="mt-8">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </section>
        </div>
    </div>
    @endauth

    @include('layouts.footer')

    <div id="ratingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
            <button onclick="closeRatingModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Beri Rating</h3>
            <p id="modalProductName" class="text-center text-gray-500 mb-6"></p>

            <form id="ratingForm" action="{{ route('ulasan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kode_produk" id="modalKodeProduk">
                <div class="mb-6">
                    <div class="rating-input flex flex-row-reverse justify-center text-4xl">
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 stars">★</label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars">★</label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars">★</label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars">★</label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">★</label>
                    </div>
                </div>
                <button type="submit" class="w-full bg-lily-pink-dark text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition duration-300">
                    Kirim Rating
                </button>
            </form>
        </div>
    </div>

    <script>
        const ratingModal = document.getElementById('ratingModal');
        const modalProductName = document.getElementById('modalProductName');
        const modalKodeProduk = document.getElementById('modalKodeProduk');
        const ratingForm = document.getElementById('ratingForm');

        function openRatingModal(kodeProduk, namaProduk) {
            modalProductName.textContent = namaProduk;
            modalKodeProduk.value = kodeProduk;
            ratingModal.classList.remove('hidden');
            ratingModal.classList.add('flex');
        }

        function closeRatingModal() {
            ratingModal.classList.add('hidden');
            ratingModal.classList.remove('flex');
            ratingForm.reset();
        }
    </script>
</body>
</html>