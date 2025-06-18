<div class="grid grid-cols-1 gap-6 overflow-y-auto flex-grow pr-2">
    @if(isset($storeLocations) && $storeLocations->count() > 0)
        @foreach($storeLocations as $store)
            <div class="bg-[#FFF1EA] rounded-lg shadow-lg p-6 flex items-start space-x-6">

                <img src="{{ asset('images/store/' . $store->img) }}"
                    alt="{{ $store->nama_toko }}"
                    class="w-36 h-36 md:w-48 md:h-48 object-cover rounded-lg flex-shrink-0">


                <div class="flex-1">
                    <p class="text-gray-500 text-sm">Nama Toko:</p>
                    <h3 class="text-xl md:text-2xl font-semibold text-gray-800 mb-1">{{ $store->nama_toko }}</h3>

                    <p class="text-gray-500 text-sm">Alamat:</p>
                    <p class="text-base text-gray-700 mb-1">{{ $store->alamat }}</p>

                    <p class="text-gray-500 text-sm">Telepon:</p>
                    <p class="text-base text-gray-700 mb-1">{{ $store->telp }}</p>

                    <p class="text-gray-500 text-sm">Link Lokasi:</p>
                    <a href="{{ $store->link_location }}" target="_blank"
                        class="inline-block text-sm text-white bg-pink-400 hover:bg-pink-500 px-4 py-2 rounded-full transition duration-300 mt-1">
                        Lihat Lokasi
                    </a>
                </div>


                <div class="flex flex-col space-y-2 items-end flex-shrink-0">

                    <button
                        onclick="openEditModal(
                            {{ $store->id_store }},
                            '{{ addslashes($store->nama_toko) }}',
                            '{{ addslashes($store->alamat) }}',
                            '{{ addslashes($store->telp) }}',
                            '{{ addslashes($store->link_location) }}',
                            '{{ $store->latitude }}',
                            '{{ $store->longitude }}'
                        )"
                        class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-center text-sm">
                        Edit
                    </button>

                    <form action="{{ route('admin.store.destroy', $store->id_store) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus toko ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center bg-red-200 hover:bg-red-300 text-red-800 font-bold py-2 px-4 rounded-lg shadow-sm w-24 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 8a1 1 0 011-1h6a1 1 0 010 2H7a1 1 0 01-1-1zM4 6a2 2 0 012-2h8a2 2 0 012 2v1H4V6zM4 9h12v7a2 2 0 01-2 2H6a2 2 0 01-2-2V9z" clip-rule="evenodd" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-span-full text-center py-10">
            <p class="text-gray-500 text-xl">Belum ada lokasi toko yang tersedia.</p>
        </div>
    @endif
</div>