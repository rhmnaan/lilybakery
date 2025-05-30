<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lily Bakery - Privacy Policy</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased bg-white">
    
    @include('layouts.header')

    <!-- Privacy Policy Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-16 bg-white">
        <div class="container mx-auto px-4 text-justify"> 
            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">Privacy Policy</h1>
            <p class="text-gray-700 leading-relaxed mb-6">
                Kebijakan privasi ini berlaku untuk situs web ini dan disediakan oleh Sample, serta mengatur privasi pengguna yang memilih untuk menggunakannya.
                <br><br>
                Kebijakan ini menjelaskan berbagai aspek yang berkaitan dengan privasi pengguna dan menguraikan kewajiban serta tanggung jawab pengguna, situs web, dan pemilik situs web.
                <br>
                Selain itu, cara situs web ini memproses, menyimpan, dan melindungi data serta informasi pengguna juga akan dijelaskan dalam kebijakan ini.
            </p>

            <h2 class="text-xl font-semibold mb-2 text-gray-800">The Website</h2>
            <p class="text-gray-700 leading-relaxed mb-6">
                Situs web ini dan pemiliknya mengambil pendekatan proaktif terhadap privasi pengguna dan memastikan langkah-langkah yang diperlukan diambil untuk melindungi privasi pengguna selama kunjungan mereka.
                Situs web ini mematuhi semua undang-undang dan persyaratan nasional yang berlaku terkait privasi pengguna.
            </p>

            <h2 class="text-xl font-semibold mb-2 text-gray-800">Use of Cookies</h2>
            <p class="text-gray-700 leading-relaxed mb-6">
                Situs web ini menggunakan cookie untuk meningkatkan pengalaman pengguna saat mengunjungi situs web. Jika diperlukan, situs web ini menggunakan sistem kontrol cookie
                yang memungkinkan pengguna pada kunjungan pertama mereka untuk menyetujui atau menolak penggunaan cookie di komputer/perangkat mereka. Hal ini sesuai dengan persyaratan
                undang-undang tertentu yang mewajibkan situs web untuk mendapatkan persetujuan eksplisit dari pengguna sebelum menyimpan atau membaca file seperti cookie di komputer/perangkat pengguna.
            </p>

            <p class="text-gray-700 leading-relaxed mb-6">
                Cookie adalah file kecil yang disimpan di hard drive komputer pengguna yang melacak, menyimpan, dan merekam informasi tentang interaksi dan penggunaan situs web oleh pengguna.
                Hal ini memungkinkan situs web, melalui servernya, untuk memberikan pengalaman yang disesuaikan bagi pengguna di dalam situs web ini. Pengguna disarankan bahwa jika mereka ingin
                menolak penggunaan dan penyimpanan cookie dari situs ini ke hard drive komputer mereka, maka mereka harus mengambil langkah-langkah yang diperlukan dalam pengaturan keamanan browser mereka
                untuk memblokir semua cookie dari situs ini dan vendor eksternal yang terkait.
            </p>

            <p class="text-gray-700 leading-relaxed mb-6">
                Situs web ini menggunakan perangkat lunak pelacakan untuk memantau pengunjungnya guna memahami dengan lebih baik bagaimana mereka menggunakan situs.
                Perangkat lunak ini disediakan oleh Google Analytics yang menggunakan cookie untuk melacak penggunaan pengunjung. Perangkat lunak ini akan menyimpan cookie
                di hard drive komputer Anda untuk melacak dan memantau keterlibatan serta penggunaan situs web, namun tidak akan menyimpan, merekam, atau mengumpulkan informasi pribadi.
                Anda dapat membaca kebijakan privasi Google di sini untuk informasi lebih lanjut:
                <a href="http://www.google.com/privacy.html" class="text-lily-pink-dark hover:underline">http://www.google.com/privacy.html</a>.
            </p>

            <p class="text-gray-700 leading-relaxed">
                Cookie lainnya mungkin juga disimpan di hard drive komputer Anda oleh vendor eksternal saat situs ini menggunakan program referal, tautan bersponsor, atau iklan.
                Cookie seperti ini dirancang untuk pelacakan konversi dan referal, dan biasanya kedaluwarsa setelah 30 hari, meskipun beberapa mungkin bertahan lebih lama.
                Tidak ada informasi pribadi yang disimpan, direkam, atau dikumpulkan.
            </p>
        </div>
    </section>

    @include('layouts.footer')
</body>
</html>