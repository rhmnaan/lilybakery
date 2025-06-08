@extends('layouts.admin')

@section('content')
    <div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
        <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden">
            {{-- Sidebar --}}
            <div class="w-64 bg-[#FFF7F3] pt-4">
                <div class="p-4">
                    <div class="flex flex-col items-center justify-center bg-[#E59CAA] rounded-lg py-4 px-2 mb-6 shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Lily Bakery">
                    </div>
                </div>
                <nav class="mt-2 space-y-1">
                    {{-- Dashboard Link (Active State) --}}
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]
                    @if(Request::routeIs('admin.dashboard')) bg-[#F9D8D9] text-gray-900 font-semibold @endif">
                    {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Dashboard = Check Circle --}}
                        <i class="far fa-check-circle mr-3 text-xl"></i>
                        <span>Dashboard</span>
                    </a>

                    {{-- Product Link --}}
                    <a href="{{ route('admin.product') }}"
                        class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Product = Edit (Pensil) --}}
                        <i class="far fa-edit mr-3 text-xl"></i>
                        <span>Product</span>
                    </a>

                    {{-- Orders --}}
                    <a href="{{ route('admin.orders') }}" class="flex items-center px-6 py-3 rounded-md text-gray-900 font-semibold bg-[#F9D8D9]">
                        {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Orders = User (Profil) --}}
                        <i class="fas fa-shopping-bag mr-3 text-xl"></i> {{-- Changed icon to shopping-bag as it fits orders better --}}
                        <span>Orders</span>
                    </a>

                    {{-- Customers --}}
                    <a href="{{ route('admin.customers') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Customers = User (Profil) --}}
                        <i class="far fa-user mr-3 text-xl"></i>
                        <span>Customers</span>
                    </a>

                    {{-- Setting --}}
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        {{-- ICON TETAP SESUAI GAMBAR: Setting = Cog --}}
                        <i class="fas fa-cog mr-3 text-xl"></i>
                        <span>Setting</span>
                    </a>

                    {{-- Logout Button with Confirmation --}}
                    {{-- Logout Button with SweetAlert Confirmation --}}
                    <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" class="block w-full">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-6 py-3 rounded-md text-gray-700 hover:bg-red-100 hover:text-red-700">
                            <i class="fas fa-sign-out-alt mr-3 text-xl"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <section class="flex-1 p-8 overflow-y-auto">
                <div class="bg-[#FEF2F2] shadow-xl w-full h-full rounded-xl px-10 py-10">
                    <header class="flex justify-between items-center mb-10">
                        <h1 class="text-4xl font-bold text-gray-800">Pesanan Hari ini</h1>
                        <div class="flex space-x-4">
                            <button id="open-dataModal" class="bg-[#FEE2E2] hover:bg-[#E59CAA] font-semibold py-2 px-5 rounded-lg flex items-center shadow-md">
                                <i class="fas fa-file-excel mr-2"></i>
                                Unduh Data Penjualan Excel
                            </button>
                            <button onclick="openOrderModal()" id="openModal" class="bg-[#FEE2E2] hover:bg-[#E59CAA] font-semibold py-2 px-5 rounded-lg flex items-center shadow-md">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Pesanan Manual
                            </button>
                        </div>
                    </header>

                    <!-- Tabs -->
                    <section class="mb-4">
                        <div class="flex space-x-10 justify-center mb-6">
                            <button class="tab-button bg-pink-200 border border-lily-pink-dark shadow-xl text-black px-4 py-2 w-80 rounded-lg" data-status="all">Semua</button>
                            <button class="tab-button bg-gray-50 border border-gray-400 shadow-xl text-black px-4 py-2 w-80 rounded-lg" data-status="Diproses">Diproses</button>
                            <button class="tab-button bg-gray-50 border border-gray-400 shadow-xl text-black px-4 py-2 w-80 rounded-lg" data-status="Dikirim">Dikirim</button>
                            <button class="tab-button bg-gray-50 border border-gray-400 shadow-xl text-black px-4 py-2 w-80 rounded-lg" data-status="Selesai">Selesai</button>
                            <button class="tab-button bg-gray-50 border border-gray-400 shadow-xl text-black px-4 py-2 w-80 rounded-lg" data-status="Dibatalkan">Dibatalkan</button>
                        </div>
                    </section>

                    <!-- Table Section -->
                    <section class="bg-white rounded-xl shadow p-4">
                        <table class="w-full table-auto text-left border-2 border-gray-400 ">
                            <thead class="border-2 border-gray-400 h-12">
                                <tr class="text-black text-left">
                                    <th class="px-2">Nama Pelanggan</th>
                                    <th class="px-2">Produk</th>
                                    <th class="px-2">Total</th>
                                    <th class="px-2">Status</th>
                                    <th class="px-2">Tanggal</th>
                                    <th class="px-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-black text-left">
                                @if($orders->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center py-6 text-gray-500">
                                            Tidak ada pesanan hari ini.
                                        </td>
                                    </tr>
                                @else
                                    @foreach($orders as $order)
                                    <tr class="border-b border-gray-400 hover:bg-gray-50 order-row" data-status="{{ $order->status }}">
                                        <td class="py-3 px-2">{{ $order->nama_pelanggan }}</td>
                                        <td class="py-3 px-2">{{ $order->jumlah }}x {{ $order->nama_produk }}</td>
                                        <td class="py-3 px-2">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $color = match($order->status) {
                                                    'Belum Dibayar' => 'bg-gray-100 text-gray-600',
                                                    'Diproses' => 'bg-yellow-100 text-yellow-600',
                                                    'Dikirim' => 'bg-blue-100 text-blue-600',
                                                    'Selesai' => 'bg-green-100 text-green-600',
                                                    'Dibatalkan' => 'bg-red-100 text-red-600',
                                                    default => 'bg-gray-100 text-gray-600',
                                                };
                                            @endphp
                                            <span class="{{ $color }} px-2 py-1 rounded">{{ $order->status }}</span>
                                        </td>
                                        <td class="py-3 px-2">{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}</td>
                                        <td class="flex space-x-2 py-3">
                                            <button id="edit" title="Edit"><i class="fas fa-edit text-lily-pink"></i></button>
                                            <button id="delete" title="Delete"><i class="fas fa-trash text-lily-pink-dark"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="flex justify-between mt-6 px-4 text-sm text-gray-700 font-medium">
                            <div>
                                Total Pesanan Hari ini: 
                                <span class= "font-semibold text-lg">{{ $orders->count() }} pesanan</span>
                            </div>
                            <div>
                                Total Pendapatan Hari ini: 
                                <br>
                                <span class=" font-semibold text-3xl">
                                    Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
            <!-- Modal Tambah Pesanan -->
            <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                <div class="bg-pink-100 rounded-lg p-8 w-full max-w-md shadow-xl relative max-h-[90vh] overflow-auto">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tambah Pesanan</h2>
                    <form action="" method="POST" id="orderForm">
                        @csrf
                        <div class="mb-4">
                            <label for="id_pelanggan" class="block text-sm font-medium mb-1">Nama Pelanggan</label>
                            <select name="id_pelanggan" id="id_pelanggan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($pelanggans as $p)
                                    <option value="{{ $p->id_pelanggan }}">{{ $p->nama_pelanggan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="produkContainer">
                            <div class="flex gap-5 mb-4 produk-item">
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Produk</label>
                                    <select name="produk[]" class="produkSelect w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                        <option value="" disabled selected>Pilih produk</option>
                                        @foreach($produk as $p)
                                            <option value="{{ $p->kode_produk }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Jumlah</label>
                                    <input type="number" name="jumlah[]" class="jumlahInput w-20 px-3 py-2 border border-gray-300 rounded-lg" value="0" min="1" required>
                                </div>
                                <button type="button" class="removeItemBtn self-end text-[#F87171] text-3xl font-bold mb-2" title="Hapus item">&times;</button>
                            </div>
                        </div>
                        <button type="button" id="addProdukBtn" class="mb-4 text-[#DB2777] hover:text-lily-pink">Tambah Produk</button>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Total Harga</label>
                            <input type="text" id="totalHarga" name="total" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" id="closeModal" class="px-4 py-2 rounded-lg bg-white border text-gray-700 hover:bg-gray-100">Batal</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Pesanan -->
            <div id="editOrderModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                <div class="bg-pink-100 rounded-lg p-8 w-full max-w-md shadow-xl relative max-h-[90vh] overflow-auto">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Pesanan</h2>

                    <form id="editOrderForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" id="editOrderId">

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" id="editNamaPelanggan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required readonly>
                        </div>

                        <div id="produkContainerEdit">
                            <div class="flex gap-5 mb-4 produk-item">
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Produk</label>
                                    <select name="produk[]" class="produkSelect w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                        <option value="" disabled selected>Pilih produk</option>
                                        @foreach($produk as $p)
                                            <option value="{{ $p->kode_produk }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Jumlah</label>
                                    <input type="number" name="jumlah[]" class="jumlahInput w-20 px-3 py-2 border border-gray-300 rounded-lg" value="0" min="1" required>
                                </div>
                                <button type="button" class="removeItemBtn self-end text-[#F87171] text-3xl font-bold mb-2" title="Hapus item">&times;</button>
                            </div>
                        </div>

                        <button type="button" id="addProdukBtnEdit" class="mb-4 text-[#DB2777] hover:text-lily-pink">Tambah Produk</button>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Total Harga</label>
                            <input type="text" id="editTotalHarga" name="total" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select name="status" id="editStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" id="closeEditModal" class="px-4 py-2 bg-white rounded-lg hover:bg-gray-200">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal Unduh Data Penjualan-->
            <div id="dataModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                <div class="bg-pink-100 rounded-lg p-8 w-full max-w-md shadow-xl relative">
                    <button id="close-dataModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-xl font-bold">
                        &times;
                    </button>

                    <h1 class="text-2xl font-bold text-gray-800 mb-10 text-center flex items-center justify-center gap-2">
                        <img src="/images/Logo-Excel.png" alt="Logo" class="h-10 w-10">
                        Unduh Data Penjualan
                    </h1>

                    <form action="{{ route('admin.orders.data') }}" method="POST">
                        @csrf
                        <div class="mb-4 flex gap-10">
                            <div class="text-sm font-medium mb-1">
                                Tanggal Awal
                                <input type="date" name="tanggal-awal" class="w-full px-2 py-2 border border-gray-300 rounded-lg" required>
                            </div>
                            <div class="text-sm font-medium mb-1">
                                Tanggal Akhir
                                <input type="date" name="tanggal-akhir" class="w-full px-2 py-2 border border-gray-300 rounded-lg" required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="w-full  justify-center px-4 py-2 rounded-lg bg-lily-pink-dark text-white hover:bg-pink-600">Unduh Data</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal Konfirmasi Hapus -->
            <div id="confirmDeleteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                <div class="bg-pink-100 rounded-lg p-6 w-full max-w-md shadow-xl relative">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Konfirmasi Hapus</h2>
                    <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus pesanan ini?</p>

                    <form id="deleteOrderForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="flex justify-center space-x-4">
                            <button type="button" id="cancelDeleteBtn" class="px-4 py-2 w-full bg-white rounded-lg hover:bg-gray-400">Batal</button>
                            <button type="submit" class="px-4 py-2 w-full bg-lily-pink-dark text-white rounded-lg hover:bg-pink-500">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mengatur Tab status (filter data)
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.tab-button');
            const rows = document.querySelectorAll('.order-row');

            function filterRows(status) {
                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    row.style.display = (status === 'all' || rowStatus === status) ? '' : 'none';
                });
            }

            function setActiveTab(activeButton) {
                buttons.forEach(button => {
                    button.classList.remove('bg-pink-200', 'border', 'border-lily-pink-dark');
                    button.classList.add('bg-gray-50', 'border', 'border-gray-400');
                });

                activeButton.classList.remove('bg-gray-50');
                activeButton.classList.add('bg-pink-200', 'border', 'border-lily-pink-dark');
            }
            
            const defaultButton = document.querySelector('.tab-button[data-status="all"]');
            setActiveTab(defaultButton);
            filterRows('all');

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const status = button.getAttribute('data-status');
                    setActiveTab(button);
                    filterRows(status);
                });
            });
        });

        //Untuk Modal Form Tambah Pesanan
        document.addEventListener('DOMContentLoaded', () => {
            const orderModal = document.getElementById('orderModal');
            const closeModalBtn = document.getElementById('closeModal');
            const addProdukBtn = document.getElementById('addProdukBtn');
            const produkContainer = document.getElementById('produkContainer');
            const totalHargaInput = document.getElementById('totalHarga');

            // Fungsi untuk update total harga
            function updateTotalHarga() {
                let total = 0;

                const produkItems = produkContainer.querySelectorAll('.produk-item');
                produkItems.forEach(item => {
                const produkSelect = item.querySelector('select.produkSelect');
                const jumlahInput = item.querySelector('input.jumlahInput');

                const harga = produkSelect.selectedOptions[0]?.dataset?.harga || 0;
                const jumlah = parseInt(jumlahInput.value) || 0;

                total += harga * jumlah;
                });

                totalHargaInput.value = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            }

            // Fungsi untuk membuat produk item baru
            function buatProdukItem() {
                const produkItem = document.createElement('div');
                produkItem.classList.add('flex', 'gap-5', 'mb-4', 'produk-item');

                produkItem.innerHTML = `
                <div class="w-full">
                    <select name="produk[]" class="produkSelect w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                    <option value="" disabled selected>Pilih produk</option>
                    @foreach($produk as $p)
                        <option value="{{ $p->kode_produk }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }}</option>
                    @endforeach
                    </select>
                </div>
                <div>
                    <input type="number" name="jumlah[]" class="jumlahInput w-20 px-3 py-2 border border-gray-300 rounded-lg" value="0" min="1" required>
                </div>
                <button type="button" class="removeItemBtn self-end text-[#F87171] font-bold text-3xl mb-2" title="Hapus item">&times;</button>
                `;

                // Tambah event listener untuk select dan input jumlah di item baru
                const select = produkItem.querySelector('select.produkSelect');
                const jumlahInput = produkItem.querySelector('input.jumlahInput');
                const removeBtn = produkItem.querySelector('button.removeItemBtn');

                select.addEventListener('change', updateTotalHarga);
                jumlahInput.addEventListener('input', updateTotalHarga);

                removeBtn.addEventListener('click', () => {
                produkItem.remove();
                updateTotalHarga();
                });

                return produkItem;
            }

            // Tambah produk baru saat tombol tambah diklik
            addProdukBtn.addEventListener('click', () => {
                const newProdukItem = buatProdukItem();
                produkContainer.appendChild(newProdukItem);
            });

            // Event untuk tombol hapus produk di produk awal
            produkContainer.querySelectorAll('.produk-item').forEach(item => {
                const select = item.querySelector('select.produkSelect');
                const jumlahInput = item.querySelector('input.jumlahInput');
                const removeBtn = item.querySelector('button.removeItemBtn');

                select.addEventListener('change', updateTotalHarga);
                jumlahInput.addEventListener('input', updateTotalHarga);

                removeBtn.addEventListener('click', () => {
                    item.remove();
                    updateTotalHarga();
                });
            });

            // Close modal button
            closeModalBtn.addEventListener('click', () => {
                orderModal.classList.add('hidden');
            });

            // Jika ingin modal bisa dibuka dengan fungsi
            window.openOrderModal = function () {
                orderModal.classList.remove('hidden');
            };

            // Fungsi reset form tambah pesanan
            function resetOrderForm() {
                document.getElementById('orderForm').reset();
                totalHargaInput.value = '';

                const items = produkContainer.querySelectorAll('.produk-item');
                items.forEach((item, idx) => {
                    if (idx > 0) item.remove(); // Hapus tambahan
                });

                // Sembunyikan tombol hapus di produk pertama
                const firstRemoveBtn = produkContainer.querySelector('.produk-item .removeItemBtn');
                if (firstRemoveBtn) {
                    firstRemoveBtn.style.display = 'none';
                }
            }

            // Fungsi buka modal
            window.openOrderModal = function () {
                orderModal.classList.remove('hidden');
                resetOrderForm(); // Reset langsung saat dibuka
            };

            // Fungsi tutup modal & reset jika klik "Batal"
            closeModalBtn.addEventListener('click', () => {
                orderModal.classList.add('hidden');
                resetOrderForm(); // Reset juga saat ditutup
            });

            // Update total harga awal (jika ada produk default)
            updateTotalHarga();

            // Sembunyikan tombol hapus untuk produk pertama
            const firstRemoveBtn = produkContainer.querySelector('.produk-item .removeItemBtn');
            if (firstRemoveBtn) {
                firstRemoveBtn.style.display = 'none';
            }
        });

        // Mengatur Modal Data Penjualan (Excel)
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('dataModal');
            const openBtn = document.getElementById('open-dataModal');
            const closeBtn = document.getElementById('close-dataModal');

            openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
            closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        });

        function updateEditTotalHarga() {
            let total = 0;
            const container = document.getElementById('produkContainerEdit');
            const items = container.querySelectorAll('.produk-item');

            items.forEach(item => {
                const select = item.querySelector('select.produkSelect');
                const jumlah = parseInt(item.querySelector('input.jumlahInput').value) || 0;
                const harga = parseInt(select.selectedOptions[0]?.dataset.harga || 0);

                total += harga * jumlah;
            });

            document.getElementById('editTotalHarga').value = total.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
        }

        document.querySelectorAll('button#edit').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr');
                const orderId = row.getAttribute('data-id');
                const namaPelanggan = row.children[0].innerText.trim();
                const produkText = row.children[1].innerText.trim(); // contoh: "3x Roti Tawar"
                const total = row.children[2].innerText.replace(/[^\d]/g, '');
                const status = row.getAttribute('data-status');

                // Parsing produk dan jumlah
                const [jumlah, ...produkArr] = produkText.split('x');
                const namaProduk = produkArr.join('x').trim();

                // Tampilkan modal
                const modal = document.getElementById('editOrderModal');
                modal.classList.remove('hidden');

                // Isi form data dasar
                document.getElementById('editOrderId').value = orderId;
                document.getElementById('editNamaPelanggan').value = namaPelanggan;
                document.getElementById('editTotalHarga').value = total;
                document.getElementById('editStatus').value = status;
                document.getElementById('editOrderForm').action = `/admin/orders/${orderId}`;

                // Bersihkan produk-item lama
                const container = document.getElementById('produkContainerEdit');
                container.innerHTML = '';

                // Buat produk-item baru
                const produkItem = document.createElement('div');
                produkItem.classList.add('flex', 'gap-5', 'mb-4', 'produk-item');
                produkItem.innerHTML = `
                    <div class="w-full">
                        <select name="produk[]" class="produkSelect w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                            <option value="" disabled>Pilih produk</option>
                            ${[...document.querySelectorAll('#produkContainer select option')].map(opt => {
                                const selected = opt.textContent.trim() === namaProduk ? 'selected' : '';
                                return `<option value="${opt.value}" data-harga="${opt.dataset.harga}" ${selected}>${opt.textContent}</option>`;
                            }).join('')}
                        </select>
                    </div>
                    <div>
                        <input type="number" name="jumlah[]" class="jumlahInput w-20 px-3 py-2 border border-gray-300 rounded-lg" value="${jumlah.trim()}" min="1" required>
                    </div>
                    <button type="button" class="removeItemBtn self-end text-[#F87171] text-3xl font-bold mb-2" title="Hapus item">&times;</button>
                `;

                // Event listener tombol hapus
                produkItem.querySelector('.removeItemBtn').addEventListener('click', () => {
                    produkItem.remove();
                    updateEditTotalHarga(); // pastikan fungsi ini ada
                });

                // Event listener untuk update total saat edit
                produkItem.querySelector('.produkSelect').addEventListener('change', updateEditTotalHarga);
                produkItem.querySelector('.jumlahInput').addEventListener('input', updateEditTotalHarga);

                container.appendChild(produkItem);

                updateEditTotalHarga(); // Recalculate total
            });
        });
        

        // Tombol Close Modal Edit
        document.getElementById('closeEditModal').addEventListener('click', () => {
            document.getElementById('editOrderModal').classList.add('hidden');
        });

        //Konfirmasi Hapus Data
        document.querySelectorAll('button#delete').forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.dataset.id;
                const form = document.getElementById('deleteOrderForm');
                form.action = `/admin/orders/${orderId}`;
                document.getElementById('confirmDeleteModal').classList.remove('hidden');
            });
        });

        document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
            document.getElementById('confirmDeleteModal').classList.add('hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            // --- Konfirmasi Logout dengan SweetAlert2 ---
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah form disubmit secara default

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan keluar dari sesi admin ini!",
                        icon: 'warning', // Bisa 'success', 'error', 'info', 'question'
                        showCancelButton: true,
                        confirmButtonColor: '#e879a0', // Warna pink yang cocok dengan tema Anda
                        cancelButtonColor: '#6c757d', // Warna abu-abu untuk tombol batal
                        confirmButtonText: 'Ya, Logout!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika user mengklik 'Ya, Logout!', submit form
                            this.submit();
                        }
                    });
                });
            }
        });
    </script>
    @endpush

@endsection
