@inject('generalSettings', 'App\Settings\GeneralSettings')
@inject('monetizationSettings', 'App\Settings\MonetizationSettings')

<footer class="bg-[#0F2D52] text-white pt-16 pb-8 border-t-8 border-[#D4A017]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Slot Iklan Footer (Opsional) --}}
        @if($monetizationSettings->footer_ad_code)
            <div class="w-full flex justify-center mb-16 overflow-hidden border border-white/10 p-4 rounded-lg bg-white/5">
                {!! $monetizationSettings->footer_ad_code !!}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            {{-- Kolom 1: Brand & Logo --}}
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <span class="font-heading text-2xl font-extrabold tracking-tight">NUSA<span class="text-[#D4A017]">AKSARA</span></span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-6 font-sans">
                    {{ $generalSettings->site_description }}
                </p>
                
                {{-- Sosial Media Dinamis --}}
                <div class="flex gap-4">
                    @if($generalSettings->social_facebook)
                        <a href="{{ $generalSettings->social_facebook }}" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#D4A017] transition-all"><x-heroicon-m-globe-alt class="w-5 h-5" /></a>
                    @endif
                    @if($generalSettings->social_instagram)
                        <a href="{{ $generalSettings->social_instagram }}" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#D4A017] transition-all"><x-heroicon-m-camera class="w-5 h-5" /></a>
                    @endif
                </div>
            </div>
            
            {{-- Kolom 2: Tautan Redaksi --}}
            <div>
                <h4 class="text-sm font-heading font-extrabold uppercase tracking-widest text-[#D4A017] mb-6">Redaksi</h4>
                <ul class="space-y-4 text-sm text-slate-300 font-sans">
                    <li><a href="{{ route('page.show', 'tentang-kami') }}" class="hover:text-white transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('page.show', 'susunan-redaksi') }}" class="hover:text-white transition-colors">Susunan Redaksi</a></li>
                    <li><a href="{{ route('page.show', 'pedoman-media-siber') }}" class="hover:text-white transition-colors">Pedoman Siber</a></li>
                    <li><a href="{{ route('page.show', 'disclaimer') }}" class="hover:text-white transition-colors">Disclaimer</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Kontak --}}
            <div class="md:col-span-2">
                <h4 class="text-sm font-heading font-extrabold uppercase tracking-widest text-[#D4A017] mb-6">Kontak Kami</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-slate-300 font-sans">
                    <div class="flex items-start gap-3">
                        <x-heroicon-m-envelope class="w-5 h-5 text-[#D4A017] shrink-0" />
                        <span>{{ $generalSettings->contact_email }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-heroicon-m-phone class="w-5 h-5 text-[#D4A017] shrink-0" />
                        <span>{{ $generalSettings->contact_phone }}</span>
                    </div>
                    <div class="flex items-start gap-3 sm:col-span-2">
                        <x-heroicon-m-map-pin class="w-5 h-5 text-[#D4A017] shrink-0" />
                        <span>{{ $generalSettings->address }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="border-t border-white/10 pt-8 mt-8 text-center text-slate-500 text-xs font-sans">
            &copy; {{ date('Y') }} {{ $generalSettings->site_name }}. Seluruh hak cipta dilindungi undang-undang.
        </div>
    </div>
</footer>