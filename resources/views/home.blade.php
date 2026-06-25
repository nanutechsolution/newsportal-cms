<x-layouts.app title="Beranda">
    <div class="px-4 md:px-8 lg:px-10 py-10 w-full">
        
        {{-- Logika Builder Engine --}}
        @if($page->layout === 'homepage-builder')
            
            {{-- Melakukan Looping pada semua widget yang diatur di Filament --}}
            @foreach($page->widgets as $widget)
                @php
                    $widgetClass = app($widget->registry->class_name);
                    // Menjalankan fungsi render() dari widget terkait
                    echo $widgetClass->render($widget);
                @endphp
            @endforeach

        @else
            {{-- Fallback jika halaman menggunakan layout standar (bukan builder) --}}
            <div class="prose prose-lg prose-red max-w-none mx-auto">
                {!! $page->content !!}
            </div>
        @endif

    </div>
</x-layouts.app>