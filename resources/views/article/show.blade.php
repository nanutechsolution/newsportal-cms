<x-layouts.app :title="$article->title" :description="$article->excerpt">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        {{-- Breadcrumbs --}}
        <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-red-600 transition-colors">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-red-600 font-medium">{{ $article->category->name ?? 'Uncategorized' }}</span>
            <span class="mx-2">/</span>
            <span class="text-gray-900 truncate max-w-xs sm:max-w-md">{{ $article->title }}</span>
        </nav>

        {{-- Header Artikel --}}
        <header class="mb-8">
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                {{ $article->title }}
            </h1>
            
            <div class="flex flex-wrap items-center text-gray-600 text-sm mb-6 gap-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="font-medium text-gray-900">{{ $article->author->name ?? 'Redaksi' }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ $article->published_at ? $article->published_at->format('d M Y, H:i') : $article->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-red-200">
                        {{ $article->category->name ?? 'News' }}
                    </span>
                </div>
            </div>

            {{-- Gambar Cover Artikel --}}
            @if($article->hasMedia('cover'))
                <div class="rounded-xl overflow-hidden shadow-md mb-8">
                    <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-auto object-cover max-h-[500px]">
                </div>
            @endif
        </header>

        {{-- Isi Konten Utama (Menggunakan plugin Prose dari Tailwind) --}}
        <article class="prose prose-lg md:prose-xl prose-red max-w-none mb-12">
            {!! $article->content !!}
        </article>

        {{-- Bagian Tag --}}
        @if($article->tags->isNotEmpty())
            <div class="border-t border-gray-200 pt-6 mt-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Tag Terkait
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <a href="#" class="bg-gray-100 text-gray-700 border border-gray-200 px-3 py-1 rounded-full text-sm hover:bg-red-600 hover:text-white hover:border-red-600 transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-layouts.app>