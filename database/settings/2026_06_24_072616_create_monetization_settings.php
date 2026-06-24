<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('monetization.adsense_client_id', null);
        $this->migrator->add('monetization.is_adsense_active', false);
        $this->migrator->add('monetization.header_ad_code', null);
        $this->migrator->add('monetization.sidebar_ad_code', null);
        $this->migrator->add('monetization.article_ad_code', null);
        $this->migrator->add('monetization.footer_ad_code', null);
    }
};