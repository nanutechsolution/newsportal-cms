<div class="mb-10 md:mb-14">
    <div class="flex items-end justify-between mb-6 border-b-2 border-gray-200 pb-3">
        <h2 class="text-2xl md:text-3xl font-heading font-extrabold text-[#0F2D52] uppercase tracking-tight">
            <span class="text-[#D4A017] mr-2">|</span>
        </h2>
        <a href="#" class="text-[10px] md:text-xs font-heading font-bold text-[#D4A017] hover:text-[#0F2D52] uppercase tracking-widest transition-colors">
            Lihat Semua &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        @foreach($articles as $index => $article)
            
            @if($index === 0)
                <div class="md:col-span-8 group cursor-pointer">
                    <a href="{{ url('/berita/' . $article->slug) }}" class="block relative w-full h-[280px] md:h-[480px] rounded-lg md:rounded-xl overflow-hidden shadow-sm">
                        @if($article->hasMedia('cover'))
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-out">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-300 font-heading text-2xl md:text-4xl font-black tracking-tighter opacity-50">NUSA<span class="text-[#D4A017]">AKSARA</span></span>
                            </div>
                        @endif
                        
                        <div class="absolute inset-x-0 bottom-0 h-[65%] bg-gradient-to-t from-[#0A1F38] via-[#0A1F38]/80 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 p-5 md:p-10 w-full">
                            <span class="inline-block bg-[#D4A017] text-[#0F2D52] text-[10px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-sm mb-2 md:mb-4 font-heading">
                                {{ $article->category->name ?? 'Laporan Utama' }}
                            </span>
                            
                            <h3 class="text-xl md:text-4xl font-heading font-extrabold text-white leading-tight mb-2 md:mb-4 group-hover:text-[#D4A017] transition-colors line-clamp-3">
                                {{ $article->title }}
                            </h3>
                            
                            <div class="text-gray-300 text-[11px] md:text-sm font-medium flex items-center gap-2 md:gap-3 font-sans">
                                <span>{{ $article->author->name ?? 'Redaksi' }}</span>
                                <span class="w-1 h-1 rounded-full bg-[#D4A017]"></span>
                                <span>{{ $article->published_at ? $article->published_at->diffForHumans() : 'Baru saja' }}</span>
                            </div>
                        </div>
                    </a>
                </div>

            @elseif($index > 0 && $index <= 4)
                @if($index === 1)
                    <div class="md:col-span-4 flex flex-col gap-4">
                @endif
                
                <a href="{{ url('/berita/' . $article->slug) }}" class="flex gap-4 group items-center md:items-start">
                    <div class="w-24 h-20 md:w-32 md:h-24 flex-shrink-0 rounded-md overflow-hidden border border-gray-100">
                        @if($article->hasMedia('cover'))
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                <span class="text-[8px] text-gray-300">No Image</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-center md:justify-start">
                        <span class="text-[9px] md:text-[10px] font-extrabold text-[#D4A017] uppercase tracking-wider mb-0.5 md:mb-1 font-heading">{{ $article->category->name ?? 'News' }}</span>
                        <h4 class="text-sm md:text-[15px] font-heading font-bold text-[#0F2D52] leading-snug group-hover:text-[#D4A017] transition-colors line-clamp-2 md:line-clamp-3">
                            {{ $article->title }}
                        </h4>
                    </div>
                </a>

                @if($index === 4 || $loop->last)
                    </div>
                @endif
            @endif
        @endforeach
    </div>
</div>