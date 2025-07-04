@extends('layouts.admin')

@section('content')
    {{-- Overall page background changed to a very light pink to match the design --}}
    <div class="bg-[#FFF1EA] min-h-screen font-sans p-8"> {{-- Added padding to the overall page background --}}
        {{-- Main container for the sidebar and content, acting as the "box" --}}
        {{-- Restoring the shadow to the original from your initial code, which was more subtle --}}
        <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden">

            @include('Admin.layouts.sidebar')

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
                        <p class="text-3xl font-bold text-gray-900">{{ $totalProduk ?? 'N/A' }} <span
                                class="text-xl font-normal">item</span></p>
                    </div>

                    {{-- Pesanan hari ini Card --}}
                    <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                        <i class="fas fa-shopping-cart text-4xl text-[#E59CAA] mb-2"></i>
                        <p class="text-lg text-gray-600">Pesanan hari ini</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPesananHariIni ?? 'N/A' }} <span
                                class="text-xl font-normal">pesanan</span></p>
                    </div>

                    {{-- Pendapatan Hari Ini Card --}}
                    <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                        <i class="fas fa-wallet text-4xl text-[#E59CAA] mb-2"></i>
                        <p class="text-lg text-gray-600">Pendapatan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900">Rp
                            {{ number_format($totalPendapatanHariIni ?? 0, 0, ',', '.') }}</p>
                    </div>

                    {{-- Pelanggan Terdaftar Card --}}
                    <div class="bg-[#FFF7F3] rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                        <i class="fas fa-user-friends text-4xl text-[#E59CAA] mb-2"></i>
                        <p class="text-lg text-gray-600">Pelanggan Terdaftar</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPelanggan ?? 'N/A' }} <span
                                class="text-xl font-normal">pelanggan</span></p>
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
                                <?php if (isset($produkTerlaris) && $produkTerlaris->count() > 0): ?>
                                    <?php $__currentLoopData = $produkTerlaris; $__env->addLoop($__currentLoopData); foreach ($__currentLoopData as $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?php echo e($produk->nama_produk); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                Rp<?php echo e(number_format($produk->harga, 0, ',', '.')); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <?php echo e($produk->total_terjual); ?>
                                            </td>
                                            <?php $pendapatanPerProduk = $produk->harga * $produk->total_terjual; ?>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                Rp<?php echo e(number_format($pendapatanPerProduk, 0, ',', '.')); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data penjualan produk.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('weeklySalesChart').getContext('2d');
                const weeklySalesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                        datasets: [{
                            label: {{ Js::from($labelTitle ?? 'Penjualan Mingguan') }},
                            data: {{ Js::from($data) }},
                            borderColor: '#e879a0',
                            backgroundColor: 'rgba(232, 121, 160, 0.1)',
                            borderWidth: 2,
                            tension: 0.2,
                            pointBackgroundColor: '#e879a0',
                            pointBorderColor: '#ffffff',
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
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });

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
        </script>

    @endpush
@endsection