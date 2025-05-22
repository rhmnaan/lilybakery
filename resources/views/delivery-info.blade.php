<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Delivery Information</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    @include('layouts.header')


    <!-- Hero Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">Delivery Information</h1>
        <!-- Komitmen Kami -->
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">Komitmen Kami</h2>
                <p class="text-gray-700 leading-relaxed">
                    Kami percaya bahwa setiap momen istimewa dimulai dari hal sederhana, seperti aroma roti yang baru keluar dari oven,
                    atau kue favorit yang tiba tepat waktu di hari ulang tahun orang tersayang. Oleh karena itu, kami di Lily Bakery
                    berkomitmen untuk menghadirkan produk terbaik kami, bukan hanya dalam rasa, tetapi juga dalam pengalaman pengiriman yang menyenangkan.
                    <br><br>
                    Untuk memastikan Anda mendapatkan layanan yang cepat, aman, dan terpercaya, kami bekerja sama dengan layanan pengiriman eksternal
                    seperti GrabExpress, GoSend, dan mitra logistik lainnya yang siap menjangkau lokasi Anda.
                </p>
            </div>

            <!-- Waktu & Jadwal Pengiriman -->
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">Waktu & Jadwal Pengiriman</h2>
                <ul class="list-disc pl-6 text-gray-700 leading-relaxed space-y-2">
                    <li><strong>Hari Operasional:</strong> Setiap hari, termasuk akhir pekan dan hari libur nasional (kecuali ada pengumuman khusus)</li>
                    <li><strong>Waktu Pengiriman:</strong> 08.00 – 20.00 WIB</li>
                    <li>
                        <strong>Same-Day Delivery:</strong> Pesanan yang dikonfirmasi sebelum pukul 15.00 akan diproses untuk pengiriman di hari yang sama<br>
                        <em class="text-sm text-gray-500">Catatan: Pesanan yang masuk di luar jam operasional akan diproses di hari berikutnya.</em>
                    </li>
                </ul>
            </div>

            <!-- Biaya Pengiriman -->
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">Biaya Pengiriman</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Lily Bakery berkomitmen untuk memberikan layanan yang transparan dan terjangkau. Kami menggunakan rumus perhitungan sebagai berikut:
                </p>
                <ul class="list-disc pl-6 text-gray-700 mb-6">
                    <li>Tarif Dasar: Rp5.000</li>
                    <li>Tarif per Km: Rp2.000</li>
                </ul>

                <table class="w-full border text-sm text-gray-700 mb-4">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">Jarak (Km)</th>
                            <th class="border px-4 py-2 text-left">Perhitungan</th>
                            <th class="border px-4 py-2 text-left">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">2 Km</td>
                            <td class="border px-4 py-2">Rp5.000 + (2 × Rp2.000) = Rp5.000 + Rp4.000</td>
                            <td class="border px-4 py-2">Rp9.000</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">5 Km</td>
                            <td class="border px-4 py-2">Rp5.000 + (5 × Rp2.000) = Rp5.000 + Rp10.000</td>
                            <td class="border px-4 py-2">Rp15.000</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">8 Km</td>
                            <td class="border px-4 py-2">Rp5.000 + (8 × Rp2.000) = Rp5.000 + Rp16.000</td>
                            <td class="border px-4 py-2">Rp21.000</td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-sm text-gray-600">
                    <strong>Catatan:</strong> Jarak dihitung dari lokasi Lily Bakery ke alamat tujuan. Biaya pengiriman akan otomatis ditampilkan saat checkout.
                </p>
            </div>
        </div>
    </section>

    @include('layouts.footer')
</body>
</html>