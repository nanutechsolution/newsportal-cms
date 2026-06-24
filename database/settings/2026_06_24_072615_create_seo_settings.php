<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('seo.meta_title', 'NusaAksara CMS - Portal Berita');
        $this->migrator->add('seo.meta_description', 'Portal berita terdepan menyajikan informasi aktual dan terpercaya.');
        $this->migrator->add('seo.meta_keywords', 'berita, portal, nusaaksara, terkini, daerah');
        $this->migrator->add('seo.og_image_url', null);
        $this->migrator->add('seo.twitter_handle', '@nusaaksara');
        $this->migrator->add('seo.google_analytics_id', null);
        $this->migrator->add('seo.google_search_console_code', null);
    }
};