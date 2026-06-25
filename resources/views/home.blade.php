<x-layouts.app title="Beranda">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
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
            <div class="prose max-w-none">
                {!! $page->content !!}
            </div>
        @endif

    </div>
</x-layouts.app>