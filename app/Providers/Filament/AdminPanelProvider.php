<?php

namespace App\Providers\Filament;

use App\Settings\GeneralSettings;
use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::hex('#0F2D52'),

            ])
            // Mengambil Brand Name dari GeneralSettings secara dinamis (Lazy Evaluation)
            ->brandName(fn() => app(GeneralSettings::class)->site_name ?? 'NusaAksara CMS')
            // Mengambil Brand Logo dari GeneralSettings secara dinamis (Lazy Evaluation)
            ->brandLogo(function () {
                $settings = app(GeneralSettings::class);
                if ($settings->logo_url && Storage::disk('public')->exists($settings->logo_url)) {
                    return Storage::url($settings->logo_url);
                }
                return null;
            })
            // Menyesuaikan tinggi logo agar terlihat proporsional
            ->brandLogoHeight('3rem')
            ->favicon(function () {
                $settings = app(GeneralSettings::class);
                if ($settings->favicon_url && Storage::disk('public')->exists($settings->favicon_url)) {
                    return Storage::url($settings->favicon_url);
                }
                return null;
            })
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->navigationGroups([
                'Manajemen Konten',
                'Sistem & Pengaturan',
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make()->navigationGroup("Sistem & Pengaturan"),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
