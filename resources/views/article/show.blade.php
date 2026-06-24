@php
    // Menyiapkan data SEO khusus untuk halaman artikel ini
    $metaTitle = $article->seoMetadata->meta_title ?? $article->title . ' - ' . $generalSettings->site_name;
    $metaDesc = $article->seoMetadata->meta_description ?? $article->excerpt ?? Str::limit(strip_tags($article->content), 150);
    $ogImage = $article->seoMetadata->og_image_url ?? ($article->hasMedia('cover') ? $article->getFirstMediaUrl('cover') : null);
@endphp

<x-layouts.app :customTitle="$metaTitle" :customDescription="$metaDesc" :customOgImage="$ogImage">
    
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Header Artikel -->
        <div class="p-6 md:p-10 border-b border-gray-100">
            <!-- Breadcrumb -->
            <nav class="flex text-sm text-gray-500 mb-6 font-medium">
                <a href="{{ route('home') }}" class="hover:text-red-700 transition">Home</a>
                <span class="mx-2">/</span>
                <a href="#" class="hover:text-red-700 transition">{{ $article->category->name }}</a>
            </nav>

            <h1 class="text-3xl md:text-5xl font-black text-gray-900 leading-tight mb-6">
                {{ $article->title }}
            </h1>

            <div class="flex items-center justify-between flex-wrap gap-4 text-sm text-gray-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold text-lg">
                        {{ substr($article->author->name ?? 'Redaksi', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $article->author->name ?? 'Redaksi NusaAksara' }}</p>
                        <p>{{ $article->published_at ? $article->published_at->translatedFormat('l, d F Y - H:i') : '' }} WIB</p>
                    </div>
                </div>
                
                <!-- Share Buttons (Static UI) -->
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition"><x-heroicon-m-share class="w-4 h-4"/></button>
                </div>
            </div>
        </div>

        <!-- Cover Image -->
        @if($article->hasMedia('cover'))
            <div class="w-full h-auto">
                <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-auto object-cover max-h-[500px]">
            </div>
        @endif

        <!-- Konten Artikel -->
        <div class="p-6 md:p-10">
            
            @if($article->excerpt)
                <p class="text-xl text-gray-700 font-medium italic mb-8 border-l-4 border-red-700 pl-4">
                    {{ $article->excerpt }}
                </p>
            @endif

            <!-- Rich Text Content dengan Tailwind Typography -->
            <article class="prose prose-lg md:prose-xl max-w-none prose-a:text-red-700 hover:prose-a:text-red-800 prose-img:rounded-xl">
                {!! $article->content !!}
            </article>

            <!-- Iklan Dalam Artikel (Zero Hardcode) -->
            @inject('monetization', 'App\Settings\MonetizationSettings')
            @if($monetization->article_ad_code)
                <div class="my-10 w-full flex justify-center bg-gray-50 py-4 border border-dashed border-gray-200">
                    {!! $monetization->article_ad_code !!}
                </div>
            @endif

            <!-- Tags -->
            @if($article->tags->count() > 0)
                <div class="mt-10 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Tag Terkait:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->tags as $tag)
                            <a href="#" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-red-100 hover:text-red-700 transition">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-layouts.app>