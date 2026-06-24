<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class MonetizationSettings extends Settings
{
    public ?string $adsense_client_id;
    public bool $is_adsense_active;
    public ?string $header_ad_code;
    public ?string $sidebar_ad_code;
    public ?string $article_ad_code;
    public ?string $footer_ad_code;

    public static function group(): string
    {
        return 'monetization';
    }
}