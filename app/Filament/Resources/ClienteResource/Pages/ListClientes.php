<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use App\Models\Cliente;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListClientes extends ListRecords
{
    protected static string $resource = ClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(' + '),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Todos')->icon('heroicon-m-user-group')->badge(Cliente::query()->count()),
            'Pessoa Física' => Tab::make()->query(fn ($query) => $query->where('tipo_pessoa', 'PF'))->badge(Cliente::query()->where('tipo_pessoa', 'PF')->count()),
            'Pessoa Jurídica' => Tab::make()->query(fn ($query) => $query->where('tipo_pessoa', 'PJ'))->badge(Cliente::query()->where('tipo_pessoa', 'PJ')->count()),
        ];
    }
    
}
