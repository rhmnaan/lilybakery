{{-- resources/views/layouts/sidebar.blade.php --}}
<div class="w-64 bg-[#FFF7F3] pt-4">
    <div class="p-4">
        {{-- Logo Section --}}
        <div class="flex flex-col items-center justify-center bg-[#E59CAA] rounded-lg py-4 px-2 mb-6 shadow-sm">
            <img src="{{ asset('images/logo.png') }}" alt="Lily Bakery" class="max-w-full h-auto">
        </div>
    </div>
    <nav class="mt-2 space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]
            @if(Request::routeIs('admin.dashboard')) bg-[#F9D8D9] text-gray-900 font-semibold @endif">
            <i class="far fa-check-circle mr-3 text-xl"></i>
            <span>Dashboard</span>
        </a>

        {{-- Kategori --}}
        <a href="{{ route('admin.kategori') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]
            @if(Request::routeIs('admin.kategori')) bg-[#F9D8D9] text-gray-900 font-semibold @endif">
            <i class="fas fa-list-alt mr-3 text-xl"></i>
            <span>Kategori</span>
        </a>

        

        {{-- Product --}}
        <a href="{{ route('admin.product') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
            <i class="far fa-edit mr-3 text-xl"></i>
            <span>Product</span>
        </a>

        {{-- Orders --}}
        <a href="{{ route('admin.orders') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
            <i class="fas fa-shopping-bag mr-3 text-xl"></i>
            <span>Orders</span>
        </a>

        {{-- Customers --}}
        <a href="{{ route('admin.customers') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
            <i class="far fa-user mr-3 text-xl"></i>
            <span>Customers</span>
        </a>

        {{-- Store --}}
        <a href="{{ route('admin.store') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]
            @if(Request::routeIs('admin.store')) bg-[#F9D8D9] text-gray-900 font-semibold @endif">
            <i class="fas fa-store mr-3 text-xl"></i>
            <span>Store</span>
        </a>

        {{-- Setting --}}
        <a href="{{ route('admin.settings') }}" class="flex items-center px-6 py-3 rounded-md text-gray-700 hover:bg-[#FFEAEA]">
            <i class="fas fa-cog mr-3 text-xl"></i>
            <span>Setting</span>
        </a>

        {{-- Logout --}}
        <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" class="block w-full">
            @csrf
            <button type="submit" class="flex items-center w-full px-6 py-3 rounded-md text-gray-700 hover:bg-red-100 hover:text-red-700">
                <i class="fas fa-sign-out-alt mr-3 text-xl"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</div>
