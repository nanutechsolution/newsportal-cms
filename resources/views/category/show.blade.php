<x-layouts.app :title="'Berita ' . $category->name" :description="$category->description ?? 'Kumpulan berita terbaru kategori ' . $category->name">
    
    {{-- 1. HEADER KATEGORI (Gaya Portal Berita Premium) --}}
    <div class="relative bg-[#0F2D52] py-14 md:py-20 overflow-hidden border-b-4" style="border-bottom-color: {{ $category->color_hex ?? '#D4A017' }};">
        {{-- Elemen Dekoratif --}}
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-10 pointer-events-none transform translate-x-1/4 -translate-y-1/4">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-white">
                <circle cx="50" cy="50" r="50" fill="currentColor"/>
            </svg>
        </div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-white/5 to-transparent rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col items-center text-center max-w-3xl mx-auto">
                <span class="text-[#D4A017] font-bold tracking-widest text-xs sm:text-sm uppercase mb-3 block flex items-center gap-2">
                    <span class="w-8 h-[2px] bg-[#D4A017]"></span>
                    Kanal Berita
                    <span class="w-8 h-[2px] bg-[#D4A017]"></span>
                </span>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-black text-white uppercase tracking-tight mb-4 drop-shadow-sm">
                    {{ $category->name }}
                </h1>
                
                @if($category->description)
                    <p class="text-slate-300 text-base md:text-lg lg:text-xl font-medium leading-relaxed">
                        {{ $category->description }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- 2. KONTEN ARTIKEL UTAMA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
        
        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                
                @foreach($articles as $index => $article)
                    
                    {{-- HERO ARTICLE: Artikel Pertama di Halaman 1 akan dibuat Full-Width --}}
                    @if($articles->currentPage() === 1 && $index === 0)
                        <article class="col-span-1 md:col-span-2 lg:col-span-3 group bg-white rounded-2xl overflow-hidden border border-slate-100 hover:shadow-[0_20px_50px_-12px_rgba(0,0,0,0.07)] transition-all duration-300 flex flex-col lg:flex-row">
                            
                            {{-- Gambar Hero --}}
                            <a href="{{ route('article.show', $article->slug) }}" class="block overflow-hidden relative w-full lg:w-[60%] h-64 md:h-80 lg:h-[420px] shrink-0">
                                @if($article->hasMedia('cover'))
                                    <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <x-heroicon-o-photo class="w-16 h-16 text-slate-300" />
                                    </div>
                                @endif
                                
                                {{-- Badge "Fokus Hari Ini" --}}
                                <div class="absolute top-4 left-4 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded shadow-md flex items-center gap-1.5">
                                    <x-heroicon-s-star class="w-3 h-3" /> Utama
                                </div>
                            </a>
                            
                            {{-- Konten Hero --}}
                            <div class="p-6 md:p-8 lg:p-10 flex flex-col justify-center w-full lg:w-[40%] bg-white">
                                <div class="flex items-center gap-3 text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-3 md:mb-4">
                                    <span class="text-[#0F2D52]">{{ $article->author->name ?? 'Redaksi' }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span>{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : '' }}</span>
                                </div>

                                <h2 class="text-2xl md:text-3xl lg:text-[2rem] font-heading font-black text-[#0F2D52] leading-[1.2] group-hover:text-[#D4A017] transition-colors mb-4 lg:mb-5">
                                    <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                                </h2>

                                <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-6 lg:mb-8 line-clamp-3 md:line-clamp-4">
                                    {{ $article->excerpt }}
                                </p>
                                
                                <a href="{{ route('article.show', $article->slug) }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-[#0F2D52] group-hover:text-[#D4A017] transition-colors mt-auto">
                                    Baca Selengkapnya
                                    <x-heroicon-m-arrow-right class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" />
                                </a>
                            </div>
                        </article>

                    {{-- REGULAR ARTICLES: Artikel sisanya menggunakan format Grid 3 Kolom --}}
                    @else
                        <article class="group bg-white rounded-2xl overflow-hidden border border-slate-100 hover:shadow-[0_20px_50px_-12px_rgba(0,0,0,0.07)] transition-all duration-300 flex flex-col">
                            
                            {{-- Gambar Regular --}}
                            <a href="{{ route('article.show', $article->slug) }}" class="block overflow-hidden relative aspect-[16/10]">
                                @if($article->hasMedia('cover'))
                                    <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <x-heroicon-o-photo class="w-10 h-10 text-slate-300" />
                                    </div>
                                @endif
                            </a>
                            
                            {{-- Konten Regular --}}
                            <div class="p-5 md:p-6 flex flex-col flex-grow">
                                <h3 class="text-lg md:text-[19px] font-bold font-heading text-[#0F2D52] leading-snug group-hover:text-[#D4A017] transition-colors mb-3 line-clamp-3">
                                    <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                
                                <p class="text-slate-500 text-[13px] md:text-sm leading-relaxed mb-5 line-clamp-2 md:line-clamp-3">
                                    {{ $article->excerpt }}
                                </p>
                                
                                {{-- Meta Info Footer --}}
                                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-bold uppercase tracking-wider">
                                    <div class="flex items-center gap-1.5 truncate pr-2">
                                        <x-heroicon-m-user-circle class="w-4 h-4 text-[#D4A017] shrink-0" />
                                        <span class="truncate">{{ $article->author->name ?? 'Redaksi' }}</span>
                                    </div>
                                    <div class="shrink-0">
                                        {{ $article->published_at ? $article->published_at->translatedFormat('d M') : '' }}
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endif

                @endforeach
            </div>

            {{-- 3. PAGINASI --}}
            <div class="mt-14 md:mt-16 flex justify-center">
                {{ $articles->links() }}
            </div>

        @else
            {{-- 4. KONDISI KOSONG (Empty State yang Elegan) --}}
            <div class="text-center py-24 px-4 bg-white rounded-3xl shadow-sm border border-slate-100 max-w-3xl mx-auto">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <x-heroicon-o-newspaper class="w-12 h-12 text-slate-300" />
                </div>
                <h3 class="text-2xl font-black font-heading text-[#0F2D52] mb-3">Belum Ada Publikasi</h3>
                <p class="text-slate-500 text-base max-w-md mx-auto">Redaksi kami sedang menyusun laporan terbaru untuk kategori <strong>{{ $category->name }}</strong>. Silakan kembali lagi nanti.</p>
                
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 mt-8 px-6 py-3 bg-[#0F2D52] text-white text-sm font-bold rounded-lg hover:bg-[#D4A017] transition-colors">
                    <x-heroicon-m-arrow-left class="w-4 h-4" /> Kembali ke Beranda
                </a>
            </div>
        @endif

    </div>
</x-layouts.app>