<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- MENGAMBIL DATA DARI DATABASE -->
    @inject('generalSettings', 'App\Settings\GeneralSettings')
    @inject('seoSettings', 'App\Settings\SeoSettings')
    @inject('monetizationSettings', 'App\Settings\MonetizationSettings')

    @props(['customTitle' => null, 'customDescription' => null, 'customOgImage' => null])

    <title>{{ $customTitle ?: ($seoSettings->meta_title ?: $generalSettings->site_name) }}</title>
    <meta name="description" content="{{ $customDescription ?: ($seoSettings->meta_description ?: $generalSettings->site_description) }}">
    
    @if($generalSettings->favicon_url)
        <link rel="icon" href="{{ asset('storage/' . $generalSettings->favicon_url) }}" type="image/x-icon">
    @endif

    <!-- 1. FONDASI TIPOGRAFI ENTERPRISE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Plus Jakarta Sans untuk Heading/Judul, Inter untuk Body/Paragraf -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:ital,wght@0,600;0,700;0,800;1,600;1,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Kustom Tipografi -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F5F7FA] text-slate-800 antialiased flex flex-col min-h-screen">
    
    <!-- Iklan Top (Opsional) -->
    @if($monetizationSettings->header_ad_code)
        <div class="w-full bg-white py-3 flex justify-center border-b border-gray-200">
            {!! $monetizationSettings->header_ad_code !!}
        </div>
    @endif

    <!-- HEADER PORTAL BERITA -->
    <x-header />

    <!-- KONTEN UTAMA DENGAN WHITE CANVAS ELEGANT -->
    <main class="flex-grow w-full max-w-7xl mx-auto bg-white border-x border-gray-200 shadow-sm min-h-screen">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <x-footer />

</body>
</html>