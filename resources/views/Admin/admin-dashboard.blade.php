@extends('layouts.admin')

@section('content')
    {{-- Overall page background changed to a very light pink to match the design --}}
    <div class="bg-[#FFF1EA] min-h-screen font-sans p-8"> {{-- Added padding to the overall page background --}}
        {{-- Main container for the sidebar and content, acting as the "box" --}}
        {{-- Restoring the shadow to the original from your initial code, which was more subtle --}}
        <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden">
            {{-- Left Sidebar --}}
            <div class="w-64 bg-[#FFF7F3] pt-4">
                <div class="p-4">
                    {{-- Logo Section --}}
                    <div class="flex flex-col items-center justify-center bg-[#E59CAA] rounded-lg py-4 px-2 mb-6 shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Lily Bakery" class="max-w-full h-auto">
                    </div>
                </div>
                <nav class="mt-2 space-y-1">
                    {{-- Dashboard Link (Active State) --}}
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]
                    @if(Request::routeIs('admin.dashboard')) bg-[#F9D8D9] text-gray-900 font-semibold @endif">
                    {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Dashboard = Check Circle --}}
                        <i class="far fa-check-circle mr-3 text-xl"></i>
                        <span>Dashboard</span>
                    </a>

                    {{-- Product Link --}}
                    <a href="{{ route('admin.product') }}"
                        class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Product = Edit (Pensil) --}}
                        <i class="far fa-edit mr-3 text-xl"></i>
                        <span>Product</span>
                    </a>

                    {{-- Orders --}}
                    <a href="{{ route('admin.orders') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Orders = User (Profil) --}}
                        <i class="fas fa-shopping-bag mr-3 text-xl"></i> {{-- Changed icon to shopping-bag as it fits orders better --}}
                        <span>Orders</span>
                    </a>

                    {{-- Customers --}}
                    <a href="{{ route('admin.customers') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Customers = User (Profil) --}}
                        <i class="far fa-user mr-3 text-xl"></i>
                        <span>Customers</span>
                    </a>

                    {{-- Setting --}}
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        {{-- ICON TETAP SESUAI GAMBAR: Setting = Cog --}}
                        <i class="fas fa-cog mr-3 text-xl"></i>
                        <span>Setting</span>
                    </a>

                    {{-- Logout Button with Confirmation --}}
                    {{-- Logout Button with SweetAlert Confirmation --}}
                    <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" class="block w-full">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-6 py-3 rounded-md text-gray-700 hover:bg-red-100 hover:text-red-700">
                            <i class="fas fa-sign-out-alt mr-3 text-xl"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </div>

            {{-- Main Content Area (Dashboard) --}}
            <div class="flex-1 p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h1>

                {{-- Key Metrics Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {{-- Total Produk Card --}}
                    <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                        {{-- Ikon statistik juga disesuaikan lagi --}}
                        <i class="fas fa-box-open text-4xl text-[#E59CAA] mb-2"></i>
                        <p class="text-lg text-gray-600">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalProduk ?? 'N/A' }} <span class="text-xl font-normal">item</span></p>
                    </div>

                    {{-- Pesanan hari ini Card --}}
                    <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                        <i class="fas fa-shopping-cart text-4xl text-[#E59CAA] mb-2"></i>
                        <p class="text-lg text-gray-600">Pesanan hari ini</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPesananHariIni ?? 'N/A' }} <span class="text-xl font-normal">pesanan</span></p>
                    </div>

                    {{-- Pendapatan Hari Ini Card --}}
                    <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                        <i class="fas fa-wallet text-4xl text-[#E59CAA] mb-2"></i>
                        <p class="text-lg text-gray-600">Pendapatan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPendapatanHariIni ?? 0, 0, ',', '.') }}</p>
                    </div>

                    {{-- Pelanggan Terdaftar Card --}}
                    <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                        <i class="fas fa-user-friends text-4xl text-[#E59CAA] mb-2"></i>
                        <p class="text-lg text-gray-600">Pelanggan Terdaftar</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPelanggan ?? 'N/A' }} <span class="text-xl font-normal">pelanggan</span></p>
                    </div>
                </div>

                {{-- Penjualan Mingguan Chart (Using the Chart.js implementation) --}}
                <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Penjualan Mingguan</h2>
                    <div class="h-64">
                        <canvas id="weeklySalesChart"></canvas>
                    </div>
                </div>

                {{-- Produk Terlaris Section (Using the improved table structure) --}}
                <div class="bg-[#FFF7F3] rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Produk Terlaris</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-[#FFF7F3] divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Produk Terlaris
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Terjual
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Perbulan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                {{-- Rows for product data --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Chocolate cake</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 230.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">1200</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 230.000.000</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Matcha Donut</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 15.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">1200</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 230.000.000</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Cheese Cake</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 250.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">1100</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 210.000.000</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Chocoberry Bread</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 45.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">900</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 190.000.000</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Blueberry Cake</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 120.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">700</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 140.000.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklySalesChart').getContext('2d');
            const weeklySalesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Penjualan',
                        data: [100, 200, 150, 180, 400, 100, 200],
                        borderColor: '#e879a0', // Warna garis pink
                        backgroundColor: 'rgba(232, 121, 160, 0.1)', // Warna area bawah garis (transparan pink)
                        borderWidth: 2,
                        tension: 0.2, // Membuat garis sedikit melengkung
                        pointBackgroundColor: '#e879a0', // Warna titik data
                        pointBorderColor: '#ffffff', // Warna border titik data
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)' // Garis grid Y yang samar
                            }
                        },
                        x: {
                            grid: {
                                display: false // Menghilangkan garis grid X
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Menghilangkan legend
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // --- Konfirmasi Logout dengan SweetAlert2 ---
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah form disubmit secara default

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan keluar dari sesi admin ini!",
                        icon: 'warning', // Bisa 'success', 'error', 'info', 'question'
                        showCancelButton: true,
                        confirmButtonColor: '#e879a0', // Warna pink yang cocok dengan tema Anda
                        cancelButtonColor: '#6c757d', // Warna abu-abu untuk tombol batal
                        confirmButtonText: 'Ya, Logout!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika user mengklik 'Ya, Logout!', submit form
                            this.submit();
                        }
                    });
                });
            }
        });
    </script>
    @endpush
@endsection