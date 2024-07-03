<?php

namespace App\Filament\Resources\MaoObraResource\Pages;

use App\Filament\Resources\MaoObraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaoObras extends ListRecords
{
    protected static string $resource = MaoObraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
