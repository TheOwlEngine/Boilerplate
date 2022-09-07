<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AuthorResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Pages\Actions;

class ListAuthors extends ListRecords
{
    use Translatable;

    protected static string $resource = AuthorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
