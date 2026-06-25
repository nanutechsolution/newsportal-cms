<div class="bg-[#0F2D52] p-6 rounded-2xl shadow-2xl mb-8 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#D4A017] to-yellow-400"></div>

    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-black text-white uppercase tracking-widest">Pilihan Editor</h3>
        <svg class="w-5 h-5 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
    </div>

    <div class="flex flex-col divide-y divide-white/10">
        @foreach($articles as $article)
            <div class="group flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                
                <div class="relative flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-white/5 border border-white/20 group-hover:border-[#D4A017] transition-all duration-300 overflow-hidden flex items-center justify-center text-white/30">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 bg-[#D4A017] text-[#0F2D52] w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-black shadow-md transform group-hover:scale-110 transition-transform duration-300">
                        {{ $loop->iteration }}
                    </div>
                </div>

                <div class="flex-1">
                    <a href="{{ url('/berita/' . $article->slug) }}" class="text-sm font-bold text-white group-hover:text-[#D4A017] leading-snug line-clamp-2 transition-colors duration-300">
                        {{ $article->title }}
                    </a>
                    <span class="text-[10px] text-blue-200 uppercase font-semibold tracking-wider mt-1.5 block">
                        Oleh {{ $article->author->name ?? 'Redaksi' }}
                    </span>
                </div>
                
            </div>
        @endforeach
    </div>
</div>