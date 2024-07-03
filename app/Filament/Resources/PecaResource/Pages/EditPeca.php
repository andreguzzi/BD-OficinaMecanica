<?php

namespace App\Filament\Resources\PecaResource\Pages;

use App\Filament\Resources\PecaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeca extends EditRecord
{
    protected static string $resource = PecaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
