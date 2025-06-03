@extends('layouts.admin')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md h-screen">
            <div class="p-4 lily-pink">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Lily Bakery" class="w-[250px] mb-2">
                </div>
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-birthday-cake mr-3"></i>
                    <span>Product</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 text-gray-700 bg-pink-200">
                    <i class="fas fa-shopping-bag mr-3"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('admin.customers') }}" class="flex items-center px-4 py-3 text-gray-800 hover:bg-pink-200">
                    <i class="fas fa-users mr-3"></i>
                    <span>Customers</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Setting</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <section class="flex-1 p-8 overflow-y-auto">
            <div class="bg-pink-50 border border-lily-pink shadow-xl w-full h-full rounded-xl px-10 py-10">
                <header class="flex justify-between items-center mb-10">
                    <h1 class="text-4xl font-bold text-gray-800">Pesanan Hari ini</h1>
                    <div class="flex space-x-4">
                        <button id="open-dataModal" class="bg-pink-200 border border-lily-pink-dark text-black px-4 py-2 rounded-lg hover:bg-pink-500 flex items-center">
                            <i class="fas fa-file-excel mr-2"></i>
                            Unduh Data Penjualan Excel
                        </button>
                        <button id="openModal" class="bg-pink-200 text-black border border-lily-pink-dark px-4 py-2 rounded-lg hover:bg-pink-500 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Pesanan Manual
                        </button>
                    </div>
                </header>

                <!-- Tabs -->
                <section class="mb-4">
                    <div class="flex space-x-10 justify-center mb-6">
                        <button class="tab-button bg-pink-200 border border-lily-pink-dark text-black px-4 py-2 w-80 rounded-lg" data-status="all">Semua</button>
                        <button class="tab-button bg-gray-50 border border-gray-400 text-black px-4 py-2 w-80 rounded-lg" data-status="Diproses">Diproses</button>
                        <button class="tab-button bg-gray-50 border border-gray-400 text-black px-4 py-2 w-80 rounded-lg" data-status="Dikirim">Dikirim</button>
                        <button class="tab-button bg-gray-50 border border-gray-400 text-black px-4 py-2 w-80 rounded-lg" data-status="Selesai">Selesai</button>
                        <button class="tab-button bg-gray-50 border border-gray-400 text-black px-4 py-2 w-80 rounded-lg" data-status="Dibatalkan">Dibatalkan</button>
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
                            <span class="text-pink-600 font-semibold text-lg">{{ $orders->count() }} pesanan</span>
                        </div>
                        <div>
                            Total Pendapatan Hari ini: 
                            <br>
                            <span class="text-green-700 font-semibold text-3xl">
                                Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <!-- Modal Tambah Pesanan -->
        <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-pink-100 rounded-lg p-8 w-full max-w-md shadow-xl relative">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tambah Pesanan</h2>

                <form action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ketikkan nama..." required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Produk</label>
                        <select id="produkSelect" name="produk" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                            <option value="" disabled selected>Pilih produk</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->kode_produk }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlahInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="0" min="1" required>
                    </div>

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
        <!-- Modal Edit Pesanan -->
        <div id="editOrderModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-pink-100 rounded-lg p-8 w-full max-w-md shadow-xl relative">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Pesanan</h2>

                <form id="editOrderForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" id="editOrderId">

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" id="editNamaPelanggan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Produk</label>
                        <select id="editProdukSelect" name="produk" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                            <option value="" disabled>Pilih produk</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->kode_produk }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jumlah</label>
                        <input type="number" name="jumlah" id="editJumlahInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg" min="1" required>
                    </div>

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

@include('layouts.footer-admin')

@push('scripts')
<script>
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

        // Set default tab (Semua)
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

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('orderModal');
        const openBtn = document.getElementById('openModal');
        const closeBtn = document.getElementById('closeModal');
        const produkSelect = document.getElementById('produkSelect');
        const jumlahInput = document.getElementById('jumlahInput');
        const totalHarga = document.getElementById('totalHarga');

        function updateTotal() {
            const selected = produkSelect.options[produkSelect.selectedIndex];
            const harga = parseInt(selected.getAttribute('data-harga')) || 0;
            const jumlah = parseInt(jumlahInput.value) || 0;
            const total = harga * jumlah;
            totalHarga.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
        }

        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));

        produkSelect.addEventListener('change', updateTotal);
        jumlahInput.addEventListener('input', updateTotal);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('dataModal');
        const openBtn = document.getElementById('open-dataModal');
        const closeBtn = document.getElementById('close-dataModal');

        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    });

    document.querySelectorAll('button#edit').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const cells = row.querySelectorAll('td');
            const orderId = row.dataset.orderId;

            document.getElementById('editOrderModal').classList.remove('hidden');
            document.getElementById('editOrderId').value = orderId;
            document.getElementById('editNamaPelanggan').value = cells[0].innerText;
            document.getElementById('editJumlahInput').value = parseInt(cells[1].innerText);
            document.getElementById('editTotalHarga').value = cells[2].innerText;
            document.getElementById('editStatus').value = row.dataset.status;

            // Set form action URL dynamically
            document.getElementById('editOrderForm').action = `/admin/orders/${orderId}`;
        });
    });

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
</script>
@endpush

@endsection
