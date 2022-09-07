<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditCategory extends EditRecord
{
    use Translatable;

    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
