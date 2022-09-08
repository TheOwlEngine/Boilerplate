<?php

namespace App\Filament\Settings;

use Spatie\LaravelSettings\Settings;

class SitesSettings extends Settings
{
    public string $site_name_en;
    public string $site_name_id;
    public string $site_description_en;
    public string $site_description_id;
    public string $site_keywords_en;
    public string $site_keywords_id;
    public string $site_profile;
    public string $site_logo;
    public string $site_author;
    public string $site_address;
    public string $site_email;
    public string $site_phone;
    public string $site_phone_code;
    public string $site_location;
    public string $site_currency_en;
    public string $site_currency_id;
    public string $site_language_en;
    public string $site_language_id;
    public array $site_social;

    public static function group(): string
    {
        return 'sites';
    }
}