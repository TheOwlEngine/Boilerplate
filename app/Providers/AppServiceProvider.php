<?php

namespace App\Providers;

use App\Filament\Pages\SiteSettings;
use App\Filament\Resources\NewsletterResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserRoleResource;
use App\Filament\Resources\AuthorResource;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\PostResource;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;

use Ramnzys\FilamentEmailLog\Filament\Resources\EmailResource;
use RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Settings')
                    ->url(route('filament.pages.site-settings'))
                    ->icon('heroicon-s-cog'),
            ]);
    
            Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
                $builder->item(
                    NavigationItem::make()
                        ->label('Dashboard')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                        ->url(route('filament.pages.dashboard')),
                );
    
                $builder->group('Content', [
                    ...CategoryResource::getNavigationItems(),
                    ...PostResource::getNavigationItems(),
                ]);
    
                $builder->group('Logs', [
                    ...EmailResource::getNavigationItems(),
                    ...NewsletterResource::getNavigationItems(),
                ]);

                $builder->group('Administrations', [
                    ...UserResource::getNavigationItems(),
                    ...UserRoleResource::getNavigationItems(),
                    ...AuthorResource::getNavigationItems(),
                    ...NavigationResource::getNavigationItems(),
                    ...SiteSettings::getNavigationItems(),
                    ...\ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups::getNavigationItems(),
                ]);
    
                return $builder;
            });
        });
    }
}
