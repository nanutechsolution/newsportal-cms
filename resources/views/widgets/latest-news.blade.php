<div class="mb-14">
    <div class="flex items-end justify-between mb-8 border-b-2 border-slate-200 pb-3 relative">
        <h2 class="text-3xl font-black text-[#0F2D52] uppercase tracking-tight">
            {{ $title }}
        </h2>
        <div class="absolute bottom-[-2px] left-0 w-24 h-[2px] bg-[#D4A017]"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <div class="group border-b border-slate-100 pb-6 hover:border-[#D4A017]/40 transition-colors duration-300">
                <a href="{{ url('/berita/' . $article->slug) }}" class="flex flex-col gap-3 h-full">
                    
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#D4A017] group-hover:scale-125 transition-transform duration-300"></span>
                        <span class="text-xs font-bold uppercase text-[#D4A017] tracking-widest">
                            {{ $article->category->name }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-[#0F2D52] leading-snug group-hover:text-[#D4A017] transition-colors duration-300">
                        {{ $article->title }}
                    </h3>
                    
                    <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed mt-auto">
                        {{ $article->excerpt }}
                    </p>
                    
                </a>
            </div>
        @endforeach
    </div>
</div>