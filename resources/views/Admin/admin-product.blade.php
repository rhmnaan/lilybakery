@extends('layouts.admin')

@section('content')
<div class="bg-[#FFF1EA] min-h-screen font-sans p-8">
    <div class="flex bg-[#FFFEFB] rounded-lg shadow-[0_35px_35px_rgba(0,0,0,0.25)] overflow-hidden" style="max-height: calc(100vh - 4rem);">

        {{-- Left Sidebar --}}
        @include('Admin.layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 p-8 flex flex-col overflow-hidden">
            <div class="flex justify-between items-center mb-8 flex-shrink-0">
                <h1 class="text-3xl font-bold text-gray-800">PRODUK TERSEDIA</h1>

                <div class="flex items-center space-x-4">
                    @if (request('filter_promotion') === 'true')
                        <!-- Tombol Tambah Promosi -->
                        <button onclick="openAddPromoModal()" class="bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-2 px-5 rounded-lg flex items-center shadow-md">
                            <i class="fas fa-tags mr-2 text-pink-600"></i> Tambah Promosi
                        </button>
                    @endif


                    <!-- Tombol Tambah Produk -->
                    <button id="btnOpenAddModal" class="bg-[#FFF1EA] hover:bg-[#E59CAA] font-semibold py-2 px-5 rounded-lg flex items-center shadow-md text-gray-800">
                        <i class="fas fa-plus mr-2 text-[#D6929F]"></i> Tambah Produk
                    </button>
                </div>
            </div>



            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex-shrink-0" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex-shrink-0" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex-shrink-0" role="alert">
                    <strong class="font-bold">Oops! Ada kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Filter/Sort --}}
            <div class="flex items-center space-x-2 mb-8 flex-shrink-0">
                @php
                    $filterBaseClasses = "px-4 py-2 rounded-lg font-semibold shadow-sm border border-gray-200 text-sm";
                    $activeFilterClasses = "bg-[#F9D8D9] text-pink-800";
                    $inactiveFilterClasses = "bg-[#FFFEFB] hover:bg-[#FFF1EA] text-gray-700";
                    // Fungsi untuk membuat URL filter dengan mempertahankan parameter lain
                    function getFilterUrl($newParams) {
                        return route('admin.product', array_merge(request()->except(array_keys($newParams)+['page']), $newParams));
                    }
                @endphp
                <a href="{{ getFilterUrl(['filter_status' => 'active']) }}"
                   class="{{ $filterBaseClasses }} {{ $activeFilters['status'] == 'active' ? $activeFilterClasses : $inactiveFilterClasses }}">
                    ACTIVE
                </a>
                <a href="{{ getFilterUrl(['filter_status' => 'nonactive']) }}"
                   class="{{ $filterBaseClasses }} {{ $activeFilters['status'] == 'nonactive' ? $activeFilterClasses : $inactiveFilterClasses }}">
                    NONACTIVE
                </a>

                {{-- Dropdown Kategori (menggantikan tombol SEMUA) --}}
                <div class="relative">
                    <select id="filter_kategori_dropdown"
                        class="appearance-none {{ $filterBaseClasses }} {{ $activeFilters['kategori'] != 'semua' ? 'bg-[#F9D8D9] text-pink-800' : 'bg-white text-black' }} pr-8">
                        <option value="{{ getFilterUrl(['filter_kategori' => 'semua']) }}" @if($activeFilters['kategori'] == 'semua') selected @endif>Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ getFilterUrl(['filter_kategori' => $kategori->id_kategori]) }}" @if($activeFilters['kategori'] == $kategori->id_kategori) selected @endif>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 7l3-3 3 3m0 6l-3 3-3-3" /></svg>
                    </div>
                </div>

                <a href="{{ getFilterUrl(['filter_promotion' => 'true']) }}"
                   class="{{ $filterBaseClasses }} {{ $activeFilters['promotion'] == 'true' ? $activeFilterClasses : $inactiveFilterClasses }}">
                    PROMOTION
                </a>
                   <a href="{{ route('admin.product') }}" class="{{ $filterBaseClasses }} {{ $inactiveFilterClasses }} ml-auto"> Reset Filter
                </a>
                <div class="flex-1"></div>
                {{-- Sort Dropdown --}}
                <div class="relative">
                       <select id="sort_by_dropdown"
                           class="appearance-none bg-white text-black font-semibold border border-gray-200 rounded-full py-2 pl-4 pr-8 shadow-sm hover:bg-[#FFF1EA] focus:outline-none text-sm">
                           <option value="{{ getFilterUrl(request()->except(['sort_by', 'sort_dir'])) }}">Sort By</option>
                           <option value="{{ getFilterUrl(['sort_by' => 'nama_produk', 'sort_dir' => 'asc']) }}" @if(request('sort_by') == 'nama_produk' && request('sort_dir') == 'asc') selected @endif>Nama (A-Z)</option>
                           <option value="{{ getFilterUrl(['sort_by' => 'nama_produk', 'sort_dir' => 'desc']) }}" @if(request('sort_by') == 'nama_produk' && request('sort_dir') == 'desc') selected @endif>Nama (Z-A)</option>
                           <option value="{{ getFilterUrl(['sort_by' => 'harga', 'sort_dir' => 'asc']) }}" @if(request('sort_by') == 'harga' && request('sort_dir') == 'asc') selected @endif>Harga (Murah)</option>
                           <option value="{{ getFilterUrl(['sort_by' => 'harga', 'sort_dir' => 'desc']) }}" @if(request('sort_by') == 'harga' && request('sort_dir') == 'desc') selected @endif>Harga (Mahal)</option>
                           <option value="{{ getFilterUrl(['sort_by' => 'stok', 'sort_dir' => 'asc']) }}" @if(request('sort_by') == 'stok' && request('sort_dir') == 'asc') selected @endif>Stok (Sedikit)</option>
                           <option value="{{ getFilterUrl(['sort_by' => 'stok', 'sort_dir' => 'desc']) }}" @if(request('sort_by') == 'stok' && request('sort_dir') == 'desc') selected @endif>Stok (Banyak)</option>
                            <option value="{{ getFilterUrl(['sort_by' => 'status', 'sort_dir' => 'asc']) }}" @if(request('sort_by') == 'status' && request('sort_dir') == 'asc') selected @endif>Status (Non-Aktif dulu)</option>
                           <option value="{{ getFilterUrl(['sort_by' => 'status', 'sort_dir' => 'desc']) }}" @if(request('sort_by') == 'status' && request('sort_dir') == 'desc') selected @endif>Status (Aktif dulu)</option>
                       </select>
                       <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                           <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 7l3-3 3 3m0 6l-3 3-3-3" /></svg>
                       </div>
                </div>
            </div>

            {{-- Product List --}}
            <div class="grid grid-cols-1 gap-6 overflow-y-auto flex-grow pr-2">
                @forelse($produks as $produk)
                    <div class="bg-[#FFF1EA] rounded-lg shadow-lg p-6 flex items-start space-x-6">
                        <img src="{{ $produk->gambar ? asset($imagePath . $produk->gambar) : asset('images/placeholder.png') }}" alt="{{ $produk->nama_produk }}"
                            class="w-36 h-36 md:w-48 md:h-48 object-cover rounded-lg flex-shrink-0">
                        <div class="flex-1">
                            <span class="text-xs px-2 py-1 rounded-full font-semibold {{ $produk->status ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $produk->status ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                            @if($produk->promo)
                                <span class="ml-2 text-xs px-2 py-1 rounded-full font-semibold bg-yellow-200 text-yellow-800">
                                    Promosi
                                </span>
                            @endif
                            <p class="text-gray-500 text-sm mt-1">Nama Produk:</p>
                            <h3 class="text-xl md:text-2xl font-semibold text-gray-800 mb-1">{{ $produk->nama_produk }}</h3>
                            <p class="text-gray-500 text-sm">Harga:</p>
                            <p class="text-lg md:text-xl font-bold text-gray-800 mb-1">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-sm">Stock:</p>
                            <p class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ $produk->stok }}</p>
                            <p class="text-gray-500 text-sm">Kategori:</p>
                            <p class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">Deskripsi:</p>
                            <p class="text-gray-700 text-sm md:text-base">{{ Str::limit($produk->deskripsi ?: '-', 100) }}</p>

                            {{-- Detail Promosi jika filter aktif --}}
                            @if ($filterPromotion === 'true' && $produk->promo)
                                <div class="mt-4 p-4 bg-gradient-to-br from-yellow-100 via-yellow-50 to-yellow-100 border border-yellow-300 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.96a1 1 0 00.95.69h4.176c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.96c.3.921-.755 1.688-1.54 1.118l-3.38-2.455a1 1 0 00-1.175 0l-3.38 2.455c-.784.57-1.838-.197-1.539-1.118l1.287-3.96a1 1 0 00-.364-1.118L2.049 9.387c-.783-.57-.38-1.81.588-1.81h4.176a1 1 0 00.951-.69l1.285-3.96z"/>
                                            </svg>
                                            <span class="text-sm font-bold text-yellow-800">
                                                Diskon {{ $produk->promo->diskon_persen }}%
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($produk->promo->tanggal_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($produk->promo->tanggal_berakhir)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-snug italic">
                                        {{ $produk->promo->deskripsi_promo }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col space-y-2 items-end flex-shrink-0">
                            <form action="{{ route('admin.product.destroy', $produk->kode_produk) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-200 hover:bg-red-300 text-gray-700 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-center text-sm">
                                    Hapus
                                </button>
                            </form>

                            <button data-id="{{ $produk->kode_produk }}" data-url="{{ route('admin.product.edit', $produk->kode_produk) }}"
                                class="btn-open-edit-modal bg-[#FFFEFB] hover:bg-[#E59CAA] text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-center text-sm">
                                EDIT
                            </button>

                            @php
                                $today = \Carbon\Carbon::today();
                            @endphp

                            {{-- Tombol Edit Promo --}}
                            @if ($produk->promo && $produk->promo->tanggal_mulai <= $today && $produk->promo->tanggal_berakhir >= $today)
                                <button
                                    onclick="openEditPromoModal('{{ $produk->kode_produk }}')"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-center text-sm">
                                    Edit Promo
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500 text-xl">Belum ada produk yang sesuai dengan filter.</p>
                </div>
                @endforelse
            </div>
            <!-- Modal Edit Promo -->
            <div id="editPromoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-[#FFEAE5] p-6 rounded-2xl w-full max-w-md shadow-xl relative mx-4"> {{-- Sesuaikan lebar dan padding --}}
                    <h2 class="text-2xl font-bold mb-4 text-[#3D1F1F]">Edit Promosi Produk</h2>
                    
                    <!-- Kontainer yang bisa di-scroll untuk form -->
                    <div class="overflow-y-auto max-h-[calc(100vh-16rem)] pr-2">
                        <form id="editPromoForm" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="edit_promo_diskon_persen" class="block text-sm font-semibold mb-1 text-gray-700">Diskon (%)</label>
                                <input type="number" name="diskon_persen" id="edit_promo_diskon_persen" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_promo_deskripsi_promo" class="block text-sm font-semibold mb-1 text-gray-700">Deskripsi Promosi</label>
                                <textarea name="deskripsi_promo" id="edit_promo_deskripsi_promo" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_promo_tanggal_mulai" class="block text-sm font-semibold mb-1 text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="edit_promo_tanggal_mulai" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                            </div>

                            <div class="mb-4">
                                <label for="edit_promo_tanggal_berakhir" class="block text-sm font-semibold mb-1 text-gray-700">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_berakhir" id="edit_promo_tanggal_berakhir" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                            </div>
                        </form>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeEditPromoModal()" class="bg-gray-200 border border-gray-300 px-6 py-2 rounded-lg text-gray-700 hover:bg-gray-300 font-semibold">Batal</button>
                        <button type="submit" form="editPromoForm" class="bg-[#C68686] text-white px-6 py-2 rounded-lg hover:bg-[#a86e6e] font-semibold">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
            {{-- Pagination --}}
            <div class="mt-6 flex-shrink-0">
                {{ $produks->links() }}
            </div>
        </div>
    </div>


    {{-- Modal Tambah Produk --}}
    <div id="addModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-[#FFEAE5] p-8 rounded-2xl w-full max-w-md shadow-xl relative mx-4">
            <h2 class="text-2xl font-bold mb-6 text-[#3D1F1F]">Tambah Produk</h2>
            <form id="addProductForm" action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="add_product"> {{-- Untuk re-open modal jika ada error --}}
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Nama Produk</label><div class="table-responsive"></div>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Nama Produk" required>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Harga</label>
                        <input type="number" name="harga" value="{{ old('harga') }}" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Harga" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Stock</label>
                        <input type="number" name="stok" value="{{ old('stok') }}" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Stock" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Kategori</label>
                    <select name="id_kategori" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Gambar Produk</label>
                    <input type="file" name="gambar" class="w-full p-2 rounded-md border border-gray-300 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#FFF1EA] file:text-[#E59CAA] hover:file:bg-[#E59CAA] hover:file:text-white" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Status Produk</label>
                    <select name="status" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif (Tampil di User)</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Non-Aktif (Sembunyikan dari User)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Deskripsi Produk">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" data-modal-id="addModal" class="btn-close-modal bg-gray-200 border border-gray-300 px-6 py-2 rounded-lg text-gray-700 hover:bg-gray-300 font-semibold">Batal</button>
                    <button type="submit" class="bg-[#C68686] text-white px-6 py-2 rounded-lg hover:bg-[#a86e6e] font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Produk --}}
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-[#FFEAE5] p-6 rounded-2xl w-full max-w-md shadow-xl relative mx-4">
            <h2 class="text-2xl font-bold mb-4 text-[#3D1F1F]">Edit Produk</h2>

            <!-- Kontainer yang bisa di-scroll untuk form -->
            <div class="overflow-y-auto max-h-[calc(100vh-16rem)] pr-2"> {{-- pr-2 untuk sedikit padding agar scrollbar tidak menempel --}}
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Nama Produk</label>
                        <input type="text" name="nama_produk" id="edit_nama_produk" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Nama Produk" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <label class="block text-sm font-semibold mb-1 text-gray-700">Harga</label>
                            <input type="number" name="harga" id="edit_harga" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Harga" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1 text-gray-700">Stock</label>
                            <input type="number" name="stok" id="edit_stok" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Stock" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Kategori</label>
                        <select name="id_kategori" id="edit_id_kategori" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Gambar Produk (Kosongkan jika tidak ingin diubah)</label>
                        <input type="file" name="gambar" id="edit_gambar_input" class="w-full p-2 rounded-md border border-gray-300 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#FFF1EA] file:text-[#E59CAA] hover:file:bg-[#E59CAA] hover:file:text-white">
                        <img id="edit_current_image" src="" alt="Current Image" class="mt-2 max-h-24 rounded hidden"/>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Status Produk</label>
                        <select name="status" id="edit_status" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]">
                            <option value="1">Aktif (Tampil di User)</option>
                            <option value="0">Non-Aktif (Sembunyikan dari User)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" rows="3" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" placeholder="Deskripsi Produk"></textarea>
                    </div>
                </form>
            </div>

            <div class="flex justify-end space-x-3 mt-6"> {{-- mt-6 untuk jarak dari konten form yang bisa di-scroll --}}
                <button type="button" data-modal-id="editModal" class="btn-close-modal bg-gray-200 border border-gray-300 px-6 py-2 rounded-lg text-gray-700 hover:bg-gray-300 font-semibold">Batal</button>
                <button type="submit" form="editProductForm" class="bg-[#C68686] text-white px-6 py-2 rounded-lg hover:bg-[#a86e6e] font-semibold">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Promosi -->
    <div id="addPromoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-[#FFEAE5] p-6 rounded-2xl w-full max-w-md shadow-xl relative mx-4"> {{-- Sesuaikan lebar dan padding --}}
            <h2 class="text-2xl font-bold mb-4 text-[#3D1F1F]">Tambah Promosi Baru</h2>

            <!-- Kontainer yang bisa di-scroll untuk form Tambah Promosi -->
            <div class="overflow-y-auto max-h-[calc(100vh-16rem)] pr-2">
                <form id="addPromoForm" action="{{ route('admin.promo.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="search_produk_add_promo" class="block text-sm font-semibold mb-1 text-gray-700">Cari Produk</label>
                        <input type="text" id="search_produk_add_promo" onkeyup="filterProduk('add')" placeholder="Ketik nama produk..." class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]">
                    </div>

                    <div class="mb-3">
                        <label for="produk_select_add_promo" class="block text-sm font-semibold mb-1 text-gray-700">Pilih Produk</label>
                        <select name="id_produk" id="produk_select_add_promo" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->kode_produk }}">{{ $produk->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="add_promo_diskon_persen" class="block text-sm font-semibold mb-1 text-gray-700">Diskon (%)</label>
                        <input type="number" name="diskon_persen" id="add_promo_diskon_persen" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                    </div>

                    <div class="mb-3">
                        <label for="add_promo_deskripsi_promo" class="block text-sm font-semibold mb-1 text-gray-700">Deskripsi Promosi</label>
                        <textarea name="deskripsi_promo" id="add_promo_deskripsi_promo" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" rows="3"></textarea>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1 text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="add_promo_tanggal_mulai" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1 text-gray-700">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_berakhir" id="add_promo_tanggal_berakhir" class="w-full p-3 rounded-md border border-gray-300 bg-white focus:border-[#E59CAA] focus:ring-[#E59CAA]" required>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeAddPromoModal()" class="bg-gray-200 border border-gray-300 px-6 py-2 rounded-lg text-gray-700 hover:bg-gray-300 font-semibold">Batal</button>
                <button type="submit" form="addPromoForm" class="bg-[#C68686] text-white px-6 py-2 rounded-lg hover:bg-[#a86e6e] font-semibold">Simpan</button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi untuk membuka modal Edit Promo
    function openEditPromoModal(produkKode) {
        const modal = document.getElementById('editPromoModal');
        modal.classList.remove('hidden');

        // Fetch data promo berdasarkan kode_produk
        fetch(`/admin/product/promo/kode/${produkKode}/edit`) // Sesuaikan route di backend
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.promo) {
                    document.getElementById('edit_promo_diskon_persen').value = data.promo.diskon_persen || '';
                    document.getElementById('edit_promo_deskripsi_promo').value = data.promo.deskripsi_promo || '';
                    document.getElementById('edit_promo_tanggal_mulai').value = data.promo.tanggal_mulai || '';
                    document.getElementById('edit_promo_tanggal_berakhir').value = data.promo.tanggal_berakhir || '';
                    document.getElementById('editPromoForm').action = `/admin/product/promo/${produkKode}/update`;
                } else {
                    Swal.fire('Error', 'Data promo tidak ditemukan untuk produk ini.', 'error');
                    closeEditPromoModal();
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Gagal memuat data promo: ' + error.message, 'error');
                console.error('Gagal memuat data promo:', error);
                closeEditPromoModal();
            });
    }

    // Fungsi untuk menutup modal Edit Promo
    function closeEditPromoModal() {
        const modal = document.getElementById('editPromoModal');
        modal.classList.add('hidden');
        document.getElementById('editPromoForm').reset();
    }

    // Fungsi untuk membuka modal Tambah Promosi
    function openAddPromoModal() {
        document.getElementById('addPromoModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal Tambah Promosi
    function closeAddPromoModal() {
        document.getElementById('addPromoModal').classList.add('hidden');
        document.getElementById('addPromoForm').reset();
    }

    // Fungsi untuk filter produk di modal Tambah Promosi
    function filterProduk(modalType) {
        let input, select, options;
        if (modalType === 'add') {
            input = document.getElementById('search_produk_add_promo').value.toLowerCase();
            select = document.getElementById('produk_select_add_promo');
        }
        options = select.options;

        for (let i = 0; i < options.length; i++) {
            const optionText = options[i].text.toLowerCase();
            options[i].style.display = optionText.includes(input) ? '' : 'none';
        }
    }

    // ✅ Tambahkan handler untuk submit form Edit Promo pakai AJAX
    document.getElementById('editPromoForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const url = form.action;
        const formData = new FormData(form);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Gagal memperbarui promosi.');
                });
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: data.message || 'Promosi berhasil diperbarui!',
                timer: 2000,
                showConfirmButton: false
            });

            closeEditPromoModal();

            // ⏳ Optional: Refresh halaman atau tabel data jika perlu
            setTimeout(() => {
                location.reload(); // Reload halaman agar perubahan promo terlihat
            }, 2000);
        })
        .catch(error => {
            Swal.fire('Error', error.message, 'error');
        });
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const addModalElement = document.getElementById('addModal');
    const editModalElement = document.getElementById('editModal');
    const editProductForm = document.getElementById('editProductForm');
    const imagePathBase = "{{ asset($imagePath) }}"; // imagePath dari controller (public/images/products/)

    function openModal(modalElement) {
        if (modalElement) modalElement.classList.remove('hidden');
    }

    function closeModal(modalElement) {
        if (modalElement) {
            modalElement.classList.add('hidden');
            if (modalElement.id === 'editModal' && editProductForm) {
                editProductForm.reset();
                document.getElementById('edit_gambar_input').value = ''; // Reset file input
                const currentImageElement = document.getElementById('edit_current_image');
                if (currentImageElement) {
                    currentImageElement.classList.add('hidden');
                    currentImageElement.src = '';
                }
            }
            if (modalElement.id === 'addModal' && document.getElementById('addProductForm')) {
                 document.getElementById('addProductForm').reset(); // Reset form saat ditutup
            }
        }
    }

    document.getElementById('btnOpenAddModal')?.addEventListener('click', () => openModal(addModalElement));

    document.querySelectorAll('.btn-open-edit-modal').forEach(button => {
        button.addEventListener('click', async function () {
            const productId = this.dataset.id;
            const url = this.dataset.url;
            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const product = await response.json();

                if (editProductForm) {
                    editProductForm.action = `/admin/product/${productId}`;
                    document.getElementById('edit_nama_produk').value = product.nama_produk || '';
                    document.getElementById('edit_harga').value = product.harga || '';
                    document.getElementById('edit_stok').value = product.stok || '';
                    document.getElementById('edit_id_kategori').value = product.id_kategori || '';
                    document.getElementById('edit_deskripsi').value = product.deskripsi || '';
                    document.getElementById('edit_status').value = product.status ? '1' : '0'; // Perubahan di sini

                    const currentImageElement = document.getElementById('edit_current_image');
                    document.getElementById('edit_gambar_input').value = ''; // Reset file input
                    if (product.gambar) {
                        currentImageElement.src = `${imagePathBase}/${product.gambar}`;
                        currentImageElement.classList.remove('hidden');
                    } else {
                        currentImageElement.classList.add('hidden');
                        currentImageElement.src = '';
                    }
                }
                openModal(editModalElement);
            } catch (error) {
                console.error('Could not fetch product data:', error);
                alert('Gagal memuat data produk.');
            }
        });
    });

    document.querySelectorAll('.btn-close-modal').forEach(button => {
        button.addEventListener('click', function () {
            closeModal(document.getElementById(this.dataset.modalId));
        });
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            if (addModalElement && !addModalElement.classList.contains('hidden')) closeModal(addModalElement);
            if (editModalElement && !editModalElement.classList.contains('hidden')) closeModal(editModalElement);
            // Tambahkan ini untuk menutup modal edit promo juga
            const editPromoModalElement = document.getElementById('editPromoModal');
            if (editPromoModalElement && !editPromoModalElement.classList.contains('hidden')) closeEditPromoModal();
            // Tambahkan ini untuk menutup modal tambah promo juga
            const addPromoModalElement = document.getElementById('addPromoModal');
            if (addPromoModalElement && !addPromoModalElement.classList.contains('hidden')) closeAddPromoModal();
        }
    });

    // Handle dropdown navigasi
    document.getElementById('filter_kategori_dropdown')?.addEventListener('change', function() {
        if (this.value) window.location.href = this.value;
    });
    document.getElementById('sort_by_dropdown')?.addEventListener('change', function() {
        if (this.value) window.location.href = this.value;
    });

    // Re-open add modal if validation errors
    @if ($errors->any() && old('form_type') === 'add_product')
        openModal(addModalElement);
    @endif
});

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
</script>
@endpush
