<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\AuthorResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateAuthor extends CreateRecord
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
