<div class="mb-12">
    <div class="flex items-center justify-between mb-6 border-b-2 border-red-600 pb-2">
        <h2 class="text-2xl font-bold text-gray-900 uppercase">{{ $title }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($articles as $article)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col hover:shadow-lg transition-shadow">
                @if($article->hasMedia('cover'))
                    <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif
                
                <div class="p-4 flex flex-col flex-grow">
                    <span class="text-sm font-semibold text-red-600 mb-2">{{ $article->category->name ?? 'Uncategorized' }}</span>
                    <a href="{{ url('/berita/' . $article->slug) }}" class="text-lg font-bold text-gray-900 hover:text-red-600 mb-3 line-clamp-2">
                        {{ $article->title }}
                    </a>
                    <div class="mt-auto text-xs text-gray-500">
                        {{ $article->published_at ? $article->published_at->format('d M Y') : '' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>