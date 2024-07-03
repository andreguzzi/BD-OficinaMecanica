<?php

namespace App\Filament\Resources\MaoObraResource\Pages;

use App\Filament\Resources\MaoObraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaoObra extends EditRecord
{
    protected static string $resource = MaoObraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
