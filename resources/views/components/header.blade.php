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

{{-- CSS Kustom untuk memaksa header tetap Fixed/Sticky dan menonaktifkan Auto-Hide dari app.blade.php --}}
<style>
    #smart-header-wrapper {
        transform: translateY(0) !important; 
        position: sticky !important;
        top: 0 !important;
    }
</style>

<header class="w-full bg-white flex flex-col border-t-[6px] border-[#0F2D52] shadow-sm relative z-50">
    
    {{-- 1. Top Bar --}}
    <div class="bg-slate-50 border-b border-gray-200 text-slate-500 text-[11px] uppercase tracking-widest py-1.5 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                <span class="text-slate-300">|</span>
                
                {{-- Penambahan efek Pulse pada label Trending --}}
                <span class="text-[#D4A017] font-bold flex items-center gap-1.5 relative">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#D4A017] opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-[#D4A017]"></span>
                    </span>
                    TRENDING:
                </span>
                <a href="#" class="hover:text-[#0F2D52] transition-colors font-medium">IHSG Tembus Rekor Baru Hari Ini</a>
            </div>
            
            <div class="flex gap-5 font-medium">
                <a href="{{ route('page.show', 'tentang-kami') }}" class="hover:text-[#0F2D52] transition-colors">Tentang Kami</a>
                <a href="{{ route('page.show', 'pedoman-media-siber') }}" class="hover:text-[#0F2D52] transition-colors">Pedoman Siber</a>
            </div>
        </div>
    </div>

    {{-- 2. Middle Bar --}}
    <div class="max-w-7xl mx-auto w-full px-4 py-6 md:py-8 flex flex-col items-center justify-center relative bg-white">
        
        {{-- Tombol Hamburger Mobile --}}
        <div class="md:hidden absolute left-4 top-1/2 -translate-y-1/2">
            <button onclick="toggleMobileMenu()" class="p-2 text-slate-800 hover:bg-gray-100 hover:text-[#0F2D52] rounded transition-colors focus:ring-2 focus:ring-[#0F2D52] outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h8"></path></svg>
            </button>
        </div>

        <a href="{{ url('/') }}" class="flex items-center gap-3 md:gap-4 group">
            @if($generalSettings->logo_url)
                <img src="{{ asset('storage/' . $generalSettings->logo_url) }}" alt="{{ $generalSettings->site_name }}" class="h-10 md:h-14 object-contain drop-shadow-sm group-hover:scale-105 transition-transform duration-300">
            @endif
            <div class="font-heading text-3xl md:text-5xl font-extrabold tracking-tight text-[#0F2D52] group-hover:opacity-90 transition-opacity">
                NUSA<span class="text-[#D4A017]">AKSARA</span>
            </div>
        </a>
    </div>

    {{-- 3. Bottom Bar (Navigasi Kategori Navy Blue) -- HANYA TAMPIL DI DESKTOP --}}
    <div class="hidden md:block bg-[#0F2D52] text-white shadow-md border-b-[3px] border-[#0A1F38]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14 relative">
                
                {{-- KIRI: Mini Logo (Solusi saat discroll) --}}
              

                {{-- TENGAH: Kategori Desktop Dinamis --}}
                <nav class="hidden md:flex flex-1 justify-center space-x-1 font-heading font-bold text-[13px] uppercase tracking-wider h-full">
                    
                    <a href="{{ url('/') }}" class="flex items-center px-3 lg:px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->is('/') ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white' }}">
                        Beranda
                    </a>

                    @foreach($mainCategories as $kat)
                        <div class="relative group h-full">
                            <a href="{{ route('category.show', $kat->slug) }}" class="flex items-center px-3 lg:px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->is('kategori/' . $kat->slug) ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white' }}">
                                {{ $kat->name }}
                                @if($kat->children->isNotEmpty())
                                    <x-heroicon-m-chevron-down class="w-4 h-4 ml-1 opacity-70 group-hover:rotate-180 transition-transform duration-300" />
                                @endif
                            </a>

                            {{-- Dropdown Sub-Kategori (Dengan efek fade-in up) --}}
                            @if($kat->children->isNotEmpty())
                                <div class="absolute left-0 top-[120%] opacity-0 invisible group-hover:top-full group-hover:opacity-100 group-hover:visible w-52 bg-white border-t-[3px] border-[#D4A017] shadow-xl transition-all duration-300 ease-out z-50">
                                    @foreach($kat->children as $child)
                                        <a href="{{ route('category.show', $child->slug) }}" class="block px-5 py-3 text-sm text-slate-700 hover:bg-slate-50 hover:text-[#0F2D52] hover:pl-6 border-b border-slate-100 transition-all font-sans font-semibold">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    {{-- Menu "Lainnya" --}}
                    @if($moreCategories->isNotEmpty())
                        <div class="relative group h-full">
                            <button class="flex items-center px-3 lg:px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] border-transparent text-white uppercase focus:outline-none">
                                Lainnya
                                <x-heroicon-m-bars-3 class="w-4 h-4 ml-1.5 opacity-70" />
                            </button>

                            {{-- Mega Menu 3 Kolom --}}
                            <div class="absolute right-0 top-[120%] opacity-0 invisible group-hover:top-full group-hover:opacity-100 group-hover:visible w-[450px] lg:w-[700px] bg-white border-t-[3px] border-[#D4A017] shadow-2xl p-6 cursor-default transition-all duration-300 ease-out z-50 rounded-b-md">
                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-8 max-h-[60vh] overflow-y-auto custom-scrollbar pr-2">
                                    @foreach($moreCategories as $moreKat)
                                        <div class="flex flex-col">
                                            <a href="{{ route('category.show', $moreKat->slug) }}" class="text-[15px] font-black font-heading text-[#0F2D52] hover:text-[#D4A017] border-b-2 border-slate-100 pb-2 mb-3 transition-colors">
                                                {{ $moreKat->name }}
                                            </a>
                                            @if($moreKat->children->isNotEmpty())
                                                <div class="flex flex-col space-y-2">
                                                    @foreach($moreKat->children as $moreChild)
                                                        <a href="{{ route('category.show', $moreChild->slug) }}" class="text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-[#0F2D52] flex items-center group/link transition-colors">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-2.5 inline-block group-hover/link:bg-[#D4A017] transition-colors"></span>
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

                    <a href="{{ route('indeks') }}" class="flex items-center px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->routeIs('indeks') ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white' }}">
                        Indeks
                    </a>
                </nav>

                {{-- KANAN: Pencarian Desktop --}}
                <div class="hidden md:flex items-center justify-end w-48 shrink-0 gap-4 border-l border-slate-700/50 pl-5">
                    <a href="{{ route('search') }}" class="flex items-center gap-2 hover:text-[#D4A017] transition-colors bg-white/10 px-3 py-1.5 rounded-full font-bold text-[10px] tracking-widest uppercase">
                        Cari <x-heroicon-o-magnifying-glass class="w-3.5 h-3.5" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu (Terpisah dari wrapper biru desktop) --}}
    <div id="mobile-menu" class="md:hidden bg-[#0A1F38] border-t border-slate-700 overflow-y-auto custom-scrollbar transition-all duration-300 ease-in-out max-h-0 opacity-0 text-white shadow-inner">
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
                
                @if($katMobile->children->isNotEmpty())
                    <div class="bg-[#08182b] border-t border-slate-800">
                        @foreach($katMobile->children as $childMobile)
                            <a href="{{ route('category.show', $childMobile->slug) }}" class="flex items-center pl-10 pr-6 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 hover:text-white hover:bg-[#1A3F6D] border-b border-slate-800 last:border-0">
                                <span class="w-1 h-1 rounded-full bg-[#D4A017] mr-3"></span>
                                {{ $childMobile->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</header>