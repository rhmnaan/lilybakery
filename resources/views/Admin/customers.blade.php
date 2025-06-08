@extends('layouts.admin')

@section('content')
<div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
    <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden">
        <div class="w-64 bg-[#FFF7F3] pt-4">
            <div class="p-4">
                <div class="flex flex-col items-center justify-center bg-[#E59CAA] rounded-lg py-4 px-2 mb-6 shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Lily Bakery" class="max-w-full h-auto">
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
                <a href="{{ route('admin.orders') }}" class="flex items-center px-6 py-3 rounded-md  text-gray-700 hover:bg-[#FFEAEA]">
                    {{-- ICON DIKEMBALIKAN SESUAI GAMBAR: Orders = User (Profil) --}}
                    <i class="fas fa-shopping-bag mr-3 text-xl"></i> {{-- Changed icon to shopping-bag as it fits orders better --}}
                    <span>Orders</span>
                </a>

                {{-- Customers --}}
                <a href="{{ route('admin.customers') }}" class="flex items-center px-6 py-3 rounded-md font-semibold text-gray-900 bg-[#F9D8D9] ">
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

        <div class="flex-1 p-8">
            <div class="bg-[#FFF7F3] border border-[#F9D8D9] shadow-md w-full h-full rounded-xl px-10 py-10">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Customers</h1>
                    <button onclick="openAddModal()" class="bg-[#E59CAA] hover:bg-[#CC3D5E] text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Customers
                    </button>
                </div>

            <div class="mb-6">
                <div class="flex space-x-1 bg-[#FFF7F3] rounded-lg p-1 shadow-sm w-fit border border-gray-200">
                    <button onclick="filterCustomers('all')" id="tab-all" class="px-6 py-2 rounded-md text-sm font-medium transition-colors bg-[#F9D8D9] text-gray-900 font-semibold">
                        Semua
                    </button>
                    <button onclick="filterCustomers('active')" id="tab-active" class="px-6 py-2 rounded-md text-sm font-medium transition-colors text-gray-700 hover:bg-[#FFEAEA]">
                        Aktif
                    </button>
                    <button onclick="filterCustomers('inactive')" id="tab-inactive" class="px-6 py-2 rounded-md text-sm font-medium transition-colors text-gray-700 hover:bg-[#FFEAEA]">
                        Nonaktif
                    </button>
                </div>
            </div>

            <div class="bg-[#FFF7F3] rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto px-6 py-4">
                    <table class="min-w-full bg-[#FFF7F3] border-2 border-gray-300">
                        <thead class="h-12 border-2 border-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider">
                                    Nama Pelanggan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider">
                                    No. Telepon
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="customers-table-body" class="text-gray-700">
                            @foreach($customers as $customer)
                                <tr class="border-b border-gray-200 hover:bg-gray-50" data-status="{{ $customer->status }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $customer->nama_pelanggan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ $customer->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ $customer->telp }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColor = ($customer->status == 'active') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600';
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }} capitalize">{{ $customer->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="openDeleteModal('{{ $customer->id_pelanggan }}')" class="text-[#CC3D5E] hover:text-[#A8314E]">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 space-y-2 text-sm text-gray-700 font-medium">
                <div>Jumlah Customers Aktif: <span id="active-count" class="text-[#E59CAA] font-semibold text-lg">{{ $activeCount }}</span> Akun</div>
                <div>Jumlah Customers Nonaktif: <span id="inactive-count" class="text-[#CC3D5E] font-semibold text-lg">{{ $inactiveCount }}</span> Akun</div>
                <div>Jumlah Customers: <span id="total-count" class="text-gray-900 font-semibold text-lg">{{ $totalCount }}</span> Akun</div>
            </div>
            </div>
        </div>
    </div>
</div>


<div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-[#FFF7F3] rounded-lg p-6 max-w-sm mx-4 shadow-xl">
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Konfirmasi Hapus</h2>
        <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus pelanggan ini?</p>
        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Batal
            </button>
            <button onclick="confirmDelete()" class="flex-1 px-4 py-2 bg-[#CC3D5E] text-white rounded-lg hover:bg-[#A8314E]">
                Hapus
            </button>
        </div>
    </div>
</div>

<div id="add-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-[#FFF7F3] rounded-lg p-6 max-w-2xl mx-4 w-full shadow-xl">
        <div class="bg-[#E59CAA] -mx-6 -mt-6 px-6 py-4 rounded-t-lg mb-6">
            <h3 class="text-lg font-semibold text-white">TAMBAH CUSTOMERS</h3>
        </div>

        <form id="add-customer-form" class="space-y-4" action="{{ route('admin.customers.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NAMA</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">EMAIL</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">TELEPON</label>
                <input type="tel" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">PASSWORD</label>
                <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin :</label>
                <div class="flex space-x-6">
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="male" class="text-[#E59CAA] focus:ring-[#E59CAA]">
                        <span class="ml-2 text-sm text-gray-700">Laki-Laki</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="female" class="text-[#E59CAA] focus:ring-[#E59CAA]">
                        <span class="ml-2 text-sm text-gray-700">Wanita</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ALAMAT</label>
                <textarea name="address" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required></textarea>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeAddModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    BATAL
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-[#E59CAA] text-white rounded-lg hover:bg-[#CC3D5E]">
                    SIMPAN
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        const activeCountElem = document.getElementById('active-count');
        const inactiveCountElem = document.getElementById('inactive-count');
        const totalCountElem = document.getElementById('total-count');

        let activeFilteredCount = 0;
        let inactiveFilteredCount = 0;
        let totalFilteredCount = 0;

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (filter === 'all' || status === filter) {
                row.style.display = '';
                totalFilteredCount++;
                if (status === 'active') {
                    activeFilteredCount++;
                } else if (status === 'inactive') {
                    inactiveFilteredCount++;
                }
            } else {
                row.style.display = 'none';
            }
        });

        // Update counts based on filtered results
        activeCountElem.textContent = activeFilteredCount;
        inactiveCountElem.textContent = inactiveFilteredCount;
        totalCountElem.textContent = totalFilteredCount;


        // Ganti tampilan tab aktif
        document.querySelectorAll('[id^="tab-"]').forEach(tab => {
            tab.classList.remove('bg-[#F9D8D9]', 'text-gray-900', 'font-semibold');
            tab.classList.add('text-gray-700', 'hover:bg-[#FFEAEA]');
        });

        document.getElementById(`tab-${filter}`).classList.remove('text-gray-700', 'hover:bg-[#FFEAEA]');
        document.getElementById(`tab-${filter}`).classList.add('bg-[#F9D8D9]', 'text-gray-900', 'font-semibold');
    }

    // Initialize filter to 'all' on page load
    document.addEventListener('DOMContentLoaded', () => {
        filterCustomers('all');
    });

    // Tutup modal jika klik luar modal
    document.addEventListener('click', function(e) {
        if (e.target.id === 'delete-modal') closeDeleteModal();
        if (e.target.id === 'add-modal') closeAddModal();
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