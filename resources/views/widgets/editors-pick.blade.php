<div class="bg-[#0A1F38] rounded-2xl shadow-2xl mb-8 relative overflow-hidden border border-[#D4A017]/20">
    {{-- Aksen Garis Emas Halus di Atas --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#D4A017] via-yellow-400 to-[#D4A017]"></div>

    <div class="flex items-center justify-between p-6 border-b border-white/10">
        <h3 class="text-base font-heading font-black text-white uppercase tracking-[0.2em] flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#D4A017] animate-pulse"></span>
            Pilihan Editor
        </h3>
        <svg class="w-5 h-5 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
    </div>

    <div class="flex flex-col">
        @foreach($articles as $index => $article)
            
            @if($index === 0)
                {{-- Berita Ke-1: Tampilan Utama (Hero Highlight) --}}
                <a href="{{ url('/berita/' . $article->slug) }}" class="group relative block h-56 w-full overflow-hidden border-b border-white/10">
                    @if($article->hasMedia('cover'))
                        <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out opacity-80 group-hover:opacity-100">
                    @else
                        <div class="w-full h-full bg-slate-800 flex items-center justify-center">
                            <span class="font-heading text-2xl font-black text-white/20">NUSA<span class="text-[#D4A017]/30">AKSARA</span></span>
                        </div>
                    @endif
                    
                    {{-- Gradient Overlay yang pekat di bawah agar teks terbaca --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A1F38] via-[#0A1F38]/60 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <span class="inline-block bg-[#D4A017] text-[#0A1F38] text-[9px] font-black uppercase px-2 py-1 rounded-sm tracking-widest mb-2 shadow-sm">
                            Sorotan Redaksi
                        </span>
                        <h4 class="text-xl font-heading font-bold text-white leading-snug group-hover:text-[#D4A017] transition-colors line-clamp-2">
                            {{ $article->title }}
                        </h4>
                        <div class="flex items-center gap-2 mt-2 text-[10px] text-slate-300 font-sans uppercase tracking-wider">
                            <span>{{ $article->author->name ?? 'Redaksi' }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-500"></span>
                            <span>{{ $article->published_at ? $article->published_at->diffForHumans() : '' }}</span>
                        </div>
                    </div>
                </a>

            @else
                {{-- Berita Ke-2, 3, 4: Tampilan List Modern dengan Thumbnail --}}
                <a href="{{ url('/berita/' . $article->slug) }}" class="group flex gap-4 p-5 hover:bg-white/5 transition-colors border-l-4 border-transparent hover:border-[#D4A017]">
                    
                    {{-- Thumbnail Kecil --}}
                    <div class="w-20 h-20 shrink-0 rounded-lg overflow-hidden bg-slate-800 relative">
                        @if($article->hasMedia('cover'))
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-700"></div>
                        @endif
                        
                        {{-- Nomor Tipografi Transparan di atas gambar (Opsional, memberi kesan editorial) --}}
                        <div class="absolute -bottom-2 -right-1 text-4xl font-heading font-black text-white/20 group-hover:text-[#D4A017]/40 transition-colors pointer-events-none">
                            {{ $index + 1 }}
                        </div>
                    </div>

                    {{-- Konten Teks List --}}
                    <div class="flex flex-col justify-center flex-1">
                        <h4 class="text-sm font-bold font-heading text-slate-200 group-hover:text-white leading-snug line-clamp-2 transition-colors">
                            {{ $article->title }}
                        </h4>
                        <span class="text-[11px] text-[#D4A017] uppercase tracking-wider mt-2 font-medium">
                            {{ $article->category->name ?? 'News' }}
                        </span>
                    </div>

                </a>
            @endif

        @endforeach
    </div>
</div>