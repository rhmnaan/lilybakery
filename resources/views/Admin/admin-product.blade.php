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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]
                                @if(Request::routeIs('admin.dashboard')) bg-[#F9D8D9] text-gray-900 font-semibold @endif">
                        <i class="far fa-check-circle mr-3 text-xl"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.product') }}"
                        class="flex items-center px-6 py-3 rounded-md bg-[#F9D8D9] text-gray-900 font-semibold">
                        <i class="far fa-edit mr-3 text-xl"></i>
                        <span>Product</span>
                    </a>
                    <a href="{{ route('admin.orders') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        <i class="far fa-user mr-3 text-xl"></i>
                        <span>Orders</span>
                    </a>
                    <a href="{{ route('admin.customers') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        <i class="far fa-user mr-3 text-xl"></i>
                        <span>Customers</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
                        <i class="fas fa-cog mr-3 text-xl"></i>
                        <span>Setting</span>
                    </a>
                </nav>
            </div>

            {{-- Main Content --}}
            <div class="flex-1 p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">PRODUK TERSEDIA</h1>
                    <button id="btnAddProduct"
                        class="bg-[#FFF1EA] hover:bg-[#E59CAA] font-semibold py-2 px-5 rounded-lg flex items-center shadow-md">
                        <i class="fas fa-plus mr-2"></i> Tambah Produk
                    </button>

                </div>

                {{-- Filter/Sort --}}
                <div class="flex items-center space-x-4 mb-8">
                    <button
                        class="px-5 py-2 rounded-lg bg-[#F9D8D9] hover:bg-[#E59CAA] text-pink-800 font-semibold shadow-sm border border-gray-200">
                        ACTIVE
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-[#FFFEFB] hover:bg-[#FFF1EA] text-gray-700 font-semibold shadow-sm border border-gray-200">
                        NONACTIVE
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-[#FFFEFB] hover:bg-[#FFF1EA] text-gray-700 font-semibold shadow-sm border border-gray-200">
                        SEMUA
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-[#FFFEFB] hover:bg-[#FFF1EA] text-gray-700 font-semibold shadow-sm border border-gray-200">
                        PROMOTION
                    </button>
                    <div class="flex-1"></div>
                    <div class="relative">
                        <select
                            class="appearance-none bg-white text-black font-semibold border border-gray-200 rounded-full py-2 pl-4 pr-8 shadow-sm hover:bg-[#FFF1EA] focus:outline-none">
                            <option>Sort</option>
                            <option>Nama</option>
                            <option>Harga</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Product List (Scrollable only this part) --}}
                <div class="grid grid-cols-1 gap-6 overflow-y-auto max-h-[600px] pr-2">
                    @for($i = 0; $i < 10; $i++) {{-- Contoh banyak produk --}}
                        <div class="bg-[#FFF1EA] rounded-lg shadow-lg p-6 flex items-start space-x-6">
                            <img src="{{ asset('images/strawberrycake.png') }}" alt="Strawberry Cake"
                                class="w-48 h-48 object-cover rounded-lg flex-shrink-0">
                            <div class="flex-1">
                                <p class="text-gray-500 text-sm">Nama Produk :</p>
                                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Cake</h3>
                                <p class="text-gray-500 text-sm">Harga :</p>
                                <p class="text-xl font-bold text-gray-800 mb-2">Rp30.000,00</p>
                                <p class="text-gray-500 text-sm">Stock :</p>
                                <p class="text-xl font-bold text-gray-800 mb-2">70</p>
                                <p class="text-gray-500 text-sm">Category :</p>
                                <p class="text-xl font-bold text-gray-800 mb-2">Cake</p>
                                <p class="text-gray-500 text-sm">Description :</p>
                                <p class="text-gray-700 text-base">Lembut, manis, dan kaya rasa strawberry di setiap gigitan.
                                </p>
                            </div>
                            <div class="flex flex-col space-y-2 items-end">
                                <button
                                    class="bg-red-200 hover:bg-[#E59CAA] text-gray-700 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-center">
                                    Hapus
                                </button>
                                <button
                                    class="bg-[#FFFEFB] hover:bg-[#E59CAA] text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-center">
                                    Active
                                </button>
                                <button
                                    class="btn-edit bg-[#FFFEFB] hover:bg-[#E59CAA] text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-center">
                                    EDIT
                                </button>

                            </div>
                        </div>
                    @endfor

                    {{-- Modal Edit Produk --}}
                    <div id="editModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
                        <div class="bg-[#FFEAE5] p-8 rounded-2xl w-[400px] shadow-xl relative">
                            <h2 class="text-2xl font-bold mb-6 text-[#3D1F1F]">Edit Produk</h2>
                            <form>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Nama Produk</label>
                                    <input type="text" class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Nama Produk">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Harga</label>
                                    <input type="number" class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Harga">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Stock</label>
                                    <input type="number" class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Stock">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Category</label>
                                    <select class="w-full p-3 rounded-md border border-gray-200 bg-white">
                                        <option>Cake</option>
                                        <option>Bread</option>
                                        <option>Cookies</option>
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                                    <textarea class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Deskripsi Produk"></textarea>
                                </div>
                                <div class="flex justify-between">
                                    <button type="button" onclick="closeModal()"
                                        class="bg-white border border-gray-300 px-6 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="bg-[#C68686] text-white px-6 py-2 rounded-lg hover:bg-[#a86e6e] font-semibold">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Tambah Produk --}}
                    <div id="addModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
                        <div class="bg-[#FFEAE5] p-8 rounded-2xl w-[400px] shadow-xl relative">
                            <h2 class="text-2xl font-bold mb-6 text-[#3D1F1F]">Tambah Produk</h2>
                            <form>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Nama Produk</label>
                                    <input type="text" class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Nama Produk">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Harga</label>
                                    <input type="number" class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Harga">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Stock</label>
                                    <input type="number" class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Stock">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1">Category</label>
                                    <select class="w-full p-3 rounded-md border border-gray-200 bg-white">
                                        <option>Cake</option>
                                        <option>Bread</option>
                                        <option>Cookies</option>
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                                    <textarea class="w-full p-3 rounded-md border border-gray-200 bg-white"
                                        placeholder="Deskripsi Produk"></textarea>
                                </div>
                                <div class="flex justify-between">
                                    <button type="button" onclick="closeAddModal()"
                                        class="bg-white border border-gray-300 px-6 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="bg-[#C68686] text-white px-6 py-2 rounded-lg hover:bg-[#a86e6e] font-semibold">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function openModal() {
                document.getElementById('editModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('editModal').classList.add('hidden');
            }

            // Tambahkan event listener untuk semua tombol EDIT
            document.addEventListener('DOMContentLoaded', function () {
                const editButtons = document.querySelectorAll('.btn-edit');
                editButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        openModal();
                        // Di sini kamu bisa juga load data produk ke form (optional)
                    });
                });
            });

            function openAddModal() {
                document.getElementById('addModal').classList.remove('hidden');
            }

            function closeAddModal() {
                document.getElementById('addModal').classList.add('hidden');
            }

            document.addEventListener('DOMContentLoaded', function () {
                const addButton = document.getElementById('btnAddProduct');
                addButton.addEventListener('click', function () {
                    openAddModal();
                });
            });

        </script>


    @endpush


@endsection