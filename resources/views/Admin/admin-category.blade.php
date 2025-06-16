@extends('layouts.admin')

@section('content')
<div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
    <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden">

        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 p-8">
            {{-- Header dan Pencarian --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-3xl font-bold text-gray-800">Kategori Produk</h1>

                <div class="flex items-center w-full md:w-1/2 gap-3">
                    <button onclick="openAddModal()"
                        class="bg-pink-500 hover:bg-pink-600 text-white text-sm px-4 py-2 rounded-full shadow transition duration-300">
                        + Tambah Kategori
                    </button>

                    <div class="relative w-full">
                        <input type="text" id="search" placeholder="Cari nama kategori..."
                            class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm">
                        <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Grid Card --}}
            <div id="kategoriContainer" class="grid grid-cols-1 gap-6 overflow-y-auto" style="max-height: calc(100vh - 250px);">
                @forelse ($kategoris as $kategori)
                    <div class="bg-[#FFF1EA] rounded-lg shadow-lg p-6 flex items-center space-x-6">
                        @if ($kategori->img)
                            <img src="{{ asset('images/kategori/' . $kategori->img) }}"
                                 alt="{{ $kategori->nama_kategori }}"
                                 class="w-28 h-28 object-cover rounded-lg">
                        @else
                            <div class="w-28 h-28 bg-gray-200 flex items-center justify-center text-gray-400 rounded-lg">
                                Tidak ada gambar
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $kategori->nama_kategori }}</h3>
                        </div>

                        <div class="flex flex-col space-y-2 items-end">
                            <button onclick="openEditModal({{ $kategori->id_kategori }}, '{{ $kategori->nama_kategori }}')"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold px-4 py-2 rounded-lg text-sm">
                                Edit
                            </button>
                            <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-300 hover:bg-red-400 text-red-800 font-bold px-4 py-2 rounded-lg text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        Belum ada kategori yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambahKategori" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
        <button onclick="closeAddModal()" class="absolute top-4 right-4 text-gray-500 text-2xl hover:text-gray-700">&times;</button>
        <h2 class="text-xl font-bold mb-4">Tambah Kategori</h2>
        <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Nama Kategori</label>
                <input type="text" name="nama_kategori" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Gambar Kategori</label>
                <input type="file" name="img" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="text-right">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEditKategori" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
        <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 text-2xl hover:text-gray-700">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Kategori</h2>
        <form id="formEditKategori" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="edit_nama_kategori" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Gambar Baru (opsional)</label>
                <input type="file" name="img" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="text-right">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#d33'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#d33'
        });
    });
</script>
@endif

<script>
    function openAddModal() {
        document.getElementById('modalTambahKategori').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('modalTambahKategori').classList.add('hidden');
    }

    function openEditModal(id, nama_kategori) {
        const form = document.getElementById('formEditKategori');
        form.action = `/admin/kategori/${id}`;
        document.getElementById('edit_nama_kategori').value = nama_kategori;
        document.getElementById('modalEditKategori').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('modalEditKategori').classList.add('hidden');
    }

    // SweetAlert konfirmasi hapus
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data kategori akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Filter pencarian kategori
    document.getElementById('search').addEventListener('keyup', function () {
        let keyword = this.value.toLowerCase();
        let cards = document.querySelectorAll('#kategoriContainer > div');
        cards.forEach(card => {
            let text = card.innerText.toLowerCase();
            card.style.display = text.includes(keyword) ? 'flex' : 'none';
        });
    });
</script>
@endpush
