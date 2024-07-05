<?php

namespace App\Filament\Widgets;

use App\Models\Cliente;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClienteTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Clientes Pessoa Fisica', Cliente::query()->where('tipo_pessoa', 'PF')->count()),
            Stat::make('Clientes Pessoa Juridica', Cliente::query()->where('tipo_pessoa', 'PJ')->count())
        ];
    }
}
