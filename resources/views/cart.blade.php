<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lily Bakery - Cart</title>
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-white text-gray-800 flex flex-col min-h-screen font-poppins">

  @include('layouts.header')

  <main class="flex-1 pt-40 pb-40">
    <!-- Step Indicator -->
    <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-10 max-w-screen-2xl mx-auto w-full px-4 sm:px-6 md:px-10 lg:px-20 text-sm sm:text-base lg:text-lg">
        <div class="bg-[#D6A1A1] text-black px-4 sm:px-6 py-2 sm:py-3 rounded-full font-semibold text-center">1. Cart</div>
        <div class="bg-gray-100 text-gray-600 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-semibold text-center">2. Order Info</div>
        <div class="bg-gray-100 text-gray-600 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-semibold text-center">3. Payment</div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 lg:px-20">
      <div class="flex flex-col lg:flex-row justify-between gap-6">

        <!-- Cart Table -->
        <div class="w-full lg:w-2/3">
          <!-- Header for larger screens -->
          <div class="hidden sm:grid border-b border-gray-300 pb-2 mb-4 uppercase text-lg font-medium text-gray-500 grid-cols-3">
            <div>Items</div>
            <div class="text-center">Qty</div>
            <div class="text-right">Subtotal</div>
          </div>

          <!-- Cart Item Row -->
          <div class="grid grid-cols-1 sm:grid-cols-3 items-center py-4 border-b border-gray-200 text-base gap-y-4">
            <!-- Item Name -->
            <div>
              <div class="font-semibold">Nastar</div>
              <div class="sm:hidden text-sm text-gray-500 mt-1">Subtotal: Rp 168.000</div>
            </div>

            <!-- Quantity & Trash for mobile -->
            <div class="flex justify-between items-center sm:justify-center sm:space-x-4">
              <div class="flex justify-center items-center border border-gray-300 rounded-full overflow-hidden w-fit">
                <button onclick="decrementQty()" class="w-10 h-10 text-lg font-semibold text-gray-600 hover:bg-gray-100 focus:outline-none">−</button>
                <span id="quantity" class="px-4 text-base font-medium">1</span>
                <button onclick="incrementQty()" class="w-10 h-10 text-lg font-semibold text-gray-600 hover:bg-gray-100 focus:outline-none">+</button>
              </div>
              <button class="sm:hidden text-gray-400 hover:text-red-500 ml-2"><i class="fas fa-trash"></i></button>
            </div>

            <!-- Subtotal & Trash for desktop -->
            <div class="hidden sm:flex items-center justify-end space-x-2">
              <span>Rp 168.000</span>
              <button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/3">
          <div class="border p-6 rounded-lg shadow-sm">
            <p class="text-lg font-medium mb-2">Order Subtotal</p>
            <p class="text-xl font-bold mb-6">Rp 168.000</p>
            <a href="{{ route('order.info') }}" class="block bg-[#D6A1A1] hover:bg-rose-400 text-black font-semibold px-6 py-3 rounded-full w-full text-center">
                Continue
              </a>
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('layouts.footer')

  <script>
    let quantity = 1;

    function updateQuantityDisplay() {
      document.getElementById("quantity").innerText = quantity;
    }

    function incrementQty() {
      quantity++;
      updateQuantityDisplay();
    }

    function decrementQty() {
      if (quantity > 1) {
        quantity--;
        updateQuantityDisplay();
      }
    }
  </script>

</body>
</html>
