<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PostResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreatePost extends CreateRecord
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
