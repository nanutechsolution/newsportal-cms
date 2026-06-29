<div class="mb-14">
    <div class="flex items-end justify-between mb-8 border-b-2 border-gray-200 pb-3">
        <h2 class="text-3xl font-heading font-extrabold text-[#0F2D52] uppercase tracking-tight">
            <span class="text-[#D4A017] mr-2">|</span>{{ $title }}
        </h2>
        <a href="#" class="text-xs font-heading font-bold text-[#D4A017] hover:text-[#0F2D52] uppercase tracking-widest transition-colors">Lihat Semua &rarr;</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        @foreach($articles as $index => $article)
            
            @if($index === 0)
                <div class="md:col-span-8 group cursor-pointer">
                    <a href="{{ url('/berita/' . $article->slug) }}" class="block relative w-full h-[360px] md:h-[480px] rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                        @if($article->hasMedia('cover'))
                            <!-- Efek scale-105 memberikan zoom perlahan yang elegan -->
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-out">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-300 font-heading text-4xl font-black tracking-tighter opacity-50">NUSA<span class="text-[#D4A017]">AKSARA</span></span>
                            </div>
                        @endif
                        
                        <!-- Gradient Overlay diperkecil hanya menutupi 75% dari bawah agar bagian atas gambar bersih -->
                        <div class="absolute inset-x-0 bottom-0 h-[75%] bg-gradient-to-t from-[#0A1F38] via-[#0A1F38]/80 to-transparent opacity-95 group-hover:opacity-100 transition duration-300"></div>
                        
                        <!-- Text Content: Dibatasi lebarnya agar tidak memenuhi seluruh layar dan menutupi gambar -->
                        <div class="absolute bottom-0 left-0 p-6 md:p-10 w-full md:w-5/6 lg:w-4/5">
                            <span class="inline-block bg-[#D4A017] text-[#0F2D52] text-[11px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-sm mb-4 shadow-sm font-heading">
                                {{ $article->category->name ?? 'Laporan Utama' }}
                            </span>
                            
                            <!-- Tambahan line-clamp-3 agar judul yang sangat panjang tidak memakan terlalu banyak baris vertikal -->
                            <h3 class="text-2xl md:text-4xl font-heading font-extrabold text-white leading-[1.25] mb-4 group-hover:text-[#D4A017] transition-colors drop-shadow-md line-clamp-3">
                                {{ $article->title }}
                            </h3>
                            
                            <div class="text-gray-300 text-sm font-medium flex items-center gap-3 font-sans">
                                <span>{{ $article->author->name ?? 'Redaksi' }}</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D4A017]"></span>
                                <span>{{ $article->published_at ? $article->published_at->diffForHumans() : 'Baru saja' }}</span>
                            </div>
                        </div>
                    </a>
                </div>

            @elseif($index > 0 && $index <= 4)
                @if($index === 1)
                    <!-- Wadah kolom kanan untuk 4 berita -->
                    <div class="md:col-span-4 flex flex-col justify-between gap-6">
                @endif
                
                <a href="{{ url('/berita/' . $article->slug) }}" class="flex gap-4 group items-start">
                    <div class="w-28 h-24 md:w-32 md:h-24 flex-shrink-0 rounded-md overflow-hidden relative border border-gray-100 shadow-sm">
                        @if($article->hasMedia('cover'))
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                        @else
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                <x-heroicon-o-photo class="w-6 h-6 text-gray-300" />
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-start">
                        <span class="text-[10px] font-extrabold text-[#D4A017] uppercase tracking-wider mb-1 font-heading">{{ $article->category->name ?? 'News' }}</span>
                        <!-- Menggunakan line-clamp-3 agar teks rapi tidak terlalu panjang -->
                        <h4 class="text-[15px] font-heading font-bold text-[#0F2D52] leading-snug group-hover:text-[#D4A017] transition-colors line-clamp-3">
                            {{ $article->title }}
                        </h4>
                        <span class="text-[11px] text-gray-400 mt-2 font-sans">{{ $article->published_at ? $article->published_at->diffForHumans() : '' }}</span>
                    </div>
                </a>

                @if($index === 4 || $loop->last)
                    </div> <!-- Tutup kolom kanan -->
                @endif
                
            @endif

        @endforeach
    </div>
</div>