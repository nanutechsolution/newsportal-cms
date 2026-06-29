<div class="bg-[#0A1F38] rounded-2xl shadow-2xl mb-8 relative overflow-hidden border border-[#D4A017]/20">
    {{-- Aksen Garis Emas di Atas --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#D4A017] via-yellow-400 to-[#D4A017]"></div>

    <div class="flex items-center justify-between p-6 border-b border-white/10">
        <h3 class="text-base font-heading font-black text-white uppercase tracking-[0.2em] flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#D4A017] animate-pulse"></span>
            Pilihan Editor
        </h3>
    </div>

    <div class="flex flex-col">
        @foreach($articles as $index => $article)
            
            @if($index === 0)
                {{-- Berita Ke-1 (Hero Post) --}}
                <a href="{{ url('/berita/' . $article->slug) }}" class="group relative block h-64 md:h-72 w-full overflow-hidden border-b border-white/10">
                    @if($article->hasMedia('cover'))
                        <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-in-out opacity-80">
                    @endif
                    
                    {{-- Gradient Overlay yang dibuat lebih kuat agar teks putih selalu terbaca --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <span class="inline-block bg-[#D4A017] text-[#0A1F38] text-[9px] font-black uppercase px-2 py-1 rounded-sm tracking-widest mb-2 shadow-sm">
                            Sorotan Redaksi
                        </span>
                        <h4 class="text-xl md:text-2xl font-heading font-bold text-white leading-tight group-hover:text-[#D4A017] transition-colors line-clamp-3">
                            {{ $article->title }}
                        </h4>
                    </div>
                </a>

            @else
                {{-- Berita Selanjutnya (List Post) --}}
                <a href="{{ url('/berita/' . $article->slug) }}" class="group flex gap-4 p-5 hover:bg-white/5 transition-colors border-l-4 border-transparent hover:border-[#D4A017]">
                    
                    {{-- Thumbnail Kecil --}}
                    <div class="w-20 h-20 shrink-0 rounded-lg overflow-hidden bg-slate-800 relative">
                        @if($article->hasMedia('cover'))
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @endif
                        {{-- Nomor Urut Tipografi --}}
                        <div class="absolute -bottom-2 -right-1 text-4xl font-heading font-black text-white/10 group-hover:text-[#D4A017]/30 transition-colors">
                            {{ $index + 1 }}
                        </div>
                    </div>

                    {{-- Konten Teks --}}
                    <div class="flex flex-col justify-center flex-1">
                        <h4 class="text-sm font-bold font-heading text-slate-200 group-hover:text-white leading-snug line-clamp-2 transition-colors">
                            {{ $article->title }}
                        </h4>
                        <span class="text-[10px] text-[#D4A017] uppercase tracking-wider mt-1.5 font-medium">
                            {{ $article->category->name ?? 'News' }}
                        </span>
                    </div>
                </a>
            @endif

        @endforeach
    </div>
</div>