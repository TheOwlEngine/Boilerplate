<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class Settings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('themes.theme_name', 'main');
        $this->migrator->add('themes.theme_path', 'themes.main');
        $this->migrator->add('themes.theme_namespace', '');
        $this->migrator->add('themes.theme_main_color', '');
        $this->migrator->add('themes.theme_secandry_color', '');
        $this->migrator->add('themes.theme_sub_color', '');
        $this->migrator->add('themes.theme_css', '');
        $this->migrator->add('themes.theme_js', '');
        $this->migrator->add('themes.theme_header', '');
        $this->migrator->add('themes.theme_footer', '');
        $this->migrator->add('themes.theme_copyright', '');

        $this->migrator->add('sites.site_name_en', 'The Boilerplate');
        $this->migrator->add('sites.site_name_id', 'The Boilerplate');
        $this->migrator->add('sites.site_description_en', '-');
        $this->migrator->add('sites.site_description_id', '-');
        $this->migrator->add('sites.site_keywords_en', '-');
        $this->migrator->add('sites.site_keywords_id', '-');
        $this->migrator->add('sites.site_profile', '-');
        $this->migrator->add('sites.site_logo', '-');
        $this->migrator->add('sites.site_author', '-');
        $this->migrator->add('sites.site_address', '-');
        $this->migrator->add('sites.site_email', '-');
        $this->migrator->add('sites.site_phone', '-');
        $this->migrator->add('sites.site_phone_code', '+62');
        $this->migrator->add('sites.site_location', 'Indonesia');
        $this->migrator->add('sites.site_currency_en', 'USD');
        $this->migrator->add('sites.site_currency_id', 'IDR');
        $this->migrator->add('sites.site_language_en', 'en-US');
        $this->migrator->add('sites.site_language_id', 'id-ID');
        $this->migrator->add('sites.site_social', json_encode([]));
    }
};
