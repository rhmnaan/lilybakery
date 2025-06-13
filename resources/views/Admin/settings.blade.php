@extends('layouts.admin')

@section('content')
    <div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
        <div class="flex bg-[#FFFEFB] rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.08)] overflow-hidden">

            {{-- Left Sidebar --}}
            @include('Admin.layouts.sidebar')

            {{-- Main Content --}}
            <div class="flex-1 p-10 overflow-y-auto" style="max-height: calc(100vh - 1rem);">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-[#F5DAD2]">
                    <h1 class="text-2xl font-semibold text-[#5A3E36] mb-6">Setting</h1>

                    {{-- Akun Admin yang Sedang Login --}}
                    @if($mainAdmin)
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-lg font-semibold text-[#5A3E36] mb-4">Akun Saya</h2>
                        <div class="space-y-4">
                             <div class="flex items-center">
                                <label class="w-1/3 text-gray-700">Nama Pengguna</label>
                                <div class="w-2/3 text-gray-800">{{ $mainAdmin->nama_admin }}</div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700">Email</label>
                                <div class="w-2/3">
                                    <div class="bg-gray-100 px-4 py-2 rounded-md border text-gray-500 w-full">
                                        {{ $mainAdmin->email }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <label class="w-1/3 text-gray-700">Ubah Password</label>
                                <button onclick="openEditPasswordModal('{{ $mainAdmin->id_admin }}', '{{ $mainAdmin->nama_admin }}', '{{ $mainAdmin->email }}')"
                                    class="bg-[#F5DAD2] hover:bg-[#f1cfc7] text-[#5A3E36] font-medium px-6 py-2 rounded-lg shadow-sm transition">
                                    Ubah
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Hak Akses Admin Lainnya --}}
                    <h2 class="text-lg font-semibold text-[#5A3E36] mb-4">Manajemen Admin</h2>
                    <div class="bg-[#FFFAF9] rounded-xl border border-[#F5DAD2] shadow-sm p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-medium text-[#5A3E36]">Daftar Admin Lain</span>
                            <button onclick="openAddAdminModal()"
                                class="bg-[#F5DAD2] hover:bg-[#f1cfc7] text-[#5A3E36] font-medium px-4 py-2 rounded-lg flex items-center transition">
                                <i class="fas fa-plus mr-2"></i> Tambah Admin Baru
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto text-sm text-gray-700">
                                <thead class="bg-[#FFEDEA] text-[#5A3E36]">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-semibold">Nama Pengguna</th>
                                        <th class="px-6 py-3 text-left font-semibold">Email</th>
                                        <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-table-body" class="bg-white divide-y divide-gray-100">
                                    {{-- Data admin lain akan dirender di sini oleh JavaScript --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- MODALS --}}

    {{-- Modal Tambah Admin --}}
    <div id="add-admin-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-lg relative max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold text-[#5A3E36] mb-6">Tambah Admin</h2>
            <form id="add-admin-form">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Nama Pengguna</label>
                        <input type="text" name="name" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                    </div>
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                    </div>
                    <div class="relative">
                        <label class="block text-[#5A3E36] font-semibold mb-1">Password</label>
                        <input type="password" id="add-admin-password" name="password" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" placeholder="Minimal 8 karakter" required>
                        <button type="button" onclick="togglePasswordVisibility('add-admin-password')" class="absolute right-3 top-1/2 mt-3 text-gray-500 hover:text-gray-700">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Telepon</label>
                        <input type="tel" name="telp" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                    </div>
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Alamat</label>
                        <textarea name="alamat" rows="3" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-5 mt-6">
                    <button type="button" onclick="closeAddAdminModal()" class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-[#E59CAA] text-white font-semibold rounded-lg hover:bg-[#d48a98] transition">Buat</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Admin --}}
    <div id="edit-admin-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-lg relative max-h-[90vh] overflow-y-auto">
             <h2 class="text-2xl font-bold text-[#5A3E36] mb-6">Edit Admin</h2>
            <form id="edit-admin-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_admin_id" name="id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Nama Pengguna</label>
                        <input type="text" id="edit_admin_name" name="name" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                    </div>
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Email</label>
                        <input type="email" id="edit_admin_email" name="email" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                    </div>
                    <div class="relative">
                        <label class="block text-[#5A3E36] font-semibold mb-1">Password Baru (Opsional)</label>
                        <input id="edit-admin-password" type="password" name="password" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" placeholder="Kosongkan jika tidak diubah">
                         <button type="button" onclick="togglePasswordVisibility('edit-admin-password')" class="absolute right-3 top-1/2 mt-3 text-gray-500 hover:text-gray-700">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Telepon</label>
                        <input type="tel" id="edit_admin_telp" name="telp" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                    </div>
                     <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Jenis Kelamin</label>
                        <select id="edit_admin_jenis_kelamin" name="jenis_kelamin" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[#5A3E36] font-semibold mb-1">Alamat</label>
                        <textarea id="edit_admin_alamat" name="alamat" rows="3" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" required></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-5 mt-6">
                    <button type="button" onclick="closeEditAdminModal()" class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-[#E59CAA] text-white font-semibold rounded-lg hover:bg-[#d48a98] transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Modal Edit Password Admin --}}
    <div id="edit-main-password-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
         <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-lg relative">
            <h2 class="text-2xl font-bold text-[#5A3E36] mb-6">Ubah Password Saya</h2>
            <form id="edit-main-password-form">
                 @csrf
                @method('PUT')
                <input type="hidden" id="main_admin_id">
                 <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Nama Pengguna</label>
                    <input type="text" id="main_admin_name" class="w-full px-4 py-2 rounded-md border border-gray-200 bg-gray-100 cursor-not-allowed" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Email</label>
                    <input type="email" id="main_admin_email" class="w-full px-4 py-2 rounded-md border border-gray-200 bg-gray-100 cursor-not-allowed" readonly>
                </div>
                <div class="relative mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Password Baru</label>
                    <input id="main_password_input" type="password" name="password" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" placeholder="Minimal 8 karakter" required>
                     <button type="button" onclick="togglePasswordVisibility('main_password_input')" class="absolute right-3 top-1/2 mt-3 text-gray-500 hover:text-gray-700">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                 <div class="relative mb-6">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Konfirmasi Password Baru</label>
                    <input id="main_password_confirmation" type="password" name="password_confirmation" class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]" placeholder="Ketik ulang password baru" required>
                     <button type="button" onclick="togglePasswordVisibility('main_password_confirmation')" class="absolute right-3 top-1/2 mt-3 text-gray-500 hover:text-gray-700">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <div class="flex justify-end space-x-5 mt-4">
                    <button type="button" onclick="closeEditPasswordModal()" class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-[#E59CAA] text-white font-semibold rounded-lg hover:bg-[#d48a98] transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-admin-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
       <div class="bg-white rounded-2xl w-full max-w-sm p-8 shadow-lg relative">
            <h2 class="text-2xl font-bold text-[#5A3E36] mb-6 text-center">Konfirmasi Hapus</h2>
            <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus admin ini?</p>
            <div class="flex justify-center space-x-5 mt-4">
                <button type="button" onclick="closeDeleteAdminModal()" class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">Batal</button>
                {{-- [FIX] Menggunakan ID yang benar untuk di-target oleh JavaScript --}}
                <button type="button" id="confirm-delete-btn" class="px-6 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">Hapus</button>
            </div>
        </div>
    </div>
@endsection

{{-- JavaScript Section --}}
@push('scripts')
<script>
    // Kode JavaScript di sini sama persis dengan jawaban sebelumnya yang sudah diperbaiki.
    // Yang terpenting adalah perubahan pada HTML Modal Hapus di atas.
    
    // Global variable untuk menyimpan data admin
    let otherAdmins = @json($otherAdmins);
    let adminToDeleteId = null;

    // --- HELPER FUNCTIONS ---
    function getCsrfToken() { return document.querySelector('meta[name="csrf-token"]').getAttribute('content'); }
    function showAlert(title, text, icon) { Swal.fire({ title: title, text: text, icon: icon, confirmButtonColor: '#E59CAA' }); }

    // --- PASSWORD VISIBILITY ---
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

    // --- RENDER TABLE ---
    function renderOtherAdmins() {
        const tbody = document.getElementById('admin-table-body');
        tbody.innerHTML = '';
        otherAdmins.forEach(admin => {
            const row = `<tr id="admin-row-${admin.id_admin}"><td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">${admin.nama_admin}</div></td><td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-900">${admin.email}</div></td><td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium"><div class="flex space-x-4 text-lg"><button onclick="openEditAdminModal(${admin.id_admin})" class="text-gray-500 hover:text-gray-700" title="Edit"><i class="fas fa-pen"></i></button><button onclick="openDeleteAdminModal(${admin.id_admin})" class="text-red-500 hover:text-red-700" title="Hapus"><i class="fas fa-trash-alt"></i></button></div></td></tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
        });
    }

    // --- MODAL CONTROLS ---
    function openAddAdminModal() { document.getElementById('add-admin-modal').classList.remove('hidden'); document.getElementById('add-admin-modal').classList.add('flex'); }
    function closeAddAdminModal() { document.getElementById('add-admin-modal').classList.add('hidden'); document.getElementById('add-admin-form').reset(); }
    async function openEditAdminModal(id) {
        try {
            const response = await fetch(`/admin/settings/admins/${id}/edit`);
            if (!response.ok) throw new Error('Gagal mengambil data admin.');
            const admin = await response.json();
            document.getElementById('edit_admin_id').value = admin.id_admin;
            document.getElementById('edit_admin_name').value = admin.nama_admin;
            document.getElementById('edit_admin_email').value = admin.email;
            document.getElementById('edit_admin_telp').value = admin.telp;
            document.getElementById('edit_admin_alamat').value = admin.alamat;
            document.getElementById('edit_admin_jenis_kelamin').value = admin.jenis_kelamin;
            document.getElementById('edit-admin-password').value = '';
            document.getElementById('edit-admin-modal').classList.remove('hidden');
            document.getElementById('edit-admin-modal').classList.add('flex');
        } catch (error) {
            showAlert('Error', error.message, 'error');
        }
    }
    function closeEditAdminModal() { document.getElementById('edit-admin-modal').classList.add('hidden'); document.getElementById('edit-admin-form').reset(); }
    function openDeleteAdminModal(id) { adminToDeleteId = id; document.getElementById('delete-admin-modal').classList.remove('hidden'); document.getElementById('delete-admin-modal').classList.add('flex'); }
    function closeDeleteAdminModal() { adminToDeleteId = null; document.getElementById('delete-admin-modal').classList.add('hidden'); }
    function openEditPasswordModal(id, name, email) {
        document.getElementById('main_admin_id').value = id;
        document.getElementById('main_admin_name').value = name;
        document.getElementById('main_admin_email').value = email;
        document.getElementById('edit-main-password-modal').classList.remove('hidden');
        document.getElementById('edit-main-password-modal').classList.add('flex');
    }
    function closeEditPasswordModal() { document.getElementById('edit-main-password-modal').classList.add('hidden'); document.getElementById('edit-main-password-form').reset(); }

    // --- FORM SUBMISSIONS (AJAX) ---
    document.addEventListener('DOMContentLoaded', function() {
        renderOtherAdmins();

        document.getElementById('add-admin-form').addEventListener('submit', async function(e) { e.preventDefault(); /* ... logika tambah ... */ });
        document.getElementById('edit-admin-form').addEventListener('submit', async function(e) { e.preventDefault(); /* ... logika edit ... */ });
        document.getElementById('edit-main-password-form').addEventListener('submit', async function(e) { e.preventDefault(); /* ... logika ubah password ... */ });

        // [FIX] Penangan event untuk tombol hapus
        document.getElementById('confirm-delete-btn').addEventListener('click', async function() {
            if (!adminToDeleteId) return;
             try {
                const response = await fetch(`/admin/settings/admins/${adminToDeleteId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                });
                const result = await response.json();
                if (!response.ok) throw result;

                otherAdmins = otherAdmins.filter(a => a.id_admin != adminToDeleteId);
                renderOtherAdmins();
                closeDeleteAdminModal();
                showAlert('Sukses', 'Admin berhasil dihapus.', 'success');
            } catch (error) {
                showAlert('Gagal Menghapus', error.message, 'error');
            }
        });
        
        // --- Sisipkan kembali logika AJAX yang sudah ada dari respons sebelumnya ---
        // (Saya singkat di sini agar tidak terlalu panjang, tapi pastikan logika fetch untuk add, edit, dan update password tetap ada di dalam DOMContentLoaded)
        document.getElementById('add-admin-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            try {
                const response = await fetch("{{ route('admin.settings.storeAdmin') }}", { method: 'POST', headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' }, body: formData });
                const result = await response.json();
                if (!response.ok) throw result;
                otherAdmins.push(result.admin);
                renderOtherAdmins();
                closeAddAdminModal();
                showAlert('Sukses', 'Admin baru berhasil ditambahkan.', 'success');
            } catch (error) {
                const messages = Object.values(error.message).flat().join('\n');
                showAlert('Gagal Menambahkan', messages, 'error');
            }
        });

        document.getElementById('edit-admin-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const adminId = document.getElementById('edit_admin_id').value;
            const formData = new FormData(this);
            try {
                const response = await fetch(`/admin/settings/admins/${adminId}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' }, body: formData });
                const result = await response.json();
                if (!response.ok) throw result;
                const index = otherAdmins.findIndex(a => a.id_admin == adminId);
                if (index > -1) otherAdmins[index] = result.admin;
                renderOtherAdmins();
                closeEditAdminModal();
                showAlert('Sukses', 'Data admin berhasil diperbarui.', 'success');
            } catch(error) {
                 const messages = Object.values(error.message).flat().join('\n');
                showAlert('Gagal Memperbarui', messages, 'error');
            }
        });

        document.getElementById('edit-main-password-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const adminId = document.getElementById('main_admin_id').value;
            const formData = new FormData(this);
            try {
                const response = await fetch(`/admin/settings/main-admin-password/${adminId}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' }, body: formData });
                const result = await response.json();
                if(!response.ok) throw result;
                closeEditPasswordModal();
                showAlert('Sukses', 'Password Anda berhasil diubah.', 'success');
            } catch(error) {
                const messages = Object.values(error.message).flat().join('\n');
                showAlert('Gagal Mengubah Password', messages, 'error');
            }
        });

        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(event) {
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
                    if (result.isConfirmed) this.submit();
                });
            });
        }
    });
</script>
@endpush