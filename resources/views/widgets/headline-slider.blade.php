@if($articles->count() > 0)
<div class="mb-14 relative w-full rounded-2xl overflow-hidden shadow-2xl group" id="headline-slider-{{ $widgetId }}">
    
    <!-- Track Slider -->
    <div class="flex h-[400px] md:h-[500px] lg:h-[600px] transition-transform duration-700 ease-in-out" id="slider-track-{{ $widgetId }}">
        @foreach($articles as $index => $article)
            <div class="w-full shrink-0 relative flex-none">
                <!-- Cover Image -->
                @if($article->hasMedia('cover'))
                    <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-[#0F2D52] flex items-center justify-center">
                        <span class="text-white/20 font-heading text-6xl font-black tracking-tighter">NUSA<span class="text-[#D4A017]/50">AKSARA</span></span>
                    </div>
                @endif
                
                <!-- Gradient Overlay Ekstra Gelap di Bawah -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A1F38] via-[#0A1F38]/60 to-transparent"></div>
                
                <!-- Konten Teks -->
                <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 lg:p-16 flex flex-col items-start">
                    <span class="bg-[#D4A017] text-[#0F2D52] text-xs font-black uppercase tracking-widest px-3 py-1 rounded shadow-sm mb-4 font-heading">
                        {{ $article->category->name ?? 'Sorotan Utama' }}
                    </span>
                    
                    <a href="{{ route('article.show', $article->slug) }}" class="block group/link">
                        <h2 class="text-3xl md:text-5xl lg:text-6xl font-heading font-black text-white leading-[1.1] mb-4 group-hover/link:text-[#D4A017] transition-colors drop-shadow-lg max-w-4xl">
                            {{ $article->title }}
                        </h2>
                    </a>
                    
                    <div class="flex items-center gap-4 text-slate-300 text-sm font-medium font-sans">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-white text-[10px] font-bold">
                                {{ substr($article->author->name ?? 'R', 0, 1) }}
                            </div>
                            <span>{{ $article->author->name ?? 'Redaksi' }}</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-[#D4A017]"></span>
                        <span>{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : '' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tombol Navigasi Kiri/Kanan (Muncul saat Hover) -->
    <button id="prev-btn-{{ $widgetId }}" class="absolute top-1/2 -translate-y-1/2 left-4 w-12 h-12 rounded-full bg-black/30 backdrop-blur-md text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-[#D4A017] hover:text-[#0F2D52] z-10 border border-white/20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    <button id="next-btn-{{ $widgetId }}" class="absolute top-1/2 -translate-y-1/2 right-4 w-12 h-12 rounded-full bg-black/30 backdrop-blur-md text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-[#D4A017] hover:text-[#0F2D52] z-10 border border-white/20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    </button>

    <!-- Indikator Dots -->
    <div class="absolute bottom-6 right-6 md:right-12 flex gap-2 z-10" id="indicators-{{ $widgetId }}">
        @foreach($articles as $index => $article)
            <button class="w-2 h-2 md:w-8 md:h-1.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-[#D4A017]' : 'bg-white/40 hover:bg-white/70' }}" data-slide="{{ $index }}"></button>
        @endforeach
    </div>

</div>

<!-- Vanilla JS Engine untuk Slider yang Sangat Ringan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('slider-track-{{ $widgetId }}');
        const prevBtn = document.getElementById('prev-btn-{{ $widgetId }}');
        const nextBtn = document.getElementById('next-btn-{{ $widgetId }}');
        const indicators = document.getElementById('indicators-{{ $widgetId }}').children;
        
        let currentIndex = 0;
        const totalSlides = {{ $articles->count() }};
        let autoSlideInterval;

        function updateSlider() {
            // Geser track sebesar -100% dikali index saat ini
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            
            // Update indikator warna
            Array.from(indicators).forEach((dot, index) => {
                if(index === currentIndex) {
                    dot.classList.remove('bg-white/40');
                    dot.classList.add('bg-[#D4A017]');
                } else {
                    dot.classList.remove('bg-[#D4A017]');
                    dot.classList.add('bg-white/40');
                }
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlider();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlider();
        }

        // Event Listeners
        nextBtn.addEventListener('click', () => { nextSlide(); resetInterval(); });
        prevBtn.addEventListener('click', () => { prevSlide(); resetInterval(); });
        
        Array.from(indicators).forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                updateSlider();
                resetInterval();
            });
        });

        // Auto Play setiap 5 detik
        function startInterval() {
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        function resetInterval() {
            clearInterval(autoSlideInterval);
            startInterval();
        }

        startInterval();
    });
</script>
@endif