@extends('layouts.admin')

@section('content')
<div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
    <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden" style="max-height: calc(100vh - 4rem);">
        {{-- Sidebar --}}
        <div class="w-64 bg-[#FFF7F3] pt-4">
            <div class="p-4">
                <div class="flex flex-col items-center justify-center bg-[#E59CAA] rounded-lg py-4 px-2 mb-6 shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Lily Bakery" class="max-w-full h-auto">
                </div>
            </div>
            <nav class="mt-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]"><i class="far fa-check-circle mr-3 text-xl"></i><span>Dashboard</span></a>
                <a href="{{ route('admin.product') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]"><i class="far fa-edit mr-3 text-xl"></i><span>Product</span></a>
                <a href="{{ route('admin.orders') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]"><i class="fas fa-shopping-bag mr-3 text-xl"></i><span>Orders</span></a>
                <a href="{{ route('admin.customers') }}" class="flex items-center px-6 py-3 rounded-md font-semibold text-gray-900 bg-[#F9D8D9]"><i class="far fa-user mr-3 text-xl"></i><span>Customers</span></a>
                <a href="{{ route('admin.settings') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]"><i class="fas fa-cog mr-3 text-xl"></i><span>Setting</span></a>
                <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" class="block w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 rounded-md text-gray-700 hover:bg-red-100 hover:text-red-700"><i class="fas fa-sign-out-alt mr-3 text-xl"></i><span>Logout</span></button>
                </form>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 p-8 flex flex-col overflow-hidden">
            <div class="flex justify-between items-center mb-8 flex-shrink-0">
                <h1 class="text-3xl font-bold text-gray-800">Customers</h1>
                <button onclick="openAddModal()" class="bg-[#E59CAA] hover:bg-[#d48a98] text-white px-4 py-2 rounded-lg flex items-center shadow-md transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Customer
                </button>
            </div>

            <div class="bg-white rounded-xl shadow p-4 overflow-hidden flex-grow">
                <div class="overflow-y-auto h-full">
                    {{-- Tabel dengan border yang disesuaikan seperti halaman Orders --}}
                    <table class="w-full table-auto text-left border-2 border-gray-300">
                        <thead class="bg-gray-50 border-b-2 border-gray-300">
                            <tr class="text-black">
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">No. Telepon</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $customer->nama_pelanggan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $customer->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $customer->telp }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="openDeleteModal('{{ $customer->id_pelanggan }}')" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-10 text-gray-500">Belum ada data pelanggan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-6 text-sm text-gray-700 font-medium flex-shrink-0">
                Total Pelanggan: <span class="text-gray-900 font-semibold text-lg">{{ $totalCount }}</span> Akun
            </div>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 shadow-xl">
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Konfirmasi Hapus</h2>
        <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus pelanggan ini?</p>
        <form id="deleteCustomerForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-[#CC3D5E] text-white rounded-lg hover:bg-[#A8314E]">Hapus</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="add-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-lg mx-4 w-full shadow-xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Tambah Customer Baru</h3>
        <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="tel" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="add_customer_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA] pr-10" required>
                    <button type="button" onclick="togglePasswordVisibility('add_customer_password')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <div class="flex space-x-6 pt-1">
                    <label class="flex items-center"><input type="radio" name="gender" value="Laki-laki" class="text-[#E59CAA] focus:ring-[#E59CAA]" required><span class="ml-2 text-sm text-gray-700">Laki-Laki</span></label>
                    <label class="flex items-center"><input type="radio" name="gender" value="Perempuan" class="text-[#E59CAA] focus:ring-[#E59CAA]"><span class="ml-2 text-sm text-gray-700">Perempuan</span></label>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required></textarea>
            </div>
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeAddModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">Batal</button>
                <button type="submit" class="px-6 py-2 bg-[#E59CAA] text-white rounded-lg hover:bg-[#d48a98] font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(customerId) {
        const form = document.getElementById('deleteCustomerForm');
        form.action = `/admin/customers/${customerId}`;
        document.getElementById('delete-modal').classList.remove('hidden');
    }
    function closeDeleteModal() { document.getElementById('delete-modal').classList.add('hidden'); }
    function openAddModal() { document.getElementById('add-modal').classList.remove('hidden'); }
    function closeAddModal() { document.getElementById('add-modal').classList.add('hidden'); }

    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    const logoutForm = document.getElementById('logout-form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?', text: "Anda akan keluar dari sesi admin ini!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#e879a0',
                cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Logout!'
            }).then((result) => {
                if (result.isConfirmed) { this.submit(); }
            });
        });
    }
</script>
@endpush
@endsection