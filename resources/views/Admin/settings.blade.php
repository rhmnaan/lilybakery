@extends('layouts.admin')

@section('content')
    <div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
        <div class="flex bg-[#FFFEFB] rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.08)] overflow-hidden">

            {{-- Sidebar --}}
            <div class="w-64 bg-[#FFF7F3] pt-4">
                <div class="p-4">
                    <div class="flex flex-col items-center bg-[#E59CAA] rounded-lg py-4 px-2 mb-6 shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Lily Bakery" class="max-w-full h-auto">
                    </div>
                </div>
                <nav class="mt-2 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        <i class="far fa-check-circle mr-3 text-xl"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.product') }}"
                        class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        <i class="far fa-edit mr-3 text-xl"></i>
                        <span>Product</span>
                    </a>
                    <a href="{{ route('admin.orders') }}"
                        class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        <i class="far fa-user mr-3 text-xl"></i>
                        <span>Orders</span>
                    </a>
                    <a href="{{ route('admin.customers') }}"
                        class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        <i class="far fa-user mr-3 text-xl"></i>
                        <span>Customers</span>
                    </a>
                    <a href="{{ route('admin.setting') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]
                                @if(Request::routeIs('admin.setting')) bg-[#F9D8D9] text-gray-900 font-semibold @endif">
                        <i class="fas fa-cog mr-3 text-xl"></i>
                        <span>Setting</span>
                    </a>
                </nav>
            </div>

            {{-- Main Content --}}
            <div class="flex-1 p-10">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-[#F5DAD2]">
                    <h1 class="text-2xl font-semibold text-[#5A3E36] mb-6">Setting</h1>

                    {{-- Akun --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-lg font-semibold text-[#5A3E36] mb-4">Akun</h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700">Nama Pengguna</label>
                                <div class="w-2/3 text-gray-800">admin_lily</div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700">Email</label>
                                <div class="w-2/3">
                                    <div
                                        class="bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm text-gray-800 w-full">
                                        admin@lilybakery.com
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <label class="w-1/3 text-gray-700">Ubah Password</label>
                                <button onclick="openEditPasswordModal('admin_lily', 'admin@lilybakery.com')"
                                    class="bg-[#F5DAD2] hover:bg-[#f1cfc7] text-[#5A3E36] font-medium px-6 py-2 rounded-lg shadow-sm transition">
                                    Ubah
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Hak Akses Admin --}}
                    <h2 class="text-lg font-semibold text-[#5A3E36] mb-4">Hak Akses Admin</h2>
                    <div class="bg-[#FFFAF9] rounded-xl border border-[#F5DAD2] shadow-sm p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-medium text-[#5A3E36]">Daftar Admin</span>
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
                                    {{-- Admin rows will be rendered here by JavaScript --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Admin Baru --}}
    <div id="add-admin-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-lg relative">
            <h2 class="text-2xl font-bold text-[#5A3E36] mb-6">Tambah Admin</h2>
            <form id="add-admin-form">
                @csrf
                <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Nama Pengguna</label>
                    <input type="text" name="name"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]"
                        required>
                </div>
                <div class="relative mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Password</label>
                    <input type="password" id="add-admin-password" name="password"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]"
                        placeholder="••••••••" required>
                    <button type="button" onclick="togglePasswordVisibility('add-admin-password')"
                        class="absolute right-3 top-1/2 transform translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <div class="flex justify-end space-x-5 mt-4">
                    <button type="button" onclick="closeAddAdminModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-[#E59CAA] text-white font-semibold rounded-lg hover:bg-[#d48a98] transition">
                        Buat
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Admin --}}
    <div id="edit-admin-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-lg relative">
            <h2 class="text-2xl font-bold text-[#5A3E36] mb-6">Edit Admin</h2>
            <form id="edit-admin-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_admin_id" name="id">
                <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Nama Pengguna</label>
                    <input type="text" id="edit_admin_name" name="name"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Email</label>
                    <input type="email" id="edit_admin_email" name="email"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]"
                        required>
                </div>

                <div class="relative">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Password</label>
                    <input id="edit-admin-password" type="password" name="password"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]"
                        placeholder="Biarkan kosong jika tidak ingin mengubah">
                    <button type="button" onclick="togglePasswordVisibility('edit-admin-password')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="far fa-eye"></i>
                    </button>
                </div>

                <div class="flex justify-end space-x-5 mt-4">
                    <button type="button" onclick="closeEditAdminModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-[#E59CAA] text-white font-semibold rounded-lg hover:bg-[#d48a98] transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Password Admin Utama --}}
    <div id="edit-main-password-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-lg relative">
            <h2 class="text-2xl font-bold text-[#5A3E36] mb-6">Edit Password</h2>
            <form id="edit-main-password-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="main_admin_id" name="id" value="1">
                <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Nama Pengguna</label>
                    <input type="text" id="main_admin_name"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA] cursor-not-allowed"
                        readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Email</label>
                    <input type="email" id="main_admin_email"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA] cursor-not-allowed"
                        readonly>
                </div>
                <div class="relative">
                    <label class="block text-[#5A3E36] font-semibold mb-1">Password Baru</label>
                    <input id="main-password-input" type="password" name="password"
                        class="w-full px-4 py-2 rounded-md border border-[#F5DAD2] bg-[#FFF7F3] focus:outline-none focus:ring-2 focus:ring-[#E59CAA]"
                        placeholder="••••••••" required>
                    <button type="button" onclick="togglePasswordVisibility('main-password-input')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <div class="flex justify-end space-x-5 mt-4">
                    <button type="button" onclick="closeEditPasswordModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-[#E59CAA] text-white font-semibold rounded-lg hover:bg-[#d48a98] transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- Modal Konfirmasi Hapus Admin --}}
    <div id="delete-admin-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl w-full max-w-sm p-8 shadow-lg relative">
            <h2 class="text-2xl font-bold text-[#5A3E36] mb-6 text-center">Konfirmasi Hapus</h2>
            <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus admin ini?</p>
            <div class="flex justify-center space-x-5 mt-4">
                <button type="button" onclick="closeDeleteAdminModal()"
                    class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100">
                    Batal
                </button>
                <button type="button" onclick="confirmDeleteAdmin()"
                    class="px-6 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            // Data dummy for other admins.
            // In a real application, this data should be fetched from the backend (database).
            let otherAdmins = [{
                id: 2,
                name: 'Dani Subianto',
                email: 'Dani_KNN@gmail.com'
            }, ];

            let adminToDeleteId = null; // Variable to store the ID of the admin to be deleted
            let adminToEditId = null; // Variable to store the ID of the admin to be edited

            // Load other admin data when the page loads
            document.addEventListener('DOMContentLoaded', function() {
                renderOtherAdmins();
            });

            // Function to render the list of other admins to the table
            function renderOtherAdmins() {
                const tbody = document.getElementById('admin-table-body');
                tbody.innerHTML = ''; // Clear the table before re-rendering

                otherAdmins.forEach(admin => {
                    const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${admin.name}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${admin.email}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                            <div class="flex space-x-4 text-lg">
                                <button onclick="openEditAdminModal(${admin.id})" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button onclick="openDeleteAdminModal(${admin.id})" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            }

            // Function to toggle password visibility (hide/show)
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


            // --- Add Admin Modal Logic ---
            function openAddAdminModal() {
                document.getElementById('add-admin-modal').classList.remove('hidden');
                document.getElementById('add-admin-modal').classList.add('flex'); // Ensure it's flex for centering
            }

            function closeAddAdminModal() {
                document.getElementById('add-admin-modal').classList.add('hidden');
                document.getElementById('add-admin-modal').classList.remove('flex');
                document.getElementById('add-admin-form').reset(); // Clear the form
            }

            document.getElementById('add-admin-form').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                const formData = new FormData(this);
                const newAdmin = {
                    // Dummy ID. In the backend, the ID will be generated by the database.
                    id: otherAdmins.length > 0 ? Math.max(...otherAdmins.map(a => a.id)) + 1 : 1,
                    name: formData.get('name'),
                    email: formData.get('email'),
                    password: formData.get('password') // Password is for dummy, do not save on frontend
                };

                // --- IMPORTANT: THIS PART MUST BE REPLACED WITH FETCH/AJAX TO LARAVEL BACKEND ---
                // Example fetch code (currently commented out):
                /*
                fetch('/admin/settings/admins', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json' // If sending JSON
                    },
                    body: JSON.stringify({
                        name: newAdmin.name,
                        email: newAdmin.email,
                        password: newAdmin.password // Send password to backend for hashing
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add admin from backend response
                        otherAdmins.push({ id: data.admin.id, name: data.admin.name, email: data.admin.email });
                        renderOtherAdmins();
                        closeAddAdminModal();
                        alert('Admin baru berhasil ditambahkan!');
                    } else {
                        alert('Gagal menambahkan admin: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error adding admin:', error);
                    alert('Terjadi kesalahan saat menambahkan admin.');
                });
                */

                // Dummy update for frontend demonstration without backend
                otherAdmins.push({
                    id: newAdmin.id,
                    name: newAdmin.name,
                    email: newAdmin.email
                });
                renderOtherAdmins();
                closeAddAdminModal();
                alert('Admin baru berhasil ditambahkan (Dummy)!');
            });

            // --- Edit Admin Modal Logic ---
            function openEditAdminModal(id) {
                const admin = otherAdmins.find(a => a.id === id);
                if (admin) {
                    adminToEditId = id;
                    document.getElementById('edit_admin_id').value = admin.id;
                    document.getElementById('edit_admin_name').value = admin.name;
                    document.getElementById('edit_admin_email').value = admin.email;
                    document.getElementById('edit-admin-password').value = ''; // Clear password when opening
                    document.getElementById('edit-admin-modal').classList.remove('hidden');
                    document.getElementById('edit-admin-modal').classList.add('flex'); // Ensure it's flex for centering
                }
            }

            function closeEditAdminModal() {
                adminToEditId = null;
                document.getElementById('edit-admin-modal').classList.add('hidden');
                document.getElementById('edit-admin-modal').classList.remove('flex');
                document.getElementById('edit-admin-form').reset();
            }

            document.getElementById('edit-admin-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const adminId = formData.get('id');
                const updatedName = formData.get('name');
                const updatedEmail = formData.get('email');
                const updatedPassword = formData.get('password'); // This will be empty if not changed

                // --- IMPORTANT: THIS PART MUST BE REPLACED WITH FETCH/AJAX TO LARAVEL BACKEND ---
                // Example fetch code (currently commented out):
                /*
                fetch(/admin/settings/admins/${adminId}, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: updatedName,
                        email: updatedEmail,
                        password: updatedPassword // Send only if not empty
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const index = otherAdmins.findIndex(a => a.id == adminId);
                        if (index !== -1) {
                            otherAdmins[index].name = updatedName;
                            otherAdmins[index].email = updatedEmail;
                            // Do not update password in frontend dummy data
                            renderOtherAdmins();
                            closeEditAdminModal();
                            alert('Admin berhasil diperbarui!');
                        }
                    } else {
                        alert('Gagal memperbarui admin: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error updating admin:', error);
                    alert('Terjadi kesalahan saat memperbarui admin.');
                });
                */

                // Dummy update for frontend demonstration without backend
                const index = otherAdmins.findIndex(a => a.id == adminId);
                if (index !== -1) {
                    otherAdmins[index].name = updatedName;
                    otherAdmins[index].email = updatedEmail;
                    // For the dummy, we don't handle password changes here
                    renderOtherAdmins();
                    closeEditAdminModal();
                    alert('Admin berhasil diperbarui (Dummy)!');
                }
            });


            // --- Delete Admin Modal Logic ---
            function openDeleteAdminModal(id) {
                adminToDeleteId = id;
                document.getElementById('delete-admin-modal').classList.remove('hidden');
                document.getElementById('delete-admin-modal').classList.add('flex'); // Ensure it's flex for centering
            }

            function closeDeleteAdminModal() {
                adminToDeleteId = null;
                document.getElementById('delete-admin-modal').classList.add('hidden');
                document.getElementById('delete-admin-modal').classList.remove('flex');
            }

            function confirmDeleteAdmin() {
                if (adminToDeleteId !== null) {
                    // --- IMPORTANT: THIS PART MUST BE REPLACED WITH FETCH/AJAX TO LARAVEL BACKEND ---
                    // Example fetch code (currently commented out):
                    /*
                    fetch(/admin/settings/admins/${adminToDeleteId}, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            otherAdmins = otherAdmins.filter(admin => admin.id !== adminToDeleteId);
                            renderOtherAdmins();
                            closeDeleteAdminModal();
                            alert('Admin berhasil dihapus!');
                        } else {
                            alert('Gagal menghapus admin: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting admin:', error);
                        alert('Terjadi kesalahan saat menghapus admin.');
                    });
                    */

                    // Dummy delete for frontend demonstration without backend
                    otherAdmins = otherAdmins.filter(admin => admin.id !== adminToDeleteId);
                    renderOtherAdmins();
                    closeDeleteAdminModal();
                    alert('Admin berhasil dihapus (Dummy)!');
                }
            }


            // --- Edit Main Admin Password Modal Logic ---
            function openEditPasswordModal(username, email) {
                document.getElementById('main_admin_name').value = username;
                document.getElementById('main_admin_email').value = email;
                document.getElementById('main-password-input').value = ''; // Clear password field
                document.getElementById('edit-main-password-modal').classList.remove('hidden');
                document.getElementById('edit-main-password-modal').classList.add('flex'); // Ensure it's flex for centering
            }

            function closeEditPasswordModal() {
                document.getElementById('edit-main-password-modal').classList.add('hidden');
                document.getElementById('edit-main-password-modal').classList.remove('flex');
                document.getElementById('edit-main-password-form').reset();
            }

            document.getElementById('edit-main-password-form').addEventListener('submit', function(e) {
                e.preventDefault();
                // Instead of directly submitting, open a confirmation modal
                document.getElementById('confirm-password-change-modal').classList.remove('hidden');
                document.getElementById('confirm-password-change-modal').classList.add('flex');
            });

            function closeConfirmPasswordChangeModal() {
                document.getElementById('confirm-password-change-modal').classList.add('hidden');
                document.getElementById('confirm-password-change-modal').classList.remove('flex');
            }

            function submitMainAdminPasswordChange() {
                const formData = new FormData(document.getElementById('edit-main-password-form'));
                const adminId = formData.get('id');
                const newPassword = formData.get('password');

                // Close the confirmation modal first
                closeConfirmPasswordChangeModal();

                // --- IMPORTANT: THIS PART MUST BE REPLACED WITH FETCH/AJAX TO LARAVEL BACKEND ---
                // Example fetch code (currently commented out):
                /*
                fetch(/admin/settings/main-admin-password/${adminId}, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        password: newPassword
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeEditPasswordModal();
                        alert('Password admin utama berhasil diubah!');
                    } else {
                        alert('Gagal mengubah password: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error changing main admin password:', error);
                    alert('Terjadi kesalahan saat mengubah password.');
                });
                */

                // Dummy success for frontend demonstration
                closeEditPasswordModal();
                alert('Password admin utama berhasil diubah (Dummy)!');
            }
        </script>
    @endpush
@endsection