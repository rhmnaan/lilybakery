<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <div
      class="grid grid-cols-3 gap-2 sm:gap-4 mb-10 max-w-screen-2xl mx-auto w-full px-4 sm:px-6 md:px-10 lg:px-20 text-sm sm:text-base lg:text-lg">
      <div class="bg-[#D6A1A1] text-black px-4 py-2 rounded-full font-semibold text-center">1. Cart</div>
      <div class="bg-[#D6A1A1] text-black px-4 py-2 rounded-full font-semibold text-center">2. Order Info</div>
      <div class="bg-gray-200 text-gray-500 px-4 py-2 rounded-full font-semibold text-center">3. Payment</div>
    </div>

    <div class="max-w-screen mx-auto mt-12 px-2 md:px-2 lg:px-20 flex flex-col lg:flex-row gap-10">
      <div class="w-full lg:w-1/3 space-y-6">
        <h2 class="font-semibold text-sm uppercase">Recipient Detail</h2>
        <div class="relative">
          <i class="fa fa-user absolute left-3 top-3 text-gray-400"></i>
          <input type="text" placeholder="Nama Penerima" value="{{ old('nama_penerima', $pelanggan->nama_pelanggan) }}"
            class="pl-10 w-full border border-gray-300 rounded-md py-2 focus:outline-none focus:ring-2 focus:ring-[#D6A1A1]" />
        </div>
        <div class="relative">
          <span class="absolute left-3 top-3 text-gray-400">+62</span>
          <input type="text" placeholder="Nomor Telepon" value="{{ old('telp_penerima', $pelanggan->telp) }}"
            class="pl-12 w-full border border-gray-300 rounded-md py-2 focus:outline-none focus:ring-2 focus:ring-[#D6A1A1]" />
        </div>

        <div class="mt-8 border-t pt-6 space-y-2">
          <h2 class="font-semibold text-sm uppercase">Cost Summary</h2>
          {{-- [BARU] Menampilkan asal pengiriman --}}
          <div class="flex justify-between text-gray-600">
            <span>Pengiriman dari</span>
            <span id="store-origin-display" class="font-medium text-right">-</span>
          </div>
          <div class="flex justify-between text-gray-600">
            <span>Ongkos Kirim</span>
            <span id="ongkir-display">Rp 0</span>
          </div>
          <div class="flex justify-between font-bold text-lg">
            <span>Estimasi Total</span>
            <span id="total-display">Rp 0</span>
          </div>
          <p class="text-xs text-gray-400">*Total belum termasuk harga produk.</p>
        </div>
      </div>

      <div class="w-full lg:w-2/3 border border-gray-300 rounded-lg p-6 space-y-6">
        <h2 class="font-semibold text-sm uppercase">Set Delivery Location</h2>
        <!-- Tambahkan di dalam <body>, bagian lokasi -->
        <div class="relative">
          <input type="text" id="alamat-dipilih" class="mb-1 w-full border border-gray-300 rounded-md px-4 py-2"
            placeholder="Ketik atau klik peta untuk memilih lokasi..."
            value="{{ old('alamat', $pelanggan->alamat) }}" />
          <!-- Dropdown hasil pencarian -->
          <div id="autocomplete-results"
            class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow mt-1 max-h-60 overflow-y-auto hidden">
          </div>
        </div>
        <div id="peta"></div>
        <div>
          <h3 class="font-semibold mb-2 mt-4">2. Complete Address</h3>
          <textarea placeholder="Ketik Alamat Lengkap.." rows="3"
            class="w-full border border-gray-300 rounded-md px-4 py-2 resize-none">{{ old('alamat_lengkap', $pelanggan->alamat) }}</textarea>
          <input type="text" placeholder="Kode Pos" class="w-full mt-3 border border-gray-300 rounded-md px-4 py-2" />
        </div>
        <form action="{{ route('order.save_info') }}" method="POST" id="order-info-form">
          @csrf
          {{-- Input ini akan diisi oleh JavaScript --}}
          <input type="hidden" name="nama_penerima" id="input_nama_penerima">
          <input type="hidden" name="telp_penerima" id="input_telp_penerima">
          <input type="hidden" name="alamat_pengiriman" id="input_alamat_pengiriman">
          <input type="hidden" name="ongkir" id="input_ongkir" value="0">
          <input type="hidden" name="toko_asal" id="input_toko_asal" value="-">

          <div class="pt-4">
            <button type="submit"
              class="w-full bg-[#D6A1A1] hover:bg-rose-400 text-black font-semibold py-3 rounded-full">
              Continue
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  @include('layouts.footer')

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
  const allStores = @json($stores);
  const TARIF_DASAR = 5000;
  const TARIF_PER_KM = 2000;

  function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = 0.5 - Math.cos(dLat) / 2 +
      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
      (1 - Math.cos(dLon)) / 2;
    return R * 2 * Math.asin(Math.sqrt(a));
  }

  function findNearestStoreAndUpdateUI(customerLat, customerLng) {
    let nearestStore = null;
    let minDistance = Infinity;

    allStores.forEach(store => {
      if (store.latitude && store.longitude) {
        const distance = calculateDistance(customerLat, customerLng, store.latitude, store.longitude);
        if (distance < minDistance) {
          minDistance = distance;
          nearestStore = store;
        }
      }
    });

    if (nearestStore) {
      const ongkir = TARIF_DASAR + (Math.round(minDistance) * TARIF_PER_KM);
      document.getElementById('input_ongkir').value = ongkir;
      document.getElementById('input_toko_asal').value = `Lily Bakery ${nearestStore.nama_toko}`;
      document.getElementById('store-origin-display').innerText = `Lily Bakery ${nearestStore.nama_toko}`;
      document.getElementById('ongkir-display').innerText = `Rp ${ongkir.toLocaleString('id-ID')}`;
      document.getElementById('total-display').innerText = `Rp ${ongkir.toLocaleString('id-ID')}`;
    } else {
      document.getElementById('store-origin-display').innerText = `-`;
      document.getElementById('ongkir-display').innerText = `Rp 0`;
      document.getElementById('total-display').innerText = `Rp 0`;
    }
  }

  document.getElementById('order-info-form').addEventListener('submit', function () {
    document.getElementById('input_nama_penerima').value = document.querySelector('input[placeholder="Nama Penerima"]').value;
    document.getElementById('input_telp_penerima').value = document.querySelector('input[placeholder="Nomor Telepon"]').value;
    document.getElementById('input_alamat_pengiriman').value = document.getElementById('alamat-dipilih').value;
  });

  const initialLocation = [allStores[0].latitude || -7.0736, allStores[0].longitude || 112.5700];
  const peta = L.map('peta').setView(initialLocation, 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(peta);
  let marker;

  allStores.forEach(store => {
    if (store.latitude && store.longitude) {
      L.marker([store.latitude, store.longitude]).addTo(peta)
        .bindPopup(`<b>Lily Bakery ${store.nama_toko}</b>`);
    }
  });

  peta.on('click', async function (e) {
    const lat = e.latlng.lat;
    const lng = e.latlng.lng;
    if (marker) {
      marker.setLatLng(e.latlng);
    } else {
      marker = L.marker(e.latlng).addTo(peta);
    }

    findNearestStoreAndUpdateUI(lat, lng);

    const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
    try {
      const response = await fetch(url);
      const data = await response.json();
      document.getElementById("alamat-dipilih").value = data.display_name || "Lokasi tidak ditemukan";
    } catch (error) {
      document.getElementById("alamat-dipilih").value = "Gagal mengambil lokasi";
    }
  });

  // --- AUTOCOMPLETE ---
  const alamatInput = document.getElementById('alamat-dipilih');
  const resultBox = document.getElementById('autocomplete-results');
  let debounceTimer;

  alamatInput.addEventListener('input', function () {
    const keyword = this.value;
    clearTimeout(debounceTimer);

    if (keyword.length < 3) {
      resultBox.innerHTML = '';
      resultBox.classList.add('hidden');
      return;
    }

    debounceTimer = setTimeout(async () => {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(keyword)}&addressdetails=1&limit=5`;
      try {
        const response = await fetch(url);
        const results = await response.json();

        resultBox.innerHTML = '';
        if (results.length === 0) {
          resultBox.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">Tidak ditemukan</div>';
        } else {
          results.forEach(result => {
            const item = document.createElement('div');
            item.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm';
            item.textContent = result.display_name;

            item.addEventListener('click', () => {
              alamatInput.value = result.display_name;
              resultBox.classList.add('hidden');

              const lat = parseFloat(result.lat);
              const lon = parseFloat(result.lon);

              if (marker) {
                marker.setLatLng([lat, lon]);
              } else {
                marker = L.marker([lat, lon]).addTo(peta);
              }
              peta.setView([lat, lon], 15);
              findNearestStoreAndUpdateUI(lat, lon);
            });

            resultBox.appendChild(item);
          });
        }

        resultBox.classList.remove('hidden');
      } catch (error) {
        resultBox.innerHTML = '<div class="px-4 py-2 text-sm text-red-500">Gagal mengambil data</div>';
        resultBox.classList.remove('hidden');
      }
    }, 500);
  });

  document.addEventListener('click', function (e) {
    if (!alamatInput.contains(e.target) && !resultBox.contains(e.target)) {
      resultBox.classList.add('hidden');
    }
  });
</script>

</body>

</html>