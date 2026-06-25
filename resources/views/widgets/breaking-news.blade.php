@if($articles->count() > 0)
<div class="mb-10 flex items-stretch bg-red-600 text-white rounded-lg shadow-sm overflow-hidden">
    
    <!-- Kotak Judul Merah Gelap -->
    <div class="px-4 py-3 font-black whitespace-nowrap bg-red-800 tracking-wider z-10 flex items-center shadow-lg">
        <x-heroicon-s-bolt class="w-5 h-5 inline-block mr-1 text-yellow-400 animate-pulse" />
        {{ $title }}
    </div>

    <!-- Area Teks Berjalan -->
    <div class="flex-1 overflow-hidden relative flex items-center">
        <!-- Menggunakan pl-[100%] agar teks tepat mulai dari tepi kanan wadah -->
        <div class="flex space-x-10 animate-marquee whitespace-nowrap py-3 pl-[100%] w-max">
            @foreach($articles as $article)
                <!-- shrink-0 ditambahkan agar teks panjang tidak menyusut/terlipat -->
                <a href="{{ url('/berita/' . $article->slug) }}" class="hover:underline font-medium inline-flex items-center group shrink-0">
                    <span class="opacity-75 mr-2 text-sm">[{{ $article->category->name ?? 'News' }}]</span>
                    <span class="group-hover:text-yellow-200 transition-colors">{{ $article->title }}</span>
                </a>
            @endforeach
        </div>
    </div>

</div>

<!-- CSS Kustom untuk Efek Marquee Berjalan Halus -->
<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100%); }
    }
    .animate-marquee {
        /* display: inline-block telah Dihapus agar class 'flex' Tailwind berfungsi */
        animation: marquee 35s linear infinite;
        will-change: transform;
    }
    /* Berhenti berjalan saat mouse diarahkan ke berita (hover) */
    .animate-marquee:hover {
        animation-play-state: paused;
    }
</style>
@endif