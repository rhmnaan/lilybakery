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
                <a href="{{ route('admin.orders') }}"
                    class="flex items-center px-6 py-3 rounded-md text-gray-900 font-semibold bg-[#F9D8D9]">
                    {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Orders = User (Profil) --}}
                    <i class="fas fa-shopping-bag mr-3 text-xl"></i> {{-- Changed icon to shopping-bag as it fits orders
                    better --}}
                    <span>Orders</span>
                </a>

                {{-- Customers --}}
                <a href="{{ route('admin.customers') }}"
                    class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                    {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Customers = User (Profil) --}}
                    <i class="far fa-user mr-3 text-xl"></i>
                    <span>Customers</span>
                </a>

                {{-- Setting --}}
                <a href="{{ route('admin.settings') }}"
                    class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                    {{-- ICON TETAP SESUAI GAMBAR: Setting = Cog --}}
                    <i class="fas fa-cog mr-3 text-xl"></i>
                    <span>Setting</span>
                </a>

                {{-- Logout Button with Confirmation --}}
                {{-- Logout Button with SweetAlert Confirmation --}}
                <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" class="block w-full">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-6 py-3 rounded-md text-gray-700 hover:bg-red-100 hover:text-red-700">
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
                        <button id="open-dataModal"
                            class="bg-[#FEE2E2] hover:bg-[#E59CAA] font-semibold py-2 px-5 rounded-lg flex items-center shadow-md">
                            <i class="fas fa-file-excel mr-2"></i>
                            Unduh Data Penjualan Excel
                        </button>
                        <button onclick="openOrderModal()" id="openModal"
                            class="bg-[#FEE2E2] hover:bg-[#E59CAA] font-semibold py-2 px-5 rounded-lg flex items-center shadow-md">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Pesanan Manual
                        </button>
                    </div>
                </header>

                <!-- Tabs -->
                <section class="mb-4">
                    <div class="flex space-x-10 justify-center mb-6">
                        <a href="{{ route('admin.orders', ['status' => 'all']) }}"
                            class="tab-button {{ $statusFilter == 'all' ? 'bg-pink-200 border-lily-pink-dark' : 'bg-gray-50 border-gray-400' }} shadow-xl text-black px-4 py-2 w-80 rounded-lg text-center">Semua</a>
                        <a href="{{ route('admin.orders', ['status' => 'Diproses']) }}"
                            class="tab-button {{ $statusFilter == 'Diproses' ? 'bg-pink-200 border-lily-pink-dark' : 'bg-gray-50 border-gray-400' }} shadow-xl text-black px-4 py-2 w-80 rounded-lg text-center">Diproses</a>
                        <a href="{{ route('admin.orders', ['status' => 'Dikirim']) }}"
                            class="tab-button {{ $statusFilter == 'Dikirim' ? 'bg-pink-200 border-lily-pink-dark' : 'bg-gray-50 border-gray-400' }} shadow-xl text-black px-4 py-2 w-80 rounded-lg text-center">Dikirim</a>
                        <a href="{{ route('admin.orders', ['status' => 'Selesai']) }}"
                            class="tab-button {{ $statusFilter == 'Selesai' ? 'bg-pink-200 border-lily-pink-dark' : 'bg-gray-50 border-gray-400' }} shadow-xl text-black px-4 py-2 w-80 rounded-lg text-center">Selesai</a>
                        <a href="{{ route('admin.orders', ['status' => 'Dibatalkan']) }}"
                            class="tab-button {{ $statusFilter == 'Dibatalkan' ? 'bg-pink-200 border-lily-pink-dark' : 'bg-gray-50 border-gray-400' }} shadow-xl text-black px-4 py-2 w-80 rounded-lg text-center">Dibatalkan</a>
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
                            @forelse($orders as $order)
                                <tr class="border-b border-gray-400 hover:bg-gray-50">
                                    <td class="py-3 px-2">{{ $order->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                                    <td class="py-3 px-2">
                                        @foreach($order->detailOrder as $detail)
                                            {{ $detail->jumlah }}x {{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}<br>
                                        @endforeach
                                    </td>
                                    <td class="py-3 px-2">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $color = match ($order->status) {
                                                'Diproses' => 'bg-yellow-100 text-yellow-600',
                                                'Dikirim' => 'bg-blue-100 text-blue-600',
                                                'Selesai' => 'bg-green-100 text-green-600',
                                                'Dibatalkan' => 'bg-red-100 text-red-600',
                                                default => 'bg-gray-100 text-gray-600',
                                            };
                                        @endphp
                                        <span class="{{ $color }} px-2 py-1 rounded">{{ $order->status }}</span>
                                    </td>
                                    <td class="py-3 px-2">
                                        {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}
                                    </td>
                                    <td class="flex space-x-2 py-3">
                                        <button onclick="openEditModal({{ $order->id_order }})" title="Edit"><i
                                                class="fas fa-edit text-lily-pink"></i></button>
                                        <button onclick="openDeleteModal({{ $order->id_order }})" title="Delete"><i
                                                class="fas fa-trash text-lily-pink-dark"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-500">
                                        Tidak ada pesanan dengan status ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="flex justify-between mt-6 px-4 text-sm text-gray-700 font-medium">
                        <div>
                            Total Pesanan Hari ini:
                            <span class="font-semibold text-lg">{{ $orders->count() }} pesanan</span>
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
                        <select name="id_pelanggan" id="id_pelanggan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
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
                                <select name="produk[]"
                                    class="produkSelect w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                    <option value="" disabled selected>Pilih produk</option>
                                    @foreach($produk as $p)
                                        <option value="{{ $p->kode_produk }}" data-harga="{{ $p->harga }}">
                                            {{ $p->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Jumlah</label>
                                <input type="number" name="jumlah[]"
                                    class="jumlahInput w-20 px-3 py-2 border border-gray-300 rounded-lg" value="0"
                                    min="1" required>
                            </div>
                            <button type="button" class="removeItemBtn self-end text-[#F87171] text-3xl font-bold mb-2"
                                title="Hapus item">&times;</button>
                        </div>
                    </div>
                    <button type="button" id="addProdukBtn" class="mb-4 text-[#DB2777] hover:text-lily-pink">Tambah
                        Produk</button>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Total Harga</label>
                        <input type="text" id="totalHarga" name="total"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
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
                        <button type="button" id="closeModal"
                            class="px-4 py-2 rounded-lg bg-white border text-gray-700 hover:bg-gray-100">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Pesanan -->
        <div id="editOrderModal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-pink-100 rounded-lg p-8 w-full max-w-md shadow-xl relative max-h-[90vh] overflow-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Pesanan</h2>

                <form id="editOrderForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" id="editOrderId">

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" id="editNamaPelanggan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" required readonly>
                    </div>

                    <div id="produkContainerEdit">
                        <div class="flex gap-5 mb-4 produk-item">
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">Produk</label>
                                <select name="produk[]"
                                    class="produkSelect w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                    <option value="" disabled selected>Pilih produk</option>
                                    @foreach($produk as $p)
                                        <option value="{{ $p->kode_produk }}" data-harga="{{ $p->harga }}">
                                            {{ $p->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Jumlah</label>
                                <input type="number" name="jumlah[]"
                                    class="jumlahInput w-20 px-3 py-2 border border-gray-300 rounded-lg" value="0"
                                    min="1" required>
                            </div>
                            <button type="button" class="removeItemBtn self-end text-[#F87171] text-3xl font-bold mb-2"
                                title="Hapus item">&times;</button>
                        </div>
                    </div>

                    <button type="button" id="addProdukBtnEdit" class="mb-4 text-[#DB2777] hover:text-lily-pink">Tambah
                        Produk</button>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Total Harga</label>
                        <input type="text" id="editTotalHarga" name="total"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" id="editStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                            required>
                            <option value="Belum Dibayar">Belum Dibayar</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" id="closeEditModal"
                            class="px-4 py-2 bg-white rounded-lg hover:bg-gray-200">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Unduh Data Penjualan-->
        <div id="dataModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-pink-100 rounded-lg p-8 w-full max-w-md shadow-xl relative">
                <button id="close-dataModal"
                    class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-xl font-bold">
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
                            <input type="date" name="tanggal-awal"
                                class="w-full px-2 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div class="text-sm font-medium mb-1">
                            Tanggal Akhir
                            <input type="date" name="tanggal-akhir"
                                class="w-full px-2 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-full  justify-center px-4 py-2 rounded-lg bg-lily-pink-dark text-white hover:bg-pink-600">Unduh
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Konfirmasi Hapus -->
        <div id="confirmDeleteModal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-pink-100 rounded-lg p-6 w-full max-w-md shadow-xl relative">
                <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Konfirmasi Hapus</h2>
                <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus pesanan ini?</p>

                <form id="deleteOrderForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center space-x-4">
                        <button type="button" id="cancelDeleteBtn"
                            class="px-4 py-2 w-full bg-white rounded-lg hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 w-full bg-lily-pink-dark text-white rounded-lg hover:bg-pink-500">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- Modal Logic ---
        const orderModal = document.getElementById('orderModal');
        const editOrderModal = document.getElementById('editOrderModal');
        const deleteModal = document.getElementById('confirmDeleteModal');
        const dataModal = document.getElementById('dataModal');

        // -- Open/Close Add Modal --
        function openOrderModal() {
            document.getElementById('orderForm').reset();
            document.getElementById('produkContainer').innerHTML = createProdukItemHTML(); // Reset ke 1 item
            attachEventListenersToContainer(document.getElementById('produkContainer'));
            updateTotalHarga();
            orderModal.classList.remove('hidden');
        }
        document.getElementById('openModal').addEventListener('click', openOrderModal);
        document.getElementById('closeModal').addEventListener('click', () => orderModal.classList.add('hidden'));

        // -- Open/Close Edit Modal --
        async function openEditModal(orderId) {
            try {
                const response = await fetch(`/admin/orders/${orderId}/edit`);
                if (!response.ok) throw new Error('Gagal mengambil data pesanan.');
                const order = await response.json();

                document.getElementById('editOrderForm').action = `/admin/orders/${order.id_order}`;
                document.getElementById('editNamaPelanggan').value = order.pelanggan.nama_pelanggan;
                document.getElementById('editStatus').value = order.status;

                const container = document.getElementById('produkContainerEdit');
                container.innerHTML = ''; // Kosongkan container
                order.detail_order.forEach(detail => {
                    const itemHTML = createProdukItemHTML(detail.kode_produk, detail.jumlah);
                    container.insertAdjacentHTML('beforeend', itemHTML);
                });

                attachEventListenersToContainer(container, 'edit');
                updateTotalHarga('edit');
                editOrderModal.classList.remove('hidden');

            } catch (error) {
                Swal.fire('Error', error.message, 'error');
            }
        }
        document.getElementById('closeEditModal').addEventListener('click', () => editOrderModal.classList.add('hidden'));

        // -- Open/Close Delete Modal --
        function openDeleteModal(orderId) {
            document.getElementById('deleteOrderForm').action = `/admin/orders/${orderId}`;
            deleteModal.classList.remove('hidden');
        }
        document.getElementById('cancelDeleteBtn').addEventListener('click', () => deleteModal.classList.add('hidden'));

        // -- Open/Close Data Export Modal --
        document.getElementById('open-dataModal').addEventListener('click', () => dataModal.classList.remove('hidden'));
        document.getElementById('close-dataModal').addEventListener('click', () => dataModal.classList.add('hidden'));


        // --- Dynamic Product Items Logic ---
        const allProdukOptions = `{!! addslashes(json_encode($produk->map(fn($p) => ['value' => $p->kode_produk, 'text' => $p->nama_produk, 'harga' => $p->harga])->all())) !!}`;

        function createProdukItemHTML(selectedProduk = '', selectedJumlah = 1) {
            const produkList = JSON.parse(allProdukOptions);
            let optionsHTML = '<option value="" disabled selected>Pilih produk</option>';
            produkList.forEach(p => {
                const isSelected = p.value == selectedProduk ? 'selected' : '';
                optionsHTML += `<option value="${p.value}" data-harga="${p.harga}" ${isSelected}>${p.text}</option>`;
            });
            return `
                <div class="flex gap-5 mb-4 produk-item">
                    <div class="w-full">
                        <select name="produk[]" class="produkSelect w-full px-3 py-2 border border-gray-300 rounded-lg" required>${optionsHTML}</select>
                    </div>
                    <div>
                        <input type="number" name="jumlah[]" class="jumlahInput w-20 px-3 py-2 border border-gray-300 rounded-lg" value="${selectedJumlah}" min="1" required>
                    </div>
                    <button type="button" class="removeItemBtn self-end text-[#F87171] text-3xl font-bold mb-2" title="Hapus item">&times;</button>
                </div>
            `;
        }

        function attachEventListenersToContainer(container, type = 'add') {
            container.addEventListener('change', (e) => {
                if (e.target.classList.contains('produkSelect')) updateTotalHarga(type);
            });
            container.addEventListener('input', (e) => {
                if (e.target.classList.contains('jumlahInput')) updateTotalHarga(type);
            });
            container.addEventListener('click', (e) => {
                if (e.target.classList.contains('removeItemBtn')) {
                    if (container.querySelectorAll('.produk-item').length > 1) {
                        e.target.closest('.produk-item').remove();
                        updateTotalHarga(type);
                    } else {
                        Swal.fire('Info', 'Minimal harus ada satu produk dalam pesanan.', 'info');
                    }
                }
            });
        }

        document.getElementById('addProdukBtn').addEventListener('click', () => {
            document.getElementById('produkContainer').insertAdjacentHTML('beforeend', createProdukItemHTML());
        });
        document.getElementById('addProdukBtnEdit').addEventListener('click', () => {
            document.getElementById('produkContainerEdit').insertAdjacentHTML('beforeend', createProdukItemHTML());
        });

        function updateTotalHarga(type = 'add') {
            const container = (type === 'edit') ? document.getElementById('produkContainerEdit') : document.getElementById('produkContainer');
            const totalInput = (type === 'edit') ? document.getElementById('editTotalHarga') : document.getElementById('totalHarga');
            let total = 0;
            container.querySelectorAll('.produk-item').forEach(item => {
                const select = item.querySelector('select.produkSelect');
                const jumlah = parseInt(item.querySelector('input.jumlahInput').value) || 0;
                const harga = select.selectedOptions[0]?.dataset?.harga || 0;
                total += harga * jumlah;
            });
            totalInput.value = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Initial setup for the add form
        attachEventListenersToContainer(document.getElementById('produkContainer'));

        // --- Logout Confirmation ---
        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan keluar dari sesi admin ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e879a0',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Logout!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        }
    </script>
@endpush

@endsection