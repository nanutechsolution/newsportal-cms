@if($articles->count() > 0)
<div class="mb-10 flex items-stretch bg-white border border-gray-200 rounded-sm shadow-sm overflow-hidden">
    
    <!-- Kotak Judul Navy Blue -->
    <div class="px-5 py-3 font-heading font-extrabold uppercase tracking-widest text-white bg-[#0F2D52] z-10 flex items-center shadow-md text-[13px]">
        <x-heroicon-s-bolt class="w-4 h-4 mr-1.5 text-[#D4A017] animate-pulse" />
        {{ $title }}
    </div>

    <!-- Area Teks Berjalan -->
    <div class="flex-1 overflow-hidden relative flex items-center bg-[#F5F7FA]">
        <div class="flex space-x-12 animate-marquee whitespace-nowrap py-3 pl-[100%] w-max">
            @foreach($articles as $article)
                <a href="{{ url('/berita/' . $article->slug) }}" class="hover:underline font-medium inline-flex items-center group shrink-0 text-slate-700">
                    <span class="text-[#D4A017] font-bold text-xs uppercase tracking-wider mr-2 font-heading">{{ $article->category->name ?? 'Update' }}</span>
                    <span class="group-hover:text-[#0F2D52] transition-colors font-sans">{{ $article->title }}</span>
                </a>
            @endforeach
        </div>
    </div>

</div>

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100%); }
    }
    .animate-marquee {
        animation: marquee 35s linear infinite;
        will-change: transform;
    }
    .animate-marquee:hover {
        animation-play-state: paused;
    }
</style>
@endif