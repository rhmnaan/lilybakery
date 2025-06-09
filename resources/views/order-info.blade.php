<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lily Bakery - Order Info</title>
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    #peta {
      height: 300px;
      width: 100%;
      border-radius: 8px;
      position: relative;
      z-index: 0;
    }
  </style>
</head>
<body class="bg-white text-gray-800 flex flex-col min-h-screen font-poppins">

  @include('layouts.header')

  <main class="flex-1 pt-40 pb-40">
    <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-10 max-w-screen-2xl mx-auto w-full px-4 sm:px-6 md:px-10 lg:px-20 text-sm sm:text-base lg:text-lg">
      <div class="bg-[#D6A1A1] text-black px-4 py-2 rounded-full font-semibold text-center">1. Cart</div>
      <div class="bg-[#D6A1A1] text-black px-4 py-2 rounded-full font-semibold text-center">2. Order Info</div>
      <div class="bg-gray-200 text-gray-500 px-4 py-2 rounded-full font-semibold text-center">3. Payment</div>
    </div>

    <div class="max-w-screen mx-auto mt-12 px-2 md:px-2 lg:px-20 flex flex-col lg:flex-row gap-10">
      
      {{-- [MODIFIKASI DI SINI] --}}
      <div class="w-full lg:w-1/3 space-y-6">
        <h2 class="font-semibold text-sm uppercase">Recipient Detail</h2>
        <div class="relative">
          <i class="fa fa-user absolute left-3 top-3 text-gray-400"></i>
          {{-- Menggunakan data nama pelanggan sebagai nilai default --}}
          <input type="text" placeholder="Nama Penerima" value="{{ old('nama_penerima', $pelanggan->nama_pelanggan) }}" class="pl-10 w-full border border-gray-300 rounded-md py-2 focus:outline-none focus:ring-2 focus:ring-[#D6A1A1]" />
        </div>
        <div class="relative">
          <span class="absolute left-3 top-3 text-gray-400">+62</span>
          {{-- Menggunakan data telepon pelanggan sebagai nilai default --}}
          <input type="text" placeholder="Nomor Telepon" value="{{ old('telp_penerima', $pelanggan->telp) }}" class="pl-12 w-full border border-gray-300 rounded-md py-2 focus:outline-none focus:ring-2 focus:ring-[#D6A1A1]" />
        </div>
      </div>

      <div class="w-full lg:w-2/3 border border-gray-300 rounded-lg p-6 space-y-6">
        <h2 class="font-semibold text-sm uppercase">Set Delivery Location</h2>

        <div>
          <h3 class="font-semibold mb-2">1. Set Location</h3>
          {{-- Menggunakan alamat pelanggan sebagai nilai default jika tersedia --}}
          <input type="text" id="alamat-dipilih" class="mb-4 w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D6A1A1]" placeholder="Ketik atau klik peta untuk memilih lokasi..." value="{{ old('alamat', $pelanggan->alamat) }}" />
          <div id="peta"></div>
        </div>

        <div>
          <h3 class="font-semibold mb-2 mt-4">2. Complete Address</h3>
          {{-- Menggunakan alamat pelanggan sebagai nilai default jika tersedia --}}
          <textarea placeholder="Ketik Alamat Lengkap.." rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-[#D6A1A1]">{{ old('alamat_lengkap', $pelanggan->alamat) }}</textarea>
          <input type="text" placeholder="Kode Pos" class="w-full mt-3 border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D6A1A1]" />
        </div>

        <div class="pt-4">
          <a href="{{ route('payment') }}">
            <button class="w-full bg-[#D6A1A1] hover:bg-rose-400 text-black font-semibold py-3 rounded-full">
              Continue
            </button>
          </a>
        </div>
      </div>
    </div>
  </main>

  @include('layouts.footer')

  {{-- Script untuk Leaflet.js tetap sama --}}
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    const peta = L.map('peta').setView([-7.0736, 112.5700], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(peta);
    let marker;
    peta.on('click', async function (e) {
      const lat = e.latlng.lat;
      const lng = e.latlng.lng;
      if (marker) {
        marker.setLatLng(e.latlng);
      } else {
        marker = L.marker(e.latlng).addTo(peta);
      }
      const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
      try {
        const response = await fetch(url);
        const data = await response.json();
        document.getElementById("alamat-dipilih").value = data.display_name || "Lokasi tidak ditemukan";
      } catch (error) {
        document.getElementById("alamat-dipilih").value = "Gagal mengambil lokasi";
      }
    });
    const inputAlamat = document.getElementById("alamat-dipilih");
    inputAlamat.addEventListener("keydown", async function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        const alamat = inputAlamat.value.trim();
        if (!alamat) return;
        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(alamat)}`;
        try {
          const response = await fetch(url);
          const results = await response.json();
          if (results && results.length > 0) {
            const lat = parseFloat(results[0].lat);
            const lon = parseFloat(results[0].lon);
            peta.setView([lat, lon], 16);
            if (marker) {
              marker.setLatLng([lat, lon]);
            } else {
              marker = L.marker([lat, lon]).addTo(peta);
            }
            inputAlamat.value = results[0].display_name;
          } else {
            inputAlamat.value = "Alamat tidak ditemukan";
          }
        } catch (error) {
          inputAlamat.value = "Gagal mencari alamat";
        }
      }
    });
  </script>

</body>
</html>