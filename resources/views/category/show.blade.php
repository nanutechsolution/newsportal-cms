<x-layouts.app :title="'Berita ' . $category->name" :description="$category->description ?? 'Kumpulan berita terbaru kategori ' . $category->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-10 border-b-4 pb-4" style="border-color: {{ $category->color_hex ?? '#ef4444' }}">
            <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tight">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="mt-2 text-gray-600 text-lg">{{ $category->description }}</p>
            @endif
        </div>

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                        <!-- Cover Image -->
                        <a href="{{ route('article.show', $article->slug) }}" class="block overflow-hidden relative">
                            @if($article->hasMedia('cover'))
                                <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-56 object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 font-medium">Tanpa Gambar</span>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Konten Berita -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h2 class="text-xl font-bold text-gray-900 hover:text-red-600 mb-3 leading-snug line-clamp-3">
                                <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $article->excerpt }}
                            </p>
                            
                            <!-- Meta Info -->
                            <div class="mt-auto flex items-center justify-between text-xs text-gray-500 font-medium">
                                <div class="flex items-center gap-2">
                                    <x-heroicon-m-user-circle class="w-4 h-4" />
                                    <span>{{ $article->author->name ?? 'Redaksi' }}</span>
                                </div>
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : '' }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <x-heroicon-o-document-magnifying-glass class="w-16 h-16 mx-auto text-gray-400 mb-4" />
                <h3 class="text-xl font-bold text-gray-900">Belum Ada Berita</h3>
                <p class="text-gray-500 mt-2">Belum ada artikel yang dipublikasikan pada kategori ini.</p>
            </div>
        @endif

    </div>
</x-layouts.app>