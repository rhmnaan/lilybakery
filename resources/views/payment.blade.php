<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lily Bakery - Payment</title>
  @vite('resources/css/app.css')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* Container setiap payment option */
    .payment-option {
      padding: 0.75rem;
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
      cursor: pointer;
      text-align: center;
      transition: box-shadow 0.3s ease, border 0.3s ease, transform 0.3s ease;
      border: 2px solid transparent; /* default border */
    }

    .payment-option:hover {
      box-shadow: 0 0 10px 2px rgba(214, 161, 161, 0.8);
      transform: scale(1.05);
    }

    /* Border ring saat dipilih */
    .payment-option.selected {
      border-color: #D6A1A1;
      box-shadow: 0 0 15px #D6A1A1;
      transform: scale(1.05);
    }

    /* Sembunyikan input radio */
    input[type="radio"] {
      display: none;
    }
  </style>
</head>
<body class="bg-white text-gray-800 font-poppins min-h-screen">

  @include('layouts.header')

  <!-- Step Indicator -->
  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-20 mt-36">
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-center text-xs sm:text-sm font-semibold mb-10">
      <div class="bg-[#D6A1A1] text-black py-2 rounded-full">1. Cart</div>
      <div class="bg-[#D6A1A1] text-black py-2 rounded-full">2. Order Info</div>
      <div class="bg-[#D6A1A1] text-black py-2 rounded-full">3. Payment</div>
    </div>
  </div>

  <!-- Order Info Content -->
  <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-20 flex flex-col lg:flex-row gap-10">
    <!-- Order Summary -->
    <div class="w-full lg:w-1/2 mb-10 lg:mb-0">
      <h3 class="font-bold uppercase mb-4">Order Summary</h3>
      <div class="border-b border-gray-300 pb-4 mb-4">
        <div class="flex justify-between items-center mb-2">
          <span>NASTAR</span>
          <span>x1</span>
          <span class="font-medium">Rp 50.000</span>
        </div>
      </div>
      <div class="space-y-1">
        <div class="flex justify-between">
          <span>Subtotal</span>
          <span>Rp 50.000</span>
        </div>
        <div class="flex justify-between">
          <span>Delivery</span>
          <span>Free</span>
        </div>
        <div class="flex justify-between font-bold text-base pt-2">
          <span>Total</span>
          <span class="text-black">Rp 100.000</span>
        </div>
      </div>
    </div>

    <!-- Info dan Pembayaran -->
    <div class="w-full lg:w-1/2 border border-gray-200 rounded-lg p-6">
      <div class="space-y-4">
        <div>
          <p class="font-semibold">Store Location</p>
          <p>Jl. Telang RT 00 RW 00</p>
        </div>
        <div>
          <p class="font-semibold">Deliver To</p>
          <p>Jl. Telang RT 01 RW 02</p>
        </div>
        <div>
          <p class="font-semibold">Estimated Arrival</p>
          <p>In 20 - 30 Day</p>
        </div>
      </div>

      <div class="mt-6">
        <p class="font-semibold mb-6">Pay with</p>
        <div id="payment-options" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">

          @php
              $payments = [
                ['src' => 'bniLogo.png', 'alt' => 'BNI'],
                ['src' => 'logoDana.png', 'alt' => 'Dana'],
                ['src' => 'logoShoopePay.png', 'alt' => 'ShopeePay'],
                ['src' => 'logoBRI.png', 'alt' => 'BRI'],
                ['src' => 'logoOVO.png', 'alt' => 'OVO'],
                ['src' => 'logoQRIS.png', 'alt' => 'QRIS'],
                ['src' => 'logoBCA.png', 'alt' => 'BCA'],
                ['src' => 'logoGopay.png', 'alt' => 'GoPay'],
              ];
          @endphp

          @foreach($payments as $payment)
            <div class="payment-option" data-method="{{ $payment['alt'] }}">
              <input
                type="radio"
                id="payment-{{ strtolower($payment['alt']) }}"
                name="payment_method"
                value="{{ $payment['alt'] }}"
              />
              <label for="payment-{{ strtolower($payment['alt']) }}">
                <img src="{{ asset('images/payment/' . $payment['src']) }}" alt="{{ $payment['alt'] }}" class="h-10 object-contain mx-auto" />
              </label>
            </div>
          @endforeach

        </div>
      </div>

      <div class="mt-6">
        <button id="checkoutBtn" class="w-full bg-[#D6A1A1] hover:bg-rose-400 text-black font-semibold py-3 rounded-full">
          Checkout
        </button>
      </div>
    </div>

  </main>

  <!-- Modal QRIS -->
  <div id="qrisModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-[#F4A7B9] p-6 rounded-2xl shadow-lg w-full max-w-md relative text-center">
      <button onclick="closeQrisModal()" class="absolute top-2 right-4 text-black text-2xl font-bold">&times;</button>
      <h2 class="text-xl font-bold mb-4">Payment Via QRIS</h2>
      <p class="mb-2 text-sm">Kode QR</p>
      <div class="mx-auto mb-4" style="width: 160px; height: 160px;" id="qrcode-container">
        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(160)->generate('Kode QR Pembayaran QRIS Lily Bakery') !!}
      </div>

      <button id="downloadQrisBtn" class="bg-white text-black px-4 py-2 rounded-md hover:bg-gray-200 mb-4">
        Download QR Code
      </button>

      <div class="border-t border-black py-2 font-bold text-lg">Total Bayar : Rp100.000</div>
      <p class="mt-2 text-sm text-white font-medium">Selesaikan Pembayaran Dalam 24 Jam</p>
    </div>
  </div>

  <!-- Modal Pembayaran VA (BRI, BNI, BCA, ShopeePay, OVO, Dana, GoPay) -->
  @php
    $virtualPayments = [
      'BRI' => '01234567890',
      'BNI' => '09876543210',
      'BCA' => '11223344556',
      'ShopeePay' => '99900012345',
      'OVO' => '081234567890',
      'Dana' => '089876543210',
      'GoPay' => '087700112233',
    ];
  @endphp

  @foreach($virtualPayments as $method => $va)
    <div id="modal-{{ strtolower($method) }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
      <div class="bg-[#F4A7B9] p-6 rounded-2xl shadow-lg w-full max-w-md relative text-center">
        <button onclick="closeModal('{{ strtolower($method) }}')" class="absolute top-2 right-4 text-black text-2xl font-bold">&times;</button>
        <h2 class="text-xl font-bold mb-4">Payment Via {{ $method }}</h2>
        <p class="mb-1 text-sm">Kode Virtual Account</p>
        <div class="flex items-center justify-center mb-4">
          <input type="text" readonly class="text-center font-bold bg-white rounded-lg px-4 py-2 w-64" value="{{ $va }}">
          <button onclick="copyToClipboard('{{ $va }}')" class="ml-2 text-white bg-gray-700 px-2 py-1 rounded-lg text-sm">📋</button>
        </div>
        <div class="border-t border-black py-2 font-bold text-lg">Total Bayar : Rp100.000</div>
        <p class="mt-2 text-sm text-white font-medium">Selesaikan Pembayaran Dalam 24 Jam</p>
      </div>
    </div>
  @endforeach


  @include('layouts.footer')

  <script>
    // Fungsi setelah semua elemen dimuat
    document.addEventListener("DOMContentLoaded", function () {
      const options = document.querySelectorAll(".payment-option");

      options.forEach(option => {
        option.addEventListener("click", function () {
          // Hapus class selected dari semua opsi
          options.forEach(el => {
            el.classList.remove("selected");
            const input = el.querySelector("input[type='radio']");
            if (input) input.checked = false;
          });

          // Tambahkan class selected pada opsi yang diklik
          this.classList.add("selected");
          const radio = this.querySelector("input[type='radio']");
          if (radio) radio.checked = true;
        });
      });
    });

    // Metode pembayaran yang menggunakan modal VA
    const paymentMethodsWithModal = ['BRI', 'BNI', 'BCA', 'ShopeePay', 'OVO', 'Dana', 'GoPay'];

    // Fungsi untuk menutup modal sesuai metode
    function closeModal(method) {
      const modal = document.getElementById("modal-" + method.toLowerCase());
      if (modal) modal.classList.add("hidden");
    }

    // Fungsi untuk menutup modal QRIS
    function closeQrisModal() {
      const qrisModal = document.getElementById("qrisModal");
      if (qrisModal) qrisModal.classList.add("hidden");
    }

    // Fungsi untuk copy VA ke clipboard
    function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
          icon: 'success',
          title: 'Disalin!',
          text: 'Virtual Account berhasil disalin!',
          confirmButtonColor: '#D6A1A1'
        });
      }).catch(() => {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: 'Gagal menyalin ke clipboard.',
          confirmButtonColor: '#D6A1A1'
        });
      });
    }

    // Tombol checkout diklik
    document.getElementById("checkoutBtn").addEventListener("click", function () {
      const selected = document.querySelector("input[name='payment_method']:checked");

      if (!selected) {
        Swal.fire({
          icon: 'warning',
          title: 'Oops!',
          text: 'Silakan pilih metode pembayaran terlebih dahulu.',
          confirmButtonColor: '#D6A1A1'
        });
        return;
      }

      const selectedMethod = selected.value;

      if (selectedMethod === "QRIS") {
        document.getElementById("qrisModal").classList.remove("hidden");
      } else if (paymentMethodsWithModal.includes(selectedMethod)) {
        document.getElementById("modal-" + selectedMethod.toLowerCase()).classList.remove("hidden");
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Metode pembayaran tidak dikenali.',
          confirmButtonColor: '#D6A1A1'
        });
      }
    });

    document.getElementById('downloadQrisBtn').addEventListener('click', function() {
      const svg = document.querySelector('#qrcode-container svg');
      if (!svg) return alert('QR code tidak ditemukan');

      // Serialize SVG ke string
      const serializer = new XMLSerializer();
      const svgString = serializer.serializeToString(svg);

      // Buat canvas untuk render SVG ke image
      const canvas = document.createElement('canvas');
      canvas.width = 160;
      canvas.height = 160;
      const ctx = canvas.getContext('2d');

      // Buat image dari svg string
      const img = new Image();
      const svgBlob = new Blob([svgString], {type: 'image/svg+xml;charset=utf-8'});
      const url = URL.createObjectURL(svgBlob);

      img.onload = function() {
        ctx.drawImage(img, 0, 0);
        URL.revokeObjectURL(url);

        // Buat link download dari canvas
        const pngUrl = canvas.toDataURL('image/png');

        const downloadLink = document.createElement('a');
        downloadLink.href = pngUrl;
        downloadLink.download = 'qris-lilybakery.png';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);

        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'QR Code berhasil diunduh.',
          confirmButtonColor: '#D6A1A1'
        });
      };

      img.onerror = function() {
        alert('Gagal memproses QR Code untuk diunduh.');
      };

      img.src = url;
    });

  </script>






</body>
</html>
