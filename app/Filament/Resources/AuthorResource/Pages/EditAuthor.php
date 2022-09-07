<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AuthorResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditAuthor extends EditRecord
{
    use Translatable;

    protected static string $resource = AuthorResource::class;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
