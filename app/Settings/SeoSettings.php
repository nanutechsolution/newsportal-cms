<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SeoSettings extends Settings
{
    public string $meta_title;
    public string $meta_description;
    public string $meta_keywords;
    public ?string $og_image_url;
    public ?string $twitter_handle;
    public ?string $google_analytics_id;
    public ?string $google_search_console_code;

    public static function group(): string
    {
        return 'seo';
    }
}