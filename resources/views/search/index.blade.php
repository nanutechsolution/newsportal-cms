<x-layouts.app title="Pencarian Berita">
    <div class="max-w-4xl mx-auto px-4 py-20">
        <form action="{{ route('search') }}" method="GET" class="mb-12">
            <h1 class="text-3xl md:text-5xl font-black text-[#0F2D52] mb-8 text-center tracking-tight">Apa yang ingin Anda ketahui?</h1>
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" 
                       class="w-full text-2xl md:text-4xl border-0 border-b-2 border-gray-200 focus:border-[#D4A017] focus:ring-0 py-4 outline-none transition-all placeholder:text-gray-300"
                       placeholder="Ketik topik, isu, atau berita...">
            </div>
            <div class="mt-6 flex gap-2 justify-center flex-wrap">
                @foreach(['IKN', 'Ekonomi', 'Olahraga', 'Teknologi'] as $tag)
                    <a href="{{ route('search', ['q' => $tag]) }}" class="px-4 py-1.5 bg-gray-100 hover:bg-[#0F2D52] hover:text-white rounded-full text-sm font-bold text-gray-600 transition-colors">#{{ $tag }}</a>
                @endforeach
            </div>
        </form>

        @if(request()->has('q'))
            <div class="grid gap-6">
                @forelse($articles as $article)
                    <div class="flex gap-6 border-b border-gray-100 pb-6 group">
                        <div class="w-32 h-24 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if($article->hasMedia('cover'))
                                <img src="{{ $article->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <span class="text-xs font-bold text-[#D4A017] uppercase">{{ $article->category->name }}</span>
                            <h2 class="text-xl font-bold text-gray-900 group-hover:text-[#0F2D52] mt-1">{{ $article->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $article->published_at->format('d M Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Berita tidak ditemukan.</p>
                @endforelse
            </div>
        @endif
    </div>
</x-layouts.app>