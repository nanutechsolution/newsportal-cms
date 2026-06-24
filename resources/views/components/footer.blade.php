@inject('generalSettings', 'App\Settings\GeneralSettings')
@inject('monetizationSettings', 'App\Settings\MonetizationSettings')

<footer class="bg-slate-900 text-white mt-12 border-t-4 border-red-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if($monetizationSettings->footer_ad_code)
        <div class="w-full flex justify-center mb-10 overflow-hidden">
            {!! $monetizationSettings->footer_ad_code !!}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Kolom 1: Identitas -->
            <div>
                <h3 class="text-2xl font-black mb-4">{{ strtoupper($generalSettings->site_name) }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-6">{{ $generalSettings->site_description }}</p>
                <p class="text-slate-500 text-xs">&copy; {{ date('Y') }} {{ $generalSettings->site_name }}. All rights reserved.</p>
            </div>

            <!-- Kolom 2: Kontak -->
            <div>
                <h4 class="text-lg font-bold mb-4 uppercase tracking-wider text-slate-300">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-center gap-2">
                        <x-heroicon-m-envelope class="w-5 h-5" /> {{ $generalSettings->contact_email }}
                    </li>
                    <li class="flex items-center gap-2">
                        <x-heroicon-m-phone class="w-5 h-5" /> {{ $generalSettings->contact_phone }}
                    </li>
                    <li class="flex items-start gap-2">
                        <x-heroicon-m-map-pin class="w-5 h-5 mt-1" /> {{ $generalSettings->address }}
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Navigasi -->
            <div>
                <h4 class="text-lg font-bold mb-4 uppercase tracking-wider text-slate-300">Tautan Redaksi</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Susunan Redaksi</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Pedoman Media Siber</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Disclaimer</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>