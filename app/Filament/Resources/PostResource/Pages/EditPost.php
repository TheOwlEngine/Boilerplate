<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PostResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditPost extends EditRecord
{
    use Translatable;

    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
