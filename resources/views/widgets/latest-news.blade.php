<div class="mb-14">
    <div class="flex items-end justify-between mb-8 border-b-2 border-slate-200 pb-3 relative">
        <h2 class="text-3xl font-black font-heading text-[#0F2D52] uppercase tracking-tight">
            {{ $title }}
        </h2>
        <div class="absolute bottom-[-2px] left-0 w-24 h-[2px] bg-[#D4A017]"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
        @foreach($articles as $article)
            <div class="group border-b border-slate-100 pb-6 hover:border-[#D4A017]/40 transition-colors duration-300 h-full">
                <a href="{{ url('/berita/' . $article->slug) }}" class="flex flex-col gap-4 h-full">
                    
                    {{-- Blok Gambar / Thumbnail --}}
                    <div class="w-full aspect-[16/9] overflow-hidden rounded-xl bg-slate-100 relative mb-1">
                        @if($article->hasMedia('cover'))
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 ease-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-50 border border-slate-100">
                                <span class="font-heading text-xl font-bold text-slate-300 opacity-50">NUSA<span class="text-slate-400">AKSARA</span></span>
                            </div>
                        @endif
                        
                        {{-- Overlay Gradien Tipis agar lebih dramatis --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    {{-- Metadata Kategori --}}
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#D4A017] group-hover:scale-125 transition-transform duration-300 shadow-sm"></span>
                        <span class="text-[10px] font-bold uppercase text-[#D4A017] tracking-widest font-heading">
                            {{ $article->category->name }}
                        </span>
                    </div>
                    
                    {{-- Judul Artikel --}}
                    <h3 class="text-xl md:text-[1.35rem] font-bold font-heading text-[#0F2D52] leading-snug group-hover:text-[#D4A017] transition-colors duration-300">
                        {{ $article->title }}
                    </h3>
                    
                    {{-- Kutipan Artikel & Waktu (Opsional tapi mempercantik) --}}
                    <div class="mt-auto flex flex-col gap-3">
                        <p class="text-[15px] text-slate-500 line-clamp-2 leading-relaxed font-sans">
                            {{ $article->excerpt }}
                        </p>
                        <div class="flex items-center justify-between text-xs font-medium text-slate-400 mt-2 pt-4 border-t border-slate-50/50">
                            <span class="flex items-center gap-1.5"><x-heroicon-m-user class="w-3.5 h-3.5" /> {{ $article->author->name ?? 'Redaksi' }}</span>
                            <span>{{ $article->published_at ? $article->published_at->diffForHumans() : 'Baru saja' }}</span>
                        </div>
                    </div>
                    
                </a>
            </div>
        @endforeach
    </div>
</div>