<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public string $site_description;
    public ?string $logo_url;
    public ?string $favicon_url;
    public string $contact_email;
    public string $contact_phone;
    public string $address;
    public ?string $social_facebook;
    public ?string $social_instagram;
    public ?string $social_twitter;

    public static function group(): string
    {
        return 'general';
    }
}
