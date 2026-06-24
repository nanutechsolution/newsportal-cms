<x-layouts.app>
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6 border-b-2 border-gray-200 pb-2">
            <h2 class="text-3xl font-black text-gray-900 uppercase">
                <span class="text-red-700">Headline</span> News
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredArticles as $article)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 group">
                <div class="relative h-48 overflow-hidden bg-gray-200">
                    @if($article->hasMedia('cover'))
                    <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-medium">No Image</div>
                    @endif
                    <div class="absolute top-2 left-2 bg-red-700 text-white text-xs font-bold px-3 py-1 rounded shadow-md uppercase tracking-wider">
                        {{ $article->category->name ?? 'Update' }}
                    </div>
                </div>

                <div class="p-5">
                    <div class="flex items-center text-xs text-gray-500 mb-3 gap-2">
                        <span class="font-medium">{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <h3 class="text-lg font-bold leading-tight text-gray-900 group-hover:text-red-700 transition-colors line-clamp-3">
                        <a href="#">{{ $article->title }}</a>
                    </h3>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                <x-heroicon-o-document-text class="w-12 h-12 mx-auto mb-3 text-gray-400" />
                Belum ada berita headline yang diterbitkan.
            </div>
            @endforelse
        </div>
    </section>
</x-layouts.app>