<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lily Bakery - Payment</title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    .payment-option {
      padding: 1rem;
      background-color: white;
      border-radius: 0.75rem;
      border: 2px solid #e5e7eb;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease-in-out;
      height: 70px;
    }

    .payment-option:hover {
      border-color: #FBCFE8;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .payment-option.selected {
      border-color: #D6A1A1;
      background-color: #FEF2F2;
      box-shadow: 0 0 15px rgba(214, 161, 161, 0.6);
      transform: scale(1.05);
    }

    .payment-option img {
      max-height: 100%;
      max-width: 100%;
      object-fit: contain;
    }

    input[type="radio"] {
      display: none;
    }
  </style>
</head>

<body class="bg-white text-gray-800 font-poppins min-h-screen">

  <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-20 mt-36">
    <div
      class="grid grid-cols-3 gap-2 sm:gap-4 mb-10 max-w-screen-2xl mx-auto w-full px-4 sm:px-6 md:px-10 lg:px-20 text-sm sm:text-base lg:text-lg">
      <div class="bg-[#D6A1A1] text-black px-4 py-2 rounded-full font-semibold text-center">1. Cart</div>
      <div class="bg-[#D6A1A1] text-black px-4 py-2 rounded-full font-semibold text-center">2. Order Info</div>
      <div class="bg-[#D6A1A1] text-black px-4 py-2 rounded-full font-semibold text-center">3. Payment</div>
    </div>

    <main class="flex flex-col lg:flex-row gap-10 pb-20">
      <div class="w-full lg:w-1/2 mb-10 lg:mb-0">
        <h3 class="font-bold uppercase mb-4 tracking-wider">Order Summary</h3>
        <div class="border-b border-gray-300 pb-4 mb-4 space-y-2">
          <?php $__empty_1 = true;
$__currentLoopData = $cartItems;
$__env->addLoop($__currentLoopData);
foreach ($__currentLoopData as $item):
  $__env->incrementLoopIndices();
  $loop = $__env->getLastLoop();
  $__empty_1 = false; ?>
          <div class="flex justify-between items-center text-sm">
            <span><?php  echo e($item->produk->nama_produk); ?></span>
            <span>x<?php  echo e($item->jumlah); ?></span>
            <span class="font-medium">Rp
              <?php  echo e(number_format($item->produk->harga * $item->jumlah, 0, ',', '.')); ?></span>
          </div>
          <?php endforeach;
$__env->popLoop();
$loop = $__env->getLastLoop();
if ($__empty_1): ?>
          <p>Keranjang Anda kosong.</p>
          <?php endif; ?>
        </div>
        <div class="space-y-1 text-sm">
          <div class="flex justify-between">
            <span>Subtotal</span>
            <span>Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
          </div>
          <div class="flex justify-between">
            <span>Delivery</span>
            <span class="font-medium">Rp <?php echo e(number_format($orderDetails['ongkir'], 0, ',', '.')); ?></span>
          </div>
          <div class="flex justify-between font-bold text-lg pt-2 mt-2 border-t">
            <span>Total</span>
            <span class="text-black">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
          </div>
        </div>
      </div>

      <div class="w-full lg:w-1/2 border border-gray-200 rounded-lg p-6">
        <div class="space-y-4 text-sm border-b pb-4 mb-4">
          <div>
            <p class="font-semibold">Store Location</p>
            <p class="text-gray-600"><?php echo e($orderDetails['toko_asal']); ?></p>
          </div>
          <div>
            <p class="font-semibold">Deliver To</p>
            <p class="text-gray-600"><?php echo e($orderDetails['nama_penerima']); ?>
              (<?php echo e($orderDetails['telp_penerima']); ?>)</p>
            <p class="text-gray-600"><?php echo e($orderDetails['alamat_pengiriman']); ?></p>
          </div>
        </div>
        <div>
          <p class="font-semibold mb-4 tracking-wider">Pay with</p>
          <form id="payment-form">
            <div id="payment-options" class="grid grid-cols-4 gap-4">
              <?php
                // Daftar pembayaran disesuaikan dengan value payment_type di Midtrans
                $payments = [
                  ['value' => 'bni_va', 'alt' => 'BNI VA', 'src' => 'bniLogo.png'],
                  ['value' => 'dana', 'alt' => 'DANA', 'src' => 'logoDana.png'],
                  ['value' => 'shopeepay', 'alt' => 'ShopeePay', 'src' => 'logoShoopePay.png'],
                  ['value' => 'bri_va', 'alt' => 'BRI VA', 'src' => 'logoBRI.png'],
                  ['value' => 'qris', 'alt' => 'OVO (via QRIS)', 'src' => 'logoOVO.png'],
                  ['value' => 'qris', 'alt' => 'QRIS', 'src' => 'logoQRIS.png'],
                  ['value' => 'bca_va', 'alt' => 'BCA VA', 'src' => 'logoBCA.png'],
                  ['value' => 'gopay', 'alt' => 'GoPay', 'src' => 'logoGopay.png'],
                ];
              ?>
              @foreach ($payments as $payment)
              <div class="payment-option" data-method="{{ $payment['value'] }}">
                <input type="radio" id="payment-{{ $payment['value'] . '-' . $loop->index }}"
                  name="payment_method" value="{{ $payment['value'] }}" />
                <label for="payment-{{ $payment['value'] . '-' . $loop->index }}">
                  <img src="{{ asset('images/payment/' . $payment['src']) }}"
                    alt="{{ $payment['alt'] }}" />
                </label>
              </div>
              @endforeach
            </div>
          </form>
        </div>
        <div class="mt-8">
          <button id="checkoutBtn"
            class="w-full bg-[#D6A1A1] hover:bg-rose-400 text-black font-semibold py-3 rounded-full transition-colors duration-300">
            Bayar Sekarang
          </button>
        </div>
      </div>
    </main>
  </div>

  <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md text-center">
      <h2 id="paymentModalTitle" class="text-xl font-bold mb-4">Instruksi Pembayaran</h2>
      <div id="paymentModalContent" class="mb-6"></div>
      <p class="text-xs text-gray-500">Selesaikan pembayaran sebelum pesanan dibatalkan otomatis.</p>
      <button onclick="closePaymentModal()"
        class="mt-4 w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg">Tutup</button>
    </div>
  </div>

  <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const options = document.querySelectorAll(".payment-option");
      options.forEach(option => {
        option.addEventListener("click", function () {
          options.forEach(el => el.classList.remove("selected"));
          this.classList.add("selected");
          this.querySelector("input[type='radio']").checked = true;
        });
      });

      const checkoutBtn = document.getElementById('checkoutBtn');
      checkoutBtn.addEventListener('click', async function () {
        const selectedMethod = document.querySelector("input[name='payment_method']:checked");
        if (!selectedMethod) {
          Swal.fire('Peringatan', 'Silakan pilih metode pembayaran terlebih dahulu.', 'warning');
          return;
        }

        checkoutBtn.disabled = true;
        checkoutBtn.innerText = 'Processing...';

        try {
          const response = await fetch('<?php echo e(route("payment.process")); ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ payment_method: selectedMethod.value })
          });

          const result = await response.json();
          if (response.ok) {
            handlePaymentResponse(result);
          } else {
            throw new Error(result.error || 'Terjadi kesalahan pada server.');
          }
        } catch (error) {
          Swal.fire('Error', error.message, 'error');
        } finally {
          checkoutBtn.disabled = false;
          checkoutBtn.innerText = 'Bayar Sekarang';
        }
      });
    });

    // === FUNGSI YANG DIPERBARUI untuk menangani e-wallet lain ===
    function handlePaymentResponse(response) {
        const modal = document.getElementById('paymentModal');
        const title = document.getElementById('paymentModalTitle');
        const content = document.getElementById('paymentModalContent');
        content.innerHTML = ''; // Kosongkan konten sebelumnya

        const gross_amount = `Rp ${parseInt(response.gross_amount).toLocaleString('id-ID')}`;

        // QRIS (Untuk OVO, QRIS, dll)
        if (response.payment_type === 'qris') {
            title.innerText = 'Scan QRIS untuk Membayar';
            const qrCodeUrl = response.actions.find(a => a.name === 'generate-qr-code')?.url;
            content.innerHTML = `
                <p class="mb-2 text-sm">Scan kode QR ini menggunakan aplikasi bank atau e-wallet apa pun.</p>
                <img src="${qrCodeUrl}" alt="QR Code" class="mx-auto w-48 h-48 my-4">
                <p class="font-bold text-lg">Total: ${gross_amount}</p>`;
        }
        // Bank Transfer (VA)
        else if (response.payment_type === 'bank_transfer') {
            const va = response.va_numbers[0];
            title.innerText = `Pembayaran via ${va.bank.toUpperCase()} Virtual Account`;
            content.innerHTML = `
                <p class="mb-2 text-sm">Selesaikan pembayaran ke nomor Virtual Account berikut:</p>
                <div class="bg-gray-100 p-3 rounded-lg flex items-center justify-between my-4">
                    <span class="text-xl font-mono">${va.va_number}</span>
                    <button onclick="copyToClipboard('${va.va_number}')" class="text-sm bg-gray-300 px-3 py-1 rounded-md">Salin</button>
                </div>
                 <p class="font-bold text-lg">Total: ${gross_amount}</p>`;
        }
        // E-Wallet (GoPay, ShopeePay, DANA)
        else if (['gopay', 'shopeepay', 'dana'].includes(response.payment_type)) {
            const paymentName = response.payment_type.charAt(0).toUpperCase() + response.payment_type.slice(1);
            title.innerText = `Pembayaran dengan ${paymentName}`;

            const qrCodeUrl = response.actions.find(a => a.name === 'generate-qr-code')?.url;
            const deeplinkUrl = response.actions.find(a => ['deeplink-redirect', 'deeplink-payment-url'].includes(a.name))?.url;

            let contentHTML = `<p class="mb-2 text-sm">Scan kode QR di aplikasi ${paymentName} atau klik tombol di bawah.</p>`;
            if (qrCodeUrl) {
                contentHTML += `<img src="${qrCodeUrl}" alt="QR Code ${paymentName}" class="mx-auto w-48 h-48 my-4">`;
            }
            if (deeplinkUrl) {
                contentHTML += `<a href="${deeplinkUrl}" target="_blank" class="block w-full mt-4 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Buka Aplikasi ${paymentName}</a>`;
            }
            contentHTML += `<p class="mt-4 font-bold text-lg">Total: ${gross_amount}</p>`;
            content.innerHTML = contentHTML;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePaymentModal() {
        // Arahkan pengguna ke halaman daftar pesanan setelah menutup modal
        window.location.href = "{{ url('pesanan') }}?status=belum_bayar";
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({ icon: 'success', title: 'Berhasil Disalin!', showConfirmButton: false, timer: 1500 });
        });
    }
  </script>
</body>

</html>