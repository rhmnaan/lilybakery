@extends('layouts.admin')

@section('content')
<div class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md h-auto">
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
                <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-200">
                    <i class="fas fa-shopping-bag mr-3"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('admin.customers') }}" class="flex items-center px-4 py-3 bg-pink-200 text-gray-800 ">
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
        <div class="flex-1 p-8">
            <div class="bg-pink-50 border border-lily-pink shadow-xl w-full h-full rounded-xl px-10 py-10">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Customers</h1>
                    <button onclick="openAddModal()" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Customers
                    </button>
                </div>
                
            <!-- Filter Tabs -->
            <div class="mb-6">
                <div class="flex space-x-1 bg-white rounded-lg p-1 shadow-sm w-fit">
                    <button onclick="filterCustomers('all')" id="tab-all" class="px-6 py-2 rounded-md text-sm font-medium transition-colors bg-pink-200 text-pink-800">
                        Semua
                    </button>
                    <button onclick="filterCustomers('active')" id="tab-active" class="px-6 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:text-gray-800">
                        Aktif
                    </button>
                    <button onclick="filterCustomers('inactive')" id="tab-inactive" class="px-6 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:text-gray-800">
                        Nonaktif
                    </button>
                </div>
            </div>
            
            <!-- Customers Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto px-6 py-4">
                    <table class="min-w-full bg-white border-2 border-gray-400">
                        <thead class="h-12 border-2 border-gray-400">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-black uppercase tracking-wider">
                                    Nama Pelanggan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-black uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-black uppercase tracking-wider">
                                    No. Telepon
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-black uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-black uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="customers-table-body" class="bg-white">
                            @foreach($customers as $customer)
                                <tr class="border-2 border-gray-400" data-status="{{ $customer->status }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-black">{{ $customer->nama_pelanggan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-black">{{ $customer->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-black">{{ $customer->telp }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-black capitalize">{{ $customer->status }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="openDeleteModal('{{ $customer->id_pelanggan }}')" class="text-pink-400 hover:text-pink-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="mt-6 space-y-2 text-sm text-gray-600">
                <div>Jumlah Customers Aktif: <span id="active-count" class="font-semibold">{{ $activeCount }}</span> Akun</div>
                <div>Jumlah Customers Nonaktif: <span id="inactive-count" class="font-semibold">{{ $inactiveCount }}</span> Akun</div>
                <div>Jumlah Customers: <span id="total-count" class="font-semibold">{{ $totalCount }}</span> Akun</div>
            </div>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-pink-200 rounded-lg p-6 max-w-sm mx-4">
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Konfirmasi Hapus</h2>
        <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus pesanan ini?</p>
        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Batal
            </button>
            <button onclick="confirmDelete()" class="flex-1 px-4 py-2 bg-lily-pink-dark text-white rounded-lg hover:bg-pink-600">
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div id="add-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-pink-200 rounded-lg p-6 max-w-2xl mx-4 w-full">
        <div class="bg-pink-200 -mx-6 -mt-6 px-6 py-4 rounded-t-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-800">TAMBAH CUSTOMERS</h3>
        </div>
        
        <form id="add-customer-form" class="space-y-4" action="{{ route('admin.customers.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NAMA</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">EMAIL</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">TELEPON</label>
                <input type="tel" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">PASSWORD</label>
                <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin :</label>
                <div class="flex space-x-6">
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="male" class="text-pink-500">
                        <span class="ml-2 text-sm text-gray-700">Laki-Laki</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="female" class="text-pink-500">
                        <span class="ml-2 text-sm text-gray-700">Wanita</span>
                    </label>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ALAMAT</label>
                <textarea name="address" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required></textarea>
            </div>
            
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeAddModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    BATAL
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
                    SIMPAN
                </button>
            </div>
        </form>
    </div>
</div>

@include('layouts.footer-admin')

@push('scripts')
<script>
    let customerToDelete = null;

    function openDeleteModal(customerId) {
        customerToDelete = customerId;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        customerToDelete = null;
        document.getElementById('delete-modal').classList.add('hidden');
    }

    function confirmDelete() {
        if (customerToDelete) {
            // Kirim request DELETE ke server Laravel
            fetch(`/admin/customers/${customerToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload(); // Refresh halaman setelah sukses hapus
                } else {
                    alert('Gagal menghapus customer');
                }
            });
        }
    }

    function openAddModal() {
        document.getElementById('add-modal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('add-modal').classList.add('hidden');
        document.getElementById('add-customer-form').reset();
    }

    function filterCustomers(filter) {
        const rows = document.querySelectorAll('#customers-table-body tr');

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (filter === 'all' || status === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Ganti tampilan tab aktif
        document.querySelectorAll('[id^="tab-"]').forEach(tab => {
            tab.classList.remove('bg-pink-200', 'text-pink-800');
            tab.classList.add('text-gray-600', 'hover:text-gray-800');
        });

        document.getElementById(`tab-${filter}`).classList.remove('text-gray-600', 'hover:text-gray-800');
        document.getElementById(`tab-${filter}`).classList.add('bg-pink-200', 'text-pink-800');
    }

    // Tutup modal jika klik luar modal
    document.addEventListener('click', function(e) {
        if (e.target.id === 'delete-modal') closeDeleteModal();
        if (e.target.id === 'add-modal') closeAddModal();
    });
</script>
@endpush
@endsection