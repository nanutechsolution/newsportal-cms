<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'NusaAksara CMS');
        $this->migrator->add('general.site_description', 'Portal Berita Profesional Terkini dan Terpercaya.');
        $this->migrator->add('general.logo_url', null);
        $this->migrator->add('general.favicon_url', null);
        $this->migrator->add('general.contact_email', 'redaksi@nusaaksara.com');
        $this->migrator->add('general.contact_phone', '081234567890');
        $this->migrator->add('general.address', 'Jl. Jenderal Sudirman No. 1, Jakarta');
        $this->migrator->add('general.social_facebook', null);
        $this->migrator->add('general.social_instagram', null);
        $this->migrator->add('general.social_twitter', null);
    }
};