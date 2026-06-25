<div class="py-10 border-y border-gray-200 mb-10">
    <h2 class="text-2xl font-black text-gray-900 mb-8 text-center uppercase">Kolom Opini</h2>
    <div class="grid md:grid-cols-2 gap-10">
        @foreach($articles as $article)
            <div class="border-l-4 border-[#D4A017] pl-6">
                <p class="text-xs font-bold text-[#D4A017] uppercase mb-2">Analisis Tajam</p>
                <h3 class="text-xl font-bold text-gray-900 leading-tight mb-3">
                    <a href="{{ url('/berita/' . $article->slug) }}" class="hover:underline">{{ $article->title }}</a>
                </h3>
                <p class="text-sm text-gray-600 italic">"{{ $article->excerpt }}"</p>
            </div>
        @endforeach
    </div>
</div>