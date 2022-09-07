<?php

namespace App\Filament\Pages;

use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Grid;
use Spatie\Sitemap\SitemapGenerator;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use Filament\Forms\Components\FileUpload;
use App\Filament\Settings\SitesSettings;


class SiteSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = SitesSettings::class;

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = 'Settings';

    protected static function getNavigationLabel(): string
    {
        return __('Settings');
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('sitemap')->action('generateSitemap')->label(__('Generate Sitemap')),
        ];
    }


    public function generateSitemap()
    {
        // SitemapGenerator::create(config('app.url'))->writeToFile(public_path('sitemap.xml'));

        session()->flash('notification', [
            'message' => __("Sitemap Generated Success"),
            'status' => "success",
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(['default' => 2])->schema([
                TextInput::make('site_name_en')->columnSpan(["2xl" => 1])->hint('setting("site_name_en")'),
                TextInput::make('site_name_id')->columnSpan(["2xl" => 1])->hint('setting("site_name_id")'),
                TextArea::make('site_description_en')->columnSpan(["2xl" => 1])->hint('setting("site_description_en")'),
                TextArea::make('site_description_id')->columnSpan(["2xl" => 1])->hint('setting("site_description_id")'),
                TextArea::make('site_keywords_en')->columnSpan(["2xl" => 1])->hint('setting("site_keywords_en")'),
                TextArea::make('site_keywords_id')->columnSpan(["2xl" => 1])->hint('setting("site_keywords_id")'),
                TextInput::make('site_currency_en')->hint('setting("site_currency_en")'),
                TextInput::make('site_currency_id')->hint('setting("site_currency_id")'),
                TextInput::make('site_language_en')->hint('setting("site_language_en")'),
                TextInput::make('site_language_id')->hint('setting("site_language_id")'),
                TextInput::make('site_author')->columnSpan(["2xl" => 1])->hint('setting("site_author")'),
                TextInput::make('site_email')->columnSpan(["2xl" => 1])->hint('setting("site_email")'),
                TextInput::make('site_phone')->columnSpan(["2xl" => 1])->hint('setting("site_phone")'),
                TextInput::make('site_address')->columnSpan(["2xl" => 1])->hint('setting("site_address")'),
                TextInput::make('site_phone_code')->columnSpan(["2xl" => 1])->hint('setting("site_phone_code")'),
                TextInput::make('site_location')->columnSpan(["2xl" => 2])->hint('setting("site_location")'),
                FileUpload::make('site_profile')->columnSpan(["2xl" => 2])->hint('setting("site_profile")'),
                FileUpload::make('site_logo')->columnSpan(["2xl" => 2])->hint('setting("site_logo")'),
                Repeater::make('site_social')->columnSpan(["2xl" => 2])->schema([
                    TextInput::make('vendor'),
                    TextInput::make('link')->url(),
                ])->hint('setting("site_social")'),
            ])

        ];
    }
}