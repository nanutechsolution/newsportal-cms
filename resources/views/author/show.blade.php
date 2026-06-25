<x-layouts.app :title="$user->name">
    <div class="max-w-7xl mx-auto px-4 py-12 flex flex-col lg:flex-row gap-12">
        
        <!-- Sidebar Profil (Sticky) -->
        <aside class="lg:w-1/3">
            <div class="sticky top-24 bg-[#0F2D52] text-white p-8 rounded-2xl shadow-xl">
                <div class="w-32 h-32 bg-white rounded-full mb-6 border-4 border-[#D4A017] mx-auto overflow-hidden">
                    <!-- Placeholder avatar -->
                    <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500 text-4xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                <h1 class="text-2xl font-black text-center mb-2">{{ $user->name }}</h1>
                <p class="text-[#D4A017] text-center font-bold uppercase tracking-widest text-xs mb-6">Senior Journalist</p>
                <p class="text-gray-300 text-sm leading-relaxed text-center mb-8">
                    Jurnalis berpengalaman dengan spesialisasi peliputan isu pembangunan nasional dan ekonomi regional.
                </p>
                <div class="flex justify-center gap-4">
                    <button class="bg-[#D4A017] px-6 py-2 rounded-full font-bold text-sm text-[#0F2D52]">Ikuti</button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="lg:w-2/3">
            <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight mb-8">Tulisan Terbaru dari {{ $user->name }}</h2>
            <div class="space-y-8">
                @foreach($articles as $article)
                    <article class="flex flex-col md:flex-row gap-6 border-b border-gray-100 pb-8">
                        @if($article->hasMedia('cover'))
                            <img src="{{ $article->getFirstMediaUrl('cover') }}" class="w-full md:w-56 h-36 object-cover rounded-xl">
                        @endif
                        <div>
                            <span class="text-xs font-bold text-[#D4A017] uppercase">{{ $article->category->name }}</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-1 hover:text-[#0F2D52]">
                                <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="text-gray-500 mt-2 text-sm">{{ $article->excerpt }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </main>
    </div>
</x-layouts.app>