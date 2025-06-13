@extends('layouts.admin')

@section('content')
    <div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
        <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden">
            {{-- Sidebar --}}
            @include('Admin.layouts.sidebar')

            {{-- Main Content --}}
            <div class="flex-1 p-8 overflow-y-auto">
                {{-- Judul dan Pencarian --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <h1 class="text-3xl font-bold text-gray-800">Lokasi Toko</h1>

                    <div class="flex items-center w-full md:w-1/2 gap-3">
                        {{-- Tombol Tambah Toko --}}
                        <button onclick="toggleModal()"
                            class="flex-shrink-0 bg-pink-500 hover:bg-pink-600 text-white text-sm px-4 py-2 rounded-full shadow transition duration-300">
                            + Tambah Toko
                        </button>



                        {{-- Input Pencarian --}}
                        <div class="relative w-full">
                            <input type="text" id="search" placeholder="Cari nama toko..."
                                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm">
                            <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"></path>
                            </svg>
                        </div>
                    </div>
                </div>


                {{-- Grid Card --}}
                <div id="storeContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @include('admin.partials.store-cards', ['storeLocations' => $storeLocations])
                </div>
            </div>
        </div>
    </div>
@endsection


<!-- Modal Tambah Toko -->
<div id="modalTambahToko" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 relative">
        <!-- Tombol close -->
        <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

        <h2 class="text-xl font-bold mb-4">Tambah Toko Baru</h2>
        <form action="{{ route('admin.store.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium">Nama Toko</label>
                    <input type="text" name="nama_toko" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Nomor Telepon</label>
                    <input type="text" name="telp" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium">Alamat</label>
                    <textarea name="alamat" rows="2" required class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium">Link Google Maps</label>
                    <input type="text" name="link_location" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Latitude</label>
                    <input type="text" name="latitude" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Longitude</label>
                    <input type="text" name="longitude" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium">Foto Toko</label>
                    <input type="file" name="img" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Toko -->
<div id="modalEditToko" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 relative">
        <!-- Tombol close -->
        <button onclick="tutupEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

        <h2 class="text-xl font-bold mb-4">Edit Toko</h2>
        <form id="formEditToko" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="hidden" name="id_store" id="edit_id_store">
                <div>
                    <label class="block mb-1 text-sm font-medium">Nama Toko</label>
                    <input type="text" name="nama_toko" id="edit_nama_toko" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Nomor Telepon</label>
                    <input type="text" name="telp" id="edit_telp" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium">Alamat</label>
                    <textarea name="alamat" id="edit_alamat" rows="2" required class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium">Link Google Maps</label>
                    <input type="text" name="link_location" id="edit_link_location" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Latitude</label>
                    <input type="text" name="latitude" id="edit_latitude" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Longitude</label>
                    <input type="text" name="longitude" id="edit_longitude" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium">Foto Toko</label>
                    <input type="file" name="img" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>



<script>
    function toggleModal() {
        const modal = document.getElementById('modalTambahToko');
        modal.classList.toggle('hidden');
    }
</script>



@push('scripts')
<script>
    document.getElementById('search').addEventListener('keyup', function () {
        let query = this.value;

        fetch(`{{ route('admin.store.search') }}?search=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('storeContainer').innerHTML = html;
            });
    });
</script>
<script>
    // Toggle modal open/close
    const modalToggle = document.querySelector('[data-modal-toggle]');
    const modal = document.getElementById('modalTambahToko');

    if (modalToggle) {
        modalToggle.addEventListener('click', () => {
            modal.classList.toggle('hidden');
        });
    }

    function tutupModal() {
        modal.classList.add('hidden');
    }
</script>

@endpush

<script>
    function openEditModal(id, nama_toko, alamat, telp, link_location, latitude, longitude) {
        // Set action URL
        document.getElementById('formEditToko').action = `/admin/store/${id}`;

        // Isi data form
        document.getElementById('edit_nama_toko').value = nama_toko;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_telp').value = telp;
        document.getElementById('edit_link_location').value = link_location;
        document.getElementById('edit_latitude').value = latitude;
        document.getElementById('edit_longitude').value = longitude;

        // Tampilkan modal
        document.getElementById('modalEditToko').classList.remove('hidden');
    }

    function tutupEditModal() {
        document.getElementById('modalEditToko').classList.add('hidden');
    }
</script>





