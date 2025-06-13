<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lily Bakery - Cart</title>
  {{-- [TAMBAHKAN] CSRF Token untuk AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  {{-- Script untuk notifikasi dan SweetAlert2 untuk popup --}}
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-white text-gray-800 flex flex-col min-h-screen font-poppins">

  @include('layouts.header')

  {{-- Notifikasi --}}
  @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
    class="fixed top-24 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg z-50 ...">
    <p>{{ session('success') }}</p>
    </div>
  @endif
  @if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
    class="fixed top-24 right-5 bg-red-500 text-white py-2 px-4 rounded-lg shadow-lg z-50 ...">
    <p>{{ session('error') }}</p>
    </div>
  @endif

  <main class="flex-1 pt-40 pb-40">
    <div
      class="grid grid-cols-3 gap-2 sm:gap-4 mb-10 max-w-screen-2xl mx-auto w-full px-4 sm:px-6 md:px-10 lg:px-20 text-sm sm:text-base lg:text-lg">
      <div class="bg-[#D6A1A1] text-black px-4 sm:px-6 py-2 sm:py-3 rounded-full font-semibold text-center">1. Cart
      </div>
      <div class="bg-gray-100 text-gray-600 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-semibold text-center">2. Order
        Info</div>
      <div class="bg-gray-100 text-gray-600 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-semibold text-center">3. Payment
      </div>
    </div>

    <div class="container mx-auto px-4 lg:px-20">
      <div class="flex flex-col lg:flex-row justify-between gap-6">

        <div class="w-full lg:w-2/3">
          <div
            class="hidden sm:grid border-b border-gray-300 pb-2 mb-4 uppercase text-lg font-medium text-gray-500 grid-cols-3">
            <div>Items</div>
            <div class="text-center">Qty</div>
            <div class="text-right">Subtotal</div>
          </div>

          @forelse ($cartItems as $item)
        {{-- [MODIFIKASI] Memberi ID unik pada setiap baris dan elemennya --}}
        <div id="cart-item-{{ $item->id_keranjang }}"
        class="grid grid-cols-1 sm:grid-cols-3 items-center py-4 border-b border-gray-200 text-base gap-y-4">
        <div class="font-semibold">{{ $item->nama_produk }}</div>

        <div class="flex justify-between items-center sm:justify-center sm:space-x-4">
          <div class="flex justify-center items-center border border-gray-300 rounded-full overflow-hidden w-fit">
          {{-- [MODIFIKASI] Tombol plus minus sekarang berfungsi --}}
          <button onclick="updateQuantity({{ $item->id_keranjang }}, -1)"
            class="w-10 h-10 text-lg font-semibold text-gray-600 hover:bg-gray-100 focus:outline-none">−</button>
          <input id="quantity-input-{{ $item->id_keranjang }}" type="number" value="{{ $item->jumlah }}"
            class="w-12 text-center text-base font-medium" readonly>
          <button onclick="updateQuantity({{ $item->id_keranjang }}, 1)"
            class="w-10 h-10 text-lg font-semibold text-gray-600 hover:bg-gray-100 focus:outline-none">+</button>
          </div>
          {{-- [MODIFIKASI] Tombol hapus sekarang memicu popup --}}
          <button onclick="confirmDelete({{ $item->id_keranjang }})"
          class="sm:hidden text-gray-400 hover:text-red-500 ml-2"><i class="fas fa-trash"></i></button>
        </div>

        <div class="hidden sm:flex items-center justify-end space-x-2">
          <span id="subtotal-{{ $item->id_keranjang }}">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
          {{-- [MODIFIKASI] Tombol hapus sekarang memicu popup --}}
          <button onclick="confirmDelete({{ $item->id_keranjang }})" class="text-gray-400 hover:text-red-500"><i
            class="fas fa-trash"></i></button>
        </div>
        </div>
      @empty
        <div class="text-center py-16 text-gray-500">
        <p class="text-xl">Keranjang belanja Anda kosong.</p>
        <a href="{{ url('/') }}"
          class="mt-4 inline-block bg-[#E59CAA] text-white px-6 py-2 rounded-lg hover:bg-[#d48a98]">Kembali
          Belanja</a>
        </div>
      @endforelse
        </div>

        <div class="w-full lg:w-1/3">
          @if($cartItems->isNotEmpty())
        <div class="border p-6 rounded-lg shadow-sm">
        <p class="text-lg font-medium mb-2">Order Subtotal</p>
        <p id="total-price" class="text-xl font-bold mb-6">Rp {{ number_format($total, 0, ',', '.') }}</p>
        <a href="{{ route('order.info') }}"
          class="block bg-[#D6A1A1] hover:bg-rose-400 text-black font-semibold px-6 py-3 rounded-full w-full text-center">
          Continue
        </a>
        </div>
      @endif
        </div>
      </div>
    </div>
  </main>

  @include('layouts.footer')

  {{-- [JAVASCRIPT BARU] Untuk kuantitas dan konfirmasi hapus --}}
  <script>
    // Fungsi untuk mengupdate kuantitas via AJAX
    async function updateQuantity(cartId, change) {
      const input = document.getElementById(`quantity-input-${cartId}`);
      let newQuantity = parseInt(input.value) + change;

      if (newQuantity < 1) {
        newQuantity = 1; // Batasi jumlah minimal 1
      }

      try {
        const response = await fetch(`/keranjang/update/${cartId}`, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ jumlah: newQuantity })
        });

        const result = await response.json();
        if (result.success) {
          // Update tampilan kuantitas, subtotal, dan total
          input.value = newQuantity;
          document.getElementById(`subtotal-${cartId}`).innerText = result.subtotal;
          document.getElementById('total-price').innerText = result.total;
        } else {
          Swal.fire('Error', result.message || 'Gagal memperbarui kuantitas.', 'error');
        }
      } catch (error) {
        Swal.fire('Error', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
      }
    }

    // Fungsi untuk menampilkan popup konfirmasi hapus
    function confirmDelete(cartId) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan bisa mengembalikan produk ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Buat form sementara untuk mengirim request DELETE
          let form = document.createElement('form');
          form.action = `/keranjang/hapus/${cartId}`;
          form.method = 'POST'; // Method spoofing
          form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
          document.body.appendChild(form);
          form.submit();
        }
      })
    }
  </script>

</body>

</html>