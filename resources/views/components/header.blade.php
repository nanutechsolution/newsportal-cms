@inject('generalSettings', 'App\Settings\GeneralSettings')
@inject('monetizationSettings', 'App\Settings\MonetizationSettings')

@php
    // 1. Ambil HANYA Kategori Utama (Parent) beserta Sub-kategorinya
    $allCategories = \App\Models\Category::whereNull('parent_id')
        ->with('children')
        ->orderBy('order_column')
        ->get();

    // 2. Pisahkan untuk Desktop: 6 Kategori pertama untuk menu utama, sisanya masuk menu "Lainnya"
    $mainCategories = $allCategories->take(6);
    $moreCategories = $allCategories->skip(6);
@endphp

<header class="w-full bg-white border-t-[6px] border-[#0F2D52] flex flex-col">
    {{-- 1. Top Bar --}}
    <div class="bg-[#F5F7FA] border-b border-gray-200 text-slate-500 text-[11px] uppercase tracking-widest py-1.5 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                <span>|</span>
                <span class="text-[#D4A017] font-bold flex items-center gap-1">
                    <x-heroicon-s-bolt class="w-3 h-3" /> TRENDING:
                </span>
                <a href="#" class="hover:text-[#0F2D52] transition-colors font-medium">IHSG Tembus Rekor</a>
            </div>
            
            <div class="flex gap-4 font-medium">
                <a href="{{ route('page.show', 'tentang-kami') }}" class="hover:text-[#0F2D52] transition-colors">Tentang Kami</a>
                <a href="{{ route('page.show', 'pedoman-media-siber') }}" class="hover:text-[#0F2D52] transition-colors">Pedoman Siber</a>
            </div>
        </div>
    </div>

    {{-- 2. Middle Bar --}}
    <div class="max-w-7xl mx-auto w-full px-4 py-8 flex flex-col items-center justify-center relative">
        <div class="md:hidden absolute left-4 top-1/2 -translate-y-1/2">
            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 text-slate-800 hover:bg-gray-100 rounded">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <a href="{{ url('/') }}" class="flex items-center gap-3 md:gap-4 group">
            @if($generalSettings->logo_url)
                <img src="{{ asset('storage/' . $generalSettings->logo_url) }}" alt="{{ $generalSettings->site_name }}" class="h-12 md:h-16 object-contain drop-shadow-sm">
            @endif
            <div class="font-heading text-4xl md:text-5xl font-extrabold tracking-tight text-[#0F2D52] group-hover:opacity-80 transition-opacity">
                NUSA<span class="text-[#D4A017]">AKSARA</span>
            </div>
        </a>
    </div>

    {{-- 3. Bottom Bar (Navigasi Kategori Navy Blue) --}}
    <div class="bg-[#0F2D52] text-white sticky top-0 z-50 shadow-md border-b-[3px] border-[#0A1F38]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
                
                {{-- KIRI: Mini Logo (Solusi agar identitas brand tetap ada saat pembaca men-scroll ke bawah) --}}
                <div class="hidden md:flex items-center w-48 shrink-0 border-r border-slate-700/50 py-2 mr-4">
                    <a href="{{ url('/') }}" class="font-heading font-extrabold text-xl tracking-tight text-white hover:text-[#D4A017] transition-colors truncate">
                        NUSA<span class="text-[#D4A017]">AKSARA</span>
                    </a>
                </div>

                {{-- TENGAH: Kategori Desktop Dinamis --}}
                <nav class="hidden md:flex flex-1 justify-center space-x-1 font-heading font-bold text-[13px] uppercase tracking-wider h-full">
                    
                    {{-- Menu Beranda --}}
                    <a href="{{ url('/') }}" class="flex items-center px-3 lg:px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->is('/') ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white' }}">
                        Beranda
                    </a>

                    {{-- 6 Menu Utama + Dropdown Sub-Kategori --}}
                    @foreach($mainCategories as $kat)
                        <div class="relative group h-full">
                            <a href="{{ route('category.show', $kat->slug) }}" class="flex items-center px-3 lg:px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->is('kategori/' . $kat->slug) ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white' }}">
                                {{ $kat->name }}
                                {{-- Icon panah bawah jika punya sub-kategori --}}
                                @if($kat->children->isNotEmpty())
                                    <x-heroicon-m-chevron-down class="w-4 h-4 ml-1 opacity-70 group-hover:rotate-180 transition-transform" />
                                @endif
                            </a>

                            {{-- Dropdown Sub-Kategori (Standar) --}}
                            @if($kat->children->isNotEmpty())
                                <div class="absolute left-0 top-full hidden group-hover:block w-48 bg-white border-t-[3px] border-[#D4A017] shadow-xl">
                                    @foreach($kat->children as $child)
                                        <a href="{{ route('category.show', $child->slug) }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 hover:text-[#0F2D52] border-b border-slate-100 transition-colors">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    {{-- Menu "Lainnya" (Muncul jika Kategori lebih dari 6) --}}
                    @if($moreCategories->isNotEmpty())
                        <div class="relative group h-full">
                            <button class="flex items-center px-3 lg:px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] border-transparent text-white uppercase focus:outline-none">
                                Lainnya
                                <x-heroicon-m-bars-3 class="w-4 h-4 ml-1 opacity-70" />
                            </button>

                            {{-- Dropdown "Lainnya" menggunakan Layout Grid (Mega Menu 3 Kolom) --}}
                            <div class="absolute right-0 top-full hidden group-hover:block w-[450px] lg:w-[650px] bg-white border-t-[3px] border-[#D4A017] shadow-2xl p-5 cursor-default">
                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6 max-h-[65vh] overflow-y-auto custom-scrollbar pr-3">
                                    @foreach($moreCategories as $moreKat)
                                        <div class="flex flex-col">
                                            <a href="{{ route('category.show', $moreKat->slug) }}" class="text-sm font-extrabold font-heading text-[#0F2D52] hover:text-[#D4A017] border-b-2 border-slate-100 pb-1.5 mb-2 transition-colors">
                                                {{ $moreKat->name }}
                                            </a>
                                            {{-- Sub-kategori di dalam Mega Menu (di-indent ke kanan) --}}
                                            @if($moreKat->children->isNotEmpty())
                                                <div class="flex flex-col space-y-1.5">
                                                    @foreach($moreKat->children as $moreChild)
                                                        <a href="{{ route('category.show', $moreChild->slug) }}" class="text-[11px] font-bold uppercase tracking-widest text-slate-500 hover:text-[#0F2D52] flex items-center group/link transition-colors">
                                                            <span class="w-1 h-1 rounded-full bg-[#D4A017] mr-2 inline-block group-hover/link:w-2 transition-all"></span>
                                                            {{ $moreChild->name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Menu Indeks --}}
                    <a href="{{ route('indeks') }}" class="flex items-center px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->routeIs('indeks') ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white' }}">
                        Indeks
                    </a>
                </nav>

                {{-- KANAN: Pencarian Desktop & Indeks --}}
                <div class="hidden md:flex items-center justify-end w-48 shrink-0 gap-4 border-l border-slate-700/50 pl-4">
                    <a href="{{ route('indeks') }}" class="text-xs font-bold hover:text-[#D4A017] transition-colors uppercase tracking-widest hidden lg:block {{ request()->routeIs('indeks') ? 'text-[#D4A017]' : 'text-white' }}">Indeks</a>
                    <a href="{{ route('search') }}" class="hover:text-[#D4A017] transition-colors bg-white/10 p-2 rounded-full">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4" />
                    </a>
                </div>

                {{-- Teks Panduan Mobile --}}
                <div class="md:hidden font-heading font-bold text-sm tracking-widest text-[#D4A017]">
                    MENU UTAMA
                </div>
            </div>
        </div>

        {{-- Mobile Menu (Dilengkapi class custom-scrollbar) --}}
        <div id="mobile-menu" class="hidden md:hidden bg-[#0A1F38] border-t border-slate-700 max-h-[75vh] overflow-y-auto custom-scrollbar">
            <a href="{{ route('search') }}" class="flex items-center gap-3 px-6 py-4 text-sm font-bold uppercase text-[#D4A017] hover:bg-[#1A3F6D] border-b border-slate-700/50">
                <x-heroicon-o-magnifying-glass class="w-4 h-4" /> Cari Berita...
            </a>
            <a href="{{ url('/') }}" class="block px-6 py-4 text-sm font-bold uppercase hover:bg-[#1A3F6D] border-b border-slate-700/50 {{ request()->is('/') ? 'text-[#D4A017]' : 'text-white' }}">
                Beranda
            </a>
            
            @foreach($allCategories as $katMobile)
                <div class="border-b border-slate-700/50">
                    <a href="{{ route('category.show', $katMobile->slug) }}" class="flex justify-between items-center px-6 py-4 text-sm font-bold uppercase hover:bg-[#1A3F6D] {{ request()->is('kategori/' . $katMobile->slug) ? 'text-[#D4A017]' : 'text-white' }}">
                        {{ $katMobile->name }}
                    </a>
                    
                    {{-- Sub-kategori untuk Mobile --}}
                    @if($katMobile->children->isNotEmpty())
                        <div class="bg-[#08182b] border-t border-slate-800">
                            @foreach($katMobile->children as $childMobile)
                                <a href="{{ route('category.show', $childMobile->slug) }}" class="flex items-center pl-10 pr-6 py-3 text-xs font-medium uppercase text-slate-300 hover:text-white hover:bg-[#1A3F6D] border-b border-slate-800 last:border-0">
                                    <x-heroicon-m-minus class="w-3 h-3 mr-2 text-[#D4A017]" />
                                    {{ $childMobile->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</header>

{{-- Style Khusus untuk Scrollbar Elegan (Karena konten kategori bisa sangat banyak) --}}
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9; /* slate-100 */
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; /* slate-300 */
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #D4A017; /* Emas saat di-hover */
    }
    
    /* Tema Gelap Khusus untuk Scrollbar Mobile Menu */
    #mobile-menu.custom-scrollbar::-webkit-scrollbar-track {
        background: #0F2D52;
    }
    #mobile-menu.custom-scrollbar::-webkit-scrollbar-thumb {
        background: #1e40af;
    }
</style>