

<?php $__env->startSection('content'); ?>
<div class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md">
            <div class="p-4 bg-pink-300">
                <div class="flex items-center justify-center">
                    <img src="<?php echo e(asset('images/lily-bakery-logo.png')); ?>" alt="Lily Bakery Logo" class="h-16">
                </div>
            </div>
            <nav class="mt-2">
                <a href="" class="flex items-center px-4 py-3 bg-pink-200 text-gray-800 hover:bg-pink-300">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-birthday-cake mr-3"></i>
                    <span>Product</span>
                </a>
                <a href="" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-shopping-bag mr-3"></i>
                    <span>Orders</span>
                </a>
                <a href="" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-users mr-3"></i>
                    <span>Customers</span>
                </a>
                <a href="" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Setting</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="bg-pink-100 p-3 rounded-full">
                            <i class="fas fa-box text-pink-500"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Produk</h3>
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-800">69</span>
                        <span class="ml-2 text-gray-600 text-sm">item</span>
                    </div>
                </div>

                <!-- Orders Today -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="bg-pink-100 p-3 rounded-full">
                            <i class="fas fa-shopping-cart text-pink-500"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700">Pesanan hari ini</h3>
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-800">100</span>
                        <span class="ml-2 text-gray-600 text-sm">pesanan</span>
                    </div>
                </div>

                <!-- Revenue Today -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="bg-pink-100 p-3 rounded-full">
                            <i class="fas fa-money-bill-wave text-pink-500"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700">Pendapatan Hari ini</h3>
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-800">Rp. 12.000.000</span>
                    </div>
                </div>

                <!-- Registered Customers -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="bg-pink-100 p-3 rounded-full">
                            <i class="fas fa-user text-pink-500"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700">Pelanggan Terdaftar</h3>
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-800">1352</span>
                        <span class="ml-2 text-gray-600 text-sm">pelanggan</span>
                    </div>
                </div>
            </div>

            <!-- Weekly Sales Chart -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Penjualan Mingguan</h2>
                <div class="h-64">
                    <canvas id="weeklySalesChart"></canvas>
                </div>
            </div>

            <!-- Best Selling Products Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 bg-white border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Produk Terlaris</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Produk Terlaris
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Terjual
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Perbulan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">Chocolate cake</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 230.000</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">1200</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 230.000.000</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">Matcha Donut</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 15.000</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">1200</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 230.000.000</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">Cheese Cake</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 250.000</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">1100</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 210.000.000</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">Chocoberry Bread</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 45.000</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">900</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 190.000.000</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">Blueberry Cake</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 120.000</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">700</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900">Rp 140.000.000</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('layouts.footer-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
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
                    borderColor: '#e879a0',
                    backgroundColor: 'rgba(248, 180, 196, 0.1)',
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\lilybakery\resources\views/admin-dashboard.blade.php ENDPATH**/ ?>