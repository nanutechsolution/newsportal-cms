<x-layouts.app :title="'Topik: #' . $tag->name">
    <div class="bg-[#0F2D52] pt-16 pb-12 border-b-8 border-[#D4A017] relative overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 right-0 opacity-5 pointer-events-none">
            <svg width="300" height="300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col items-center text-center">
            <span class="inline-block px-3 py-1 bg-white/10 text-[#D4A017] font-bold tracking-widest uppercase text-xs rounded-full mb-4 border border-white/20">
                Fokus Isu Terkini
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white font-heading tracking-tight mb-4">
                #{{ $tag->name }}
            </h1>
            <p class="text-blue-100 max-w-2xl text-sm md:text-base font-medium leading-relaxed">
                Kumpulan berita, laporan mendalam, dan pembaruan terkini yang disusun oleh tim redaksi kami terkait topik <strong>{{ $tag->name }}</strong>.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        
        <div class="flex items-center justify-between mb-8 pb-4 border-b-2 border-gray-100">
            <h2 class="text-2xl font-heading font-extrabold text-[#0F2D52] uppercase tracking-tight">Kabar Terbaru</h2>
            <span class="text-sm font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-md">{{ $articles->total() }} Artikel Ditemukan</span>
        </div>

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach($articles as $article)
                    <article class="group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:border-[#0F2D52]/20 transition-all duration-300 flex flex-col h-full">
                        
                        {{-- Cover Image --}}
                        <a href="{{ route('article.show', $article->slug) }}" class="block w-full h-48 overflow-hidden relative bg-slate-100 shrink-0">
                            @if($article->hasMedia('cover'))
                                <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <x-heroicon-o-photo class="w-10 h-10 text-gray-300" />
                                </div>
                            @endif
                            
                            {{-- Label Kategori Melayang --}}
                            <div class="absolute bottom-3 left-3">
                                <span class="bg-[#D4A017] text-[#0F2D52] text-[10px] font-extrabold uppercase px-2 py-1 rounded shadow-sm">
                                    {{ $article->category->name ?? 'News' }}
                                </span>
                            </div>
                        </a>
                        
                        {{-- Konten Teks --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-heading font-bold text-gray-900 group-hover:text-[#0F2D52] mb-3 leading-snug line-clamp-3">
                                <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            
                            {{-- Metadata (Bawah) --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500 font-medium">
                                <span class="flex items-center gap-1.5 truncate">
                                    <x-heroicon-s-user-circle class="w-4 h-4 text-slate-400" />
                                    {{ $article->author->name ?? 'Redaksi' }}
                                </span>
                                <span class="shrink-0 flex items-center gap-1">
                                    <x-heroicon-o-clock class="w-3.5 h-3.5" />
                                    {{ $article->published_at ? $article->published_at->diffForHumans() : '' }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-14 flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-24 bg-[#F5F7FA] rounded-2xl border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <x-heroicon-o-hashtag class="w-10 h-10 text-[#D4A017]" />
                </div>
                <h3 class="text-2xl font-heading font-bold text-[#0F2D52]">Topik Masih Kosong</h3>
                <p class="text-gray-500 mt-2 max-w-md mx-auto">Redaksi kami sedang menyiapkan liputan terbaik untuk topik ini. Silakan kembali lagi nanti.</p>
            </div>
        @endif

    </div>
</x-layouts.app>