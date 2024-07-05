<?php

namespace App\Filament\Resources\OrdemServicoResource\Pages;

use App\Filament\Resources\OrdemServicoResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrdemServicos extends ListRecords
{
    protected static string $resource = OrdemServicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Todas'),
            'Novas' => Tab::make()->query(fn ($query) => $query->where('status', 'new')),
            'Processando' => Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
            'Enviado' => Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
            'Devolvido' => Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'Cancelado' => Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }
}
