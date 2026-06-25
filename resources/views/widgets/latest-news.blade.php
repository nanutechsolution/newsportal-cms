<div class="mb-14">
    <div class="flex items-end justify-between mb-6 border-b-2 border-gray-100 pb-2">
        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">
            {{ $title }}
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <div class="group border-b border-gray-100 pb-6">
                <a href="{{ url('/berita/' . $article->slug) }}" class="flex flex-col gap-3">
                    <span class="text-[10px] font-bold uppercase text-red-600 tracking-wider">
                        {{ $article->category->name }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 leading-snug group-hover:text-red-600 transition">
                        {{ $article->title }}
                    </h3>
                    <p class="text-sm text-gray-500 line-clamp-2">
                        {{ $article->excerpt }}
                    </p>
                </a>
            </div>
        @endforeach
    </div>
</div>