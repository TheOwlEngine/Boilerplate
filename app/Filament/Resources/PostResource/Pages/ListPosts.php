<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PostResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Pages\Actions;

class ListPosts extends ListRecords
{
    use Translatable;

    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
