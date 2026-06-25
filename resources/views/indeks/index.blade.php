<x-layouts.app title="Indeks Berita | {{ \App\Models\Site::first()?->name ?? 'NusaAksara' }}" description="Indeks seluruh berita yang diterbitkan berdasarkan tanggal.">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-[60vh]">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">

            {{-- ========================================== --}}
            {{-- KOLOM KIRI: KONTEN UTAMA (Indeks Berita) --}}
            {{-- ========================================== --}}
            <main class="w-full lg:w-[70%]">
                
                {{-- Header & Title --}}
                <div class="mb-8 border-b-2 border-gray-100 pb-4">
                    <h1 class="text-3xl md:text-4xl font-heading font-extrabold text-[#0F2D52] tracking-tight uppercase">
                        Indeks Berita
                    </h1>
                    <p class="text-slate-500 mt-2">
                        Menampilkan seluruh berita yang diterbitkan pada 
                        <span class="font-bold text-[#D4A017]">
                            {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                        </span>
                    </p>
                </div>

                {{-- Kotak Filter Tanggal --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 mb-8 shadow-sm">
                    <form action="{{ route('indeks') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="w-full sm:w-auto flex-1">
                            <label for="tanggal" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-widest">Pilih Tanggal Indeks</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                    <x-heroicon-o-calendar class="w-5 h-5" />
                                </div>
                                <input type="date" id="tanggal" name="tanggal" value="{{ $selectedDate }}" 
                                       class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-[#0F2D52] focus:border-[#0F2D52] block w-full pl-10 p-2.5 font-medium transition-colors"
                                       max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <button type="submit" class="w-full sm:w-auto bg-[#0F2D52] hover:bg-[#D4A017] text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-md flex items-center justify-center gap-2">
                            <x-heroicon-m-magnifying-glass class="w-5 h-5" /> Tampilkan
                        </button>
                    </form>
                </div>

                {{-- Daftar Artikel (List View) --}}
                <div class="flex flex-col">
                    @forelse($articles as $article)
                        <article class="flex flex-col sm:flex-row gap-5 border-b border-gray-100 py-6 group first:pt-0">
                            
                            {{-- Thumbnail Berita --}}
                            <a href="{{ route('article.show', $article->slug) }}" class="w-full sm:w-48 lg:w-56 shrink-0 aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 relative shadow-sm block">
                                @if($article->hasMedia('cover'))
                                    <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <x-heroicon-o-photo class="w-12 h-12" />
                                    </div>
                                @endif
                                
                                {{-- Label Kategori di Atas Gambar (Mobile) --}}
                                <div class="sm:hidden absolute top-2 left-2 bg-[#D4A017] text-white text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded shadow-sm">
                                    {{ $article->category->name ?? 'News' }}
                                </div>
                            </a>

                            {{-- Konten Text --}}
                            <div class="flex flex-col justify-center flex-1">
                                {{-- Meta Data Atas --}}
                                <div class="hidden sm:flex items-center gap-3 mb-2">
                                    <a href="{{ $article->category ? route('category.show', $article->category->slug) : '#' }}" class="text-xs font-heading font-extrabold text-[#D4A017] uppercase tracking-widest hover:underline">
                                        {{ $article->category->name ?? 'News' }}
                                    </a>
                                    <span class="text-slate-300 text-xs">•</span>
                                    <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                        <x-heroicon-o-clock class="w-3.5 h-3.5" />
                                        {{ $article->published_at ? $article->published_at->format('H:i') : $article->created_at->format('H:i') }} WIB
                                    </span>
                                </div>

                                {{-- Judul --}}
                                <a href="{{ route('article.show', $article->slug) }}" class="block mb-2 sm:mb-3">
                                    <h2 class="text-xl md:text-2xl font-bold font-heading text-[#0F2D52] leading-tight group-hover:text-[#D4A017] transition-colors line-clamp-3">
                                        {{ $article->title }}
                                    </h2>
                                </a>

                                {{-- Excerpt (Kutipan) --}}
                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-3 hidden md:block">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                                </p>

                                {{-- Waktu (Mobile Only) --}}
                                <div class="sm:hidden text-xs text-slate-500 font-medium flex items-center gap-1 mt-auto">
                                    <x-heroicon-o-clock class="w-3.5 h-3.5" />
                                    {{ $article->published_at ? $article->published_at->format('H:i') : $article->created_at->format('H:i') }} WIB
                                </div>
                            </div>
                        </article>
                    @empty
                        {{-- State Kosong (Tidak ada berita di tanggal tersebut) --}}
                        <div class="bg-[#F5F7FA] border border-dashed border-slate-300 rounded-2xl p-10 text-center flex flex-col items-center justify-center">
                            <div class="bg-white p-4 rounded-full shadow-sm mb-4">
                                <x-heroicon-o-document-magnifying-glass class="w-10 h-10 text-slate-400" />
                            </div>
                            <h3 class="text-xl font-heading font-bold text-[#0F2D52] mb-2">Tidak Ada Berita</h3>
                            <p class="text-slate-500 text-sm max-w-md mx-auto">
                                Kami belum menerbitkan atau tidak menemukan berita pada tanggal <span class="font-bold">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span>. Silakan pilih tanggal lain.
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination Nav --}}
                @if($articles->hasPages())
                    <div class="mt-10 border-t border-gray-100 pt-8">
                        {{ $articles->appends(['tanggal' => $selectedDate])->links() }}
                    </div>
                @endif
            </main>

            {{-- ========================================== --}}
            {{-- KOLOM KANAN: SIDEBAR (Lebar 30%) --}}
            {{-- ========================================== --}}
            <aside class="w-full lg:w-[30%]">
                <div class="sticky top-24 flex flex-col gap-8">
                    
                    {{-- Widget Pencarian --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <h3 class="text-lg font-heading font-extrabold text-[#0F2D52] uppercase tracking-wider mb-4 border-b-2 border-gray-100 pb-3">
                            Pencarian Arsip
                        </h3>
                        <form action="{{ route('search') }}" method="GET">
                            <div class="relative">
                                <input type="text" name="q" placeholder="Cari topik atau kata kunci..." class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 pr-10 text-sm focus:ring-2 focus:ring-[#0F2D52] focus:border-transparent outline-none transition-all">
                                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#D4A017] p-1">
                                    <x-heroicon-m-magnifying-glass class="w-5 h-5" />
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Banner Iklan Sidebar (Opsional) --}}
                    @if(isset($monetizationSettings) && $monetizationSettings->sidebar_ad_code)
                    <div class="w-full overflow-hidden rounded-xl shadow-sm">
                        {!! $monetizationSettings->sidebar_ad_code !!}
                    </div>
                    @else
                    <div class="w-full h-[250px] bg-slate-50 border border-slate-200 rounded-xl flex flex-col items-center justify-center text-slate-400 font-medium text-sm shadow-inner relative overflow-hidden group">
                        <span class="absolute top-2 right-2 bg-black/20 text-white text-[10px] px-1.5 py-0.5 rounded uppercase tracking-widest z-10">Ad</span>
                        <x-heroicon-o-megaphone class="w-8 h-8 mb-2 opacity-50 group-hover:scale-110 transition-transform" />
                        Ruang Iklan Sidebar
                        <span class="text-xs mt-1 opacity-70">(300 x 250 px)</span>
                    </div>
                    @endif

                </div>
            </aside>
            
        </div>
    </div>
</x-layouts.app>