<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Warna Tema untuk Browser Mobile (Chrome/Safari) -->
    <meta name="theme-color" content="#0F2D52">

    <!-- MENGAMBIL DATA DARI DATABASE -->
    @inject('generalSettings', 'App\Settings\GeneralSettings')
    @inject('seoSettings', 'App\Settings\SeoSettings')
    @inject('monetizationSettings', 'App\Settings\MonetizationSettings')

    @props(['customTitle' => null, 'customDescription' => null, 'customOgImage' => null])

    <title>{{ $customTitle ?: ($seoSettings->meta_title ?: $generalSettings->site_name) }}</title>
    <meta name="description" content="{{ $customDescription ?: ($seoSettings->meta_description ?: $generalSettings->site_description) }}">

    <!-- Open Graph / Meta Social Media (Penting untuk Share WhatsApp/FB/X) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $customTitle ?: ($seoSettings->meta_title ?: $generalSettings->site_name) }}">
    <meta property="og:description" content="{{ $customDescription ?: ($seoSettings->meta_description ?: $generalSettings->site_description) }}">
    @if($customOgImage || $generalSettings->logo_url)
    <meta property="og:image" content="{{ $customOgImage ?: asset('storage/' . $generalSettings->logo_url) }}">
    @endif

    @if($generalSettings->favicon_url)
    <link rel="icon" href="{{ asset('storage/' . $generalSettings->favicon_url) }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $generalSettings->favicon_url) }}">
    @endif

    <!-- FONDASI TIPOGRAFI ENTERPRISE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,500;0,600;0,700;0,800;1,600;1,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Kustom Global -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Modifikasi Warna Blok Teks (Selection) */
        ::selection {
            background-color: #D4A017;
            color: #0F2D52;
        }

        /* Scrollbar Elegan Global */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <!-- Slot untuk injeksi CSS spesifik -->
    @stack('styles')
</head>

<body class="bg-[#F5F7FA] text-slate-800 antialiased flex flex-col min-h-screen selection:bg-[#D4A017] selection:text-[#0F2D52]">

    <!-- Iklan Top -->
    @if($monetizationSettings->header_ad_code)
    <div class="w-full bg-slate-50 py-3 flex justify-center border-b border-gray-200">
        <span class="text-[10px] text-slate-400 absolute mt-[-10px] bg-white px-2 rounded-b border border-t-0 border-gray-200">ADVERTISEMENT</span>
        <div class="mt-2">
            {!! $monetizationSettings->header_ad_code !!}
        </div>
    </div>
    @endif

    <!-- HEADER PORTAL BERITA (Smart Sticky Wrapper) -->
    <div id="smart-header-wrapper" class="sticky top-0 z-[60] w-full transition-transform duration-300 ease-out shadow-sm bg-white/95 backdrop-blur-md">
        <x-header />
    </div>

    <!-- KONTEN UTAMA DENGAN WHITE CANVAS ELEGANT -->
    <main class="flex-grow w-full max-w-7xl mx-auto bg-white border-x border-gray-200 shadow-sm min-h-screen relative overflow-hidden">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <x-footer />

    <!-- Slot untuk injeksi Script -->
    @stack('scripts')

    <!-- Logika Smart Sticky Header Global (Dioptimasi dengan RequestAnimationFrame) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headerWrapper = document.getElementById('smart-header-wrapper');
            let lastScrollY = window.scrollY;
            let ticking = false;
            const scrollThreshold = 200; // Header baru hilang jika scroll melebihi 200px

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        const currentScrollY = window.scrollY;

                        if (currentScrollY > lastScrollY && currentScrollY > scrollThreshold) {
                            // Scroll Down - Sembunyikan
                            headerWrapper.style.transform = 'translateY(-100%)';
                        } else if (currentScrollY < lastScrollY) {
                            // Scroll Up - Tampilkan
                            headerWrapper.style.transform = 'translateY(0)';
                            // Tambahkan shadow ekstra saat sticky muncul
                            if (currentScrollY > 10) {
                                headerWrapper.classList.add('shadow-md');
                            } else {
                                headerWrapper.classList.remove('shadow-md');
                            }
                        }

                        lastScrollY = currentScrollY;
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });
        });

        // Script untuk Mobile Menu Toggle agar transisinya halus
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('max-h-0')) {
                menu.classList.remove('max-h-0', 'opacity-0');
                menu.classList.add('max-h-[75vh]', 'opacity-100');
            } else {
                menu.classList.remove('max-h-[75vh]', 'opacity-100');
                menu.classList.add('max-h-0', 'opacity-0');
            }
        }
    </script>
</body>

</html>