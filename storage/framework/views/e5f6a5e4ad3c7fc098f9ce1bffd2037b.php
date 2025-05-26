<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lily Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-pink-50">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-6 flex flex-col shadow-md">
        <div class="mb-10">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Lily Bakery" class="w-[250px] mb-2">
            <p class="text-sm text-gray-500">Cake, Bread & More...</p>
        </div>
        <nav class="space-y-4">
            <a href="#" class="flex items-center gap-2 text-pink-500 font-bold">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-pink-500">
                <i class="fas fa-box"></i> Product
            </a>
            <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-pink-500">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
            <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-pink-500">
                <i class="fas fa-users"></i> Customers
            </a>
            <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-pink-500">
                <i class="fas fa-cog"></i> Setting
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-pink-100 p-4 rounded-lg shadow">
                <p class="text-sm">Total Produk</p>
                <h2 class="text-xl font-bold">69 <span class="text-sm font-normal">item</span></h2>
            </div>
            <div class="bg-pink-100 p-4 rounded-lg shadow">
                <p class="text-sm">Pesanan Hari Ini</p>
                <h2 class="text-xl font-bold">100 <span class="text-sm font-normal">pesanan</span></h2>
            </div>
            <div class="bg-pink-100 p-4 rounded-lg shadow">
                <p class="text-sm">Pendapatan Hari Ini</p>
                <h2 class="text-xl font-bold">Rp. 12.000.000</h2>
            </div>
            <div class="bg-pink-100 p-4 rounded-lg shadow">
                <p class="text-sm">Pelanggan Terdaftar</p>
                <h2 class="text-xl font-bold">1352 <span class="text-sm font-normal">pelanggan</span></h2>
            </div>
        </div>

        <!-- Weekly Sales -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-lg font-semibold mb-4">Penjualan Mingguan</h2>
            <div class="h-40 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                [ Grafik Penjualan Mingguan ]
            </div>
        </div>

        <!-- Best Selling Products -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Produk Terlaris</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-600 border-b">
                            <th class="py-2">Produk</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Terjual</th>
                            <th class="py-2">Perbulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b"><td>Chocolate Cake</td><td>Rp 230.000</td><td>1200</td><td>Rp 230.000.000</td></tr>
                        <tr class="border-b"><td>Matcha Donut</td><td>Rp 15.000</td><td>1200</td><td>Rp 230.000.000</td></tr>
                        <tr class="border-b"><td>Cheese Cake</td><td>Rp 250.000</td><td>1100</td><td>Rp 210.000.000</td></tr>
                        <tr class="border-b"><td>Chocoberry Bread</td><td>Rp 45.000</td><td>900</td><td>Rp 190.000.000</td></tr>
                        <tr class="border-b"><td>Blueberry Cake</td><td>Rp 120.000</td><td>700</td><td>Rp 140.000.000</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
<footer class="bg-pink-300 px-6 py-8 mt-12 min-h-screen">
    <div class="container mx-auto grid md:grid-cols-2 gap-8 text-sm">
        <div>
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Lily Bakery" class="w-[250px] mb-2">
            <img src="<?php echo e(asset('images/halal.png')); ?>" alt="Lily Bakery" class="w-[250px] mb-2 mt-5">
            <p class="font-bold">PT Lily Cipta Rasa</p>
            <p>Email: <a href="mailto:info@lilybakery.id" class="underline">info@lilybakery.id</a></p>
        </div>
        <div>
            <p><i class="fas fa-phone mr-2"></i>0812 3456 7890</p>
            <p><i class="fab fa-whatsapp mr-2"></i>+62 812 3456 7890</p>
            <p><i class="fab fa-instagram mr-2"></i>@lilybakery.id</p>
            <p class="mt-2 font-semibold">Layanan Pengaduan Konsumen</p>
            <p>Direktorat Jenderal Perlindungan Konsumen dan Tertib Niaga</p>
            <p>Kementerian Perdagangan Republik Indonesia</p>
            <p>0853 1111 1010 (WhatsApp)</p>
        </div>
    </div>
</footer>
</body>
</html>
<?php /**PATH C:\laragon\www\lilybakery\resources\views/Admin/dashboard-admin.blade.php ENDPATH**/ ?>