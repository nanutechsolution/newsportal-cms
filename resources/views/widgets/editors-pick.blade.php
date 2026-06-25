<div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-8">
    <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest mb-6">Pilihan Editor</h3>
    <div class="space-y-6">
        @foreach($articles as $article)
            <div class="flex gap-4">
                <div class="w-12 h-12 rounded-full bg-gray-300 flex-shrink-0"></div> <!-- Avatar Penulis -->
                <div>
                    <a href="{{ url('/berita/' . $article->slug) }}" class="text-sm font-bold text-gray-900 hover:text-red-700 leading-snug line-clamp-2">
                        {{ $article->title }}
                    </a>
                    <span class="text-[10px] text-gray-500 uppercase font-bold mt-1 block">{{ $article->author->name ?? 'Redaksi' }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>