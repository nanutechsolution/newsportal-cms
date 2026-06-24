@inject('generalSettings', 'App\Settings\GeneralSettings')
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    @if($generalSettings->logo_url)
                        <img class="h-10 w-auto" src="{{ asset('storage/' . $generalSettings->logo_url) }}" alt="{{ $generalSettings->site_name }}">
                    @else
                        <!-- Teks Fallback jika Admin belum upload logo -->
                        <span class="font-black text-2xl tracking-tighter text-red-700">{{ strtoupper($generalSettings->site_name) }}</span>
                    @endif
                </a>
            </div>

            <!-- Menu Kategori Dinamis -->
            <nav class="hidden md:flex space-x-6">
                @php
                    // Mengambil 5 kategori utama secara dinamis
                    $categories = \App\Models\Category::whereNull('parent_id')->orderBy('order_column')->take(5)->get();
                @endphp
                
                @foreach($categories as $category)
                    <a href="#" class="text-gray-700 hover:text-red-700 px-3 py-2 rounded-md text-sm font-bold uppercase transition-colors">
                        {{ $category->name }}
                    </a>
                @endforeach
            </nav>

            <!-- Menu Hamburger Mobile -->
            <div class="flex md:hidden">
                <button type="button" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>
</header>