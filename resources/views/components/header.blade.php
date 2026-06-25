@inject('generalSettings', 'App\Settings\GeneralSettings')
@inject('monetizationSettings', 'App\Settings\MonetizationSettings')

@php
    // Ambil maksimal 6 kategori utama untuk navigasi Navy Blue
    $kategoriMenu = \App\Models\Category::orderBy('order_column')->take(6)->get();
@endphp

<header class="w-full bg-white border-t-[6px] border-[#0F2D52] flex flex-col">
    {{-- 1. Top Bar (Tanggal & Ekstra Info) - Tipis dan Bersih --}}
    <div class="bg-[#F5F7FA] border-b border-gray-200 text-slate-500 text-[11px] uppercase tracking-widest py-1.5 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                <span>|</span>
                <span class="text-[#D4A017] font-bold flex items-center gap-1">
                    <x-heroicon-s-bolt class="w-3 h-3" /> TRENDING:
                </span>
                <!-- Contoh Trending Ticker Tipis -->
                <a href="#" class="hover:text-[#0F2D52] transition-colors font-medium">IHSG Tembus Rekor</a>
            </div>
            
            <div class="flex gap-4 font-medium">
                <a href="{{ route('page.show', 'tentang-kami') }}" class="hover:text-[#0F2D52] transition-colors">Tentang Kami</a>
                <a href="{{ route('page.show', 'pedoman-media-siber') }}" class="hover:text-[#0F2D52] transition-colors">Pedoman Siber</a>
            </div>
        </div>
    </div>

    {{-- 2. Middle Bar (Logo Centered Authority) --}}
    <div class="max-w-7xl mx-auto w-full px-4 py-8 flex flex-col items-center justify-center relative">
        {{-- Tombol Mobile di Kiri Kiri (Posisi Absolut di Mobile) --}}
        <div class="md:hidden absolute left-4 top-1/2 -translate-y-1/2">
            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 text-slate-800 hover:bg-gray-100 rounded">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        {{-- Logo Utama --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 md:gap-4 group">
            @if($generalSettings->logo_url)
                {{-- Logo Gambar (Misal: Lambang/Ikon) jika diupload via admin --}}
                <img src="{{ asset('storage/' . $generalSettings->logo_url) }}" alt="{{ $generalSettings->site_name }}" class="h-12 md:h-16 object-contain drop-shadow-sm">
            @endif
            
            {{-- Logo Teks (Kini selalu dimunculkan, berdampingan dengan gambar) --}}
            <div class="font-heading text-4xl md:text-5xl font-extrabold tracking-tight text-[#0F2D52] group-hover:opacity-80 transition-opacity">
                NUSA<span class="text-[#D4A017]">AKSARA</span>
            </div>
        </a>

        {{-- Search Icon Mobile (Posisi Absolut di Kanan) --}}
        <div class="md:hidden absolute right-4 top-1/2 -translate-y-1/2">
            <button class="p-2 text-slate-800 hover:bg-gray-100 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </div>
    </div>

    {{-- 3. Bottom Bar (Navigasi Kategori Navy Blue) --}}
    <div class="bg-[#0F2D52] text-white sticky top-0 z-50 shadow-md border-b-[3px] border-[#0A1F38]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center md:justify-between items-center h-14">
                
                {{-- Kategori Desktop Dinamis (Rata Tengah / Kiri) --}}
                <nav class="hidden md:flex space-x-1 font-heading font-bold text-[13px] uppercase tracking-wider h-full w-full justify-center">
                    <a href="{{ url('/') }}" class="flex items-center px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->is('/') ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white hover:border-gray-400' }}">
                        Beranda
                    </a>
                    
                    @foreach($kategoriMenu as $kat)
                        <a href="{{ route('category.show', $kat->slug) }}" class="flex items-center px-4 h-full hover:bg-[#1A3F6D] transition-colors border-b-[3px] {{ request()->is('kategori/' . $kat->slug) ? 'border-[#D4A017] text-[#D4A017]' : 'border-transparent text-white hover:border-gray-400' }}">
                            {{ $kat->name }}
                        </a>
                    @endforeach
                    
                    <a href="#" class="flex items-center px-4 h-full hover:bg-[#1A3F6D] transition-colors text-white border-b-[3px] border-transparent hover:border-[#D4A017] hover:text-[#D4A017]">
                        Indeks
                    </a>
                </nav>

                {{-- Teks Panduan Mobile (Hanya muncul di HP) --}}
                <div class="md:hidden font-heading font-bold text-sm tracking-widest text-[#D4A017]">
                    MENU UTAMA
                </div>
            </div>
        </div>

        {{-- Mobile Menu Dropdown Dinamis (Tampil saat Hamburger diklik) --}}
        <div id="mobile-menu" class="hidden md:hidden bg-[#0A1F38] border-t border-slate-700">
            <a href="{{ url('/') }}" class="block px-6 py-4 text-sm font-bold uppercase hover:bg-[#1A3F6D] border-b border-slate-700/50 {{ request()->is('/') ? 'text-[#D4A017]' : 'text-white' }}">
                Beranda
            </a>
            
            @foreach(\App\Models\Category::orderBy('order_column')->get() as $katMobile)
                <a href="{{ route('category.show', $katMobile->slug) }}" class="flex justify-between items-center px-6 py-4 text-sm font-bold uppercase hover:bg-[#1A3F6D] border-b border-slate-700/50 {{ request()->is('kategori/' . $katMobile->slug) ? 'text-[#D4A017]' : 'text-white' }}">
                    {{ $katMobile->name }}
                    <x-heroicon-m-chevron-right class="w-4 h-4 opacity-50" />
                </a>
            @endforeach
        </div>
    </div>
</header>