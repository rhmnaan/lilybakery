<<<<<<< HEAD
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Payment Methods</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    @include('layouts.header')


<!-- Payment Info -->
    <section class="py-16 md:px-20 px-4 pt-36 mx-auto text-justify">
        <h1 class="text-3xl font-bold text-center mb-8">Payment Methods</h1>
        <p class="text-gray mb-6">
            Kami menyediakan beberapa metode pembayaran yang mudah dan aman untuk kenyamanan transaksi Anda.
            Silakan pilih metode yang paling sesuai saat melakukan pembayaran.
        </p>

        <h2 class="text-xl font-semibold mb-2">Transfer Bank</h2>
        <p class="mb-2">Bayar langsung ke rekening bank kami. Setelah pembayaran dilakukan, mohon konfirmasi melalui halaman konfirmasi atau hubungi admin.</p>
        <ul class="list-disc list-inside mb-6">
            <li>
                <strong>Bank BCA</strong><br>
                No. Rekening: 1234567890<br>
                Atas Nama: SHOYVA LILY LAU
            </li>
            <li class="mt-3">
                <strong>Bank BRI</strong><br>
                No. Rekening: 0987654321<br>
                Atas Nama: SHOYVA LILY LAU
            </li>
            <li class="mt-3">
                <strong>Bank BNI</strong><br>
                No. Rekening: 0987654321<br>
                Atas Nama: SHOYVA LILY LAU
            </li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">E-Wallet (Dompet Digital)</h2>
        <p class="mb-2">Pembayaran instan dan cepat melalui e-wallet favorit Anda.</p>
        <ul class="list-disc list-inside mb-6">
            <li>OVO – 081234568901</li>
            <li>DANA – 081234568901</li>
            <li>GoPay – 081234568901</li>
            <li>ShopeePay – 081234568901</li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">QRIS (QR Code Pembayaran)</h2>
        <p class="mb-6">
            Cukup scan QR code dengan aplikasi e-wallet Anda (OVO, DANA, LinkAja, GoPay, ShopeePay, dll) untuk membayar langsung.
        </p>

        <h2 class="text-xl font-semibold mb-2 text-red-600">Catatan :</h2>
        <ul class="list-disc list-inside text-gray-700">
            <li>Harap lakukan pembayaran dalam waktu 1×24 jam setelah pemesanan.</li>
            <li>Jika tidak ada konfirmasi pembayaran, pesanan akan otomatis dibatalkan.</li>
            <li>Simpan bukti transaksi sebagai referensi.</li>
        </ul>
    </section>

    @include('layouts.footer')
</body>
=======
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Payment Methods</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    @include('layouts.header')


<!-- Payment Info -->
    <section class="py-16 px-4 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">Payment Methods</h1>
        <p class="text-gray-700 mb-6">
            Kami menyediakan beberapa metode pembayaran yang mudah dan aman untuk kenyamanan transaksi Anda.
            Silakan pilih metode yang paling sesuai saat melakukan pembayaran.
        </p>

        <h2 class="text-xl font-semibold mb-2">Transfer Bank</h2>
        <p class="mb-2">Bayar langsung ke rekening bank kami. Setelah pembayaran dilakukan, mohon konfirmasi melalui halaman konfirmasi atau hubungi admin.</p>
        <ul class="list-disc list-inside mb-6">
            <li>
                <strong>Bank BCA</strong><br>
                No. Rekening: 1234567890<br>
                Atas Nama: SHOYVA LILY LAU
            </li>
            <li class="mt-3">
                <strong>Bank BRI</strong><br>
                No. Rekening: 0987654321<br>
                Atas Nama: SHOYVA LILY LAU
            </li>
            <li class="mt-3">
                <strong>Bank BNI</strong><br>
                No. Rekening: 0987654321<br>
                Atas Nama: SHOYVA LILY LAU
            </li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">E-Wallet (Dompet Digital)</h2>
        <p class="mb-2">Pembayaran instan dan cepat melalui e-wallet favorit Anda.</p>
        <ul class="list-disc list-inside mb-6">
            <li>OVO – 081234568901</li>
            <li>DANA – 081234568901</li>
            <li>GoPay – 081234568901</li>
            <li>ShopeePay – 081234568901</li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">QRIS (QR Code Pembayaran)</h2>
        <p class="mb-6">
            Cukup scan QR code dengan aplikasi e-wallet Anda (OVO, DANA, LinkAja, GoPay, ShopeePay, dll) untuk membayar langsung.
        </p>

        <h2 class="text-xl font-semibold mb-2 text-red-600">Catatan :</h2>
        <ul class="list-disc list-inside text-gray-700">
            <li>Harap lakukan pembayaran dalam waktu 1×24 jam setelah pemesanan.</li>
            <li>Jika tidak ada konfirmasi pembayaran, pesanan akan otomatis dibatalkan.</li>
            <li>Simpan bukti transaksi sebagai referensi.</li>
        </ul>
    </section>

    @include('layouts.footer')
</body>
>>>>>>> 23eb2fc99bc707a55f2da3544cca01a9f0c3831a
</html>