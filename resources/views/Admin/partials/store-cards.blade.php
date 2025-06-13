@forelse ($storeLocations as $store)
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 flex flex-col h-full relative">
        <img src="{{ asset('images/store/' . $store->img) }}" alt="{{ $store->nama_toko }}"
            class="rounded-t-xl h-40 w-full object-cover">

        <div class="p-4 flex flex-col flex-1">
            <h3 class="text-lg font-semibold text-pink-600">{{ $store->nama_toko }}</h3>
            <p class="text-sm text-gray-700 mt-1">{{ $store->alamat }}</p>
            <p class="text-sm text-gray-700 mt-1">📞 {{ $store->telp }}</p>

            <a href="{{ $store->link_location }}" target="_blank"
                class="inline-block text-sm text-white bg-pink-400 hover:bg-pink-500 px-4 py-2 rounded-full transition duration-300 mt-2">
                Lihat Lokasi
            </a>

            {{-- Tombol Edit --}}
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
                class="mt-2 text-sm bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-full transition duration-300">
                Edit
            </button>
        </div>
    </div>
@empty
    <div class="col-span-full text-gray-500 text-center">
        Tidak ada toko yang cocok dengan pencarian.
    </div>
@endforelse

