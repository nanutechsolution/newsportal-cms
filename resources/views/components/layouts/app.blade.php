<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- MENGAMBIL DATA DARI DATABASE (ZERO HARDCODE) -->
    @inject('generalSettings', 'App\Settings\GeneralSettings')
    @inject('seoSettings', 'App\Settings\SeoSettings')
    @inject('monetizationSettings', 'App\Settings\MonetizationSettings')

    @props(['customTitle' => null, 'customDescription' => null, 'customOgImage' => null])

    <title>{{ $customTitle ?: ($seoSettings->meta_title ?: $generalSettings->site_name) }}</title>
    <meta name="description" content="{{ $customDescription ?: ($seoSettings->meta_description ?: $generalSettings->site_description) }}">
    <meta name="keywords" content="{{ $seoSettings->meta_keywords }}">

    @if($customOgImage)
        <meta property="og:image" content="{{ $customOgImage }}">
    @endif

    @if($generalSettings->favicon_url)
        <link rel="icon" href="{{ asset('storage/' . $generalSettings->favicon_url) }}" type="image/x-icon">
    @endif

    @if($monetizationSettings->is_adsense_active && $monetizationSettings->adsense_client_id)
        <!-- Kode Google AdSense Otomatis -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $monetizationSettings->adsense_client_id }}" crossorigin="anonymous"></script>
    @endif

    <!-- Memanggil Tailwind CSS bawaan Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased flex flex-col min-h-screen">
    
    <!-- Iklan Header Custom (Jika diisi oleh Admin) -->
    @if($monetizationSettings->header_ad_code)
        <div class="w-full bg-gray-100 py-4 flex justify-center border-b border-gray-200">
            {!! $monetizationSettings->header_ad_code !!}
        </div>
    @endif

    <x-header />

    <!-- Konten spesifik halaman akan masuk ke slot ini -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <x-footer />

</body>
</html>