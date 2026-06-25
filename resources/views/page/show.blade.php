<x-layouts.app :title="$page->title">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 md:p-12">
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-8 pb-4 border-b-4 border-red-600 inline-block">
                {{ $page->title }}
            </h1>
            
            {{-- Menggunakan Tailwind Typography (prose) agar teks yang diketik di editor rapi --}}
            <div class="prose prose-lg md:prose-xl prose-red max-w-none text-gray-700">
                {!! $page->content !!}
            </div>
            
        </div>

    </div>
</x-layouts.app>