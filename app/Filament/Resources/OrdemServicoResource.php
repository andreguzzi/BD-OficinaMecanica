<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdemServicoResource\Pages;
use App\Filament\Resources\OrdemServicoResource\RelationManagers;
use App\Models\OrdemServico;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class OrdemServicoResource extends Resource
{
    protected static ?string $model = OrdemServico::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $pluralModelLabel = 'Ordens de Serviços';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dataEmissao')
                    ->required(),
                Forms\Components\DatePicker::make('dataEntrega')
                    ->required(),
                    
                Select::make('cliente_id')
                    ->relationship('cliente', titleAttribute: 'nome')
                    ->createOptionForm(ClienteResource::getDadosForm())
                    ->editOptionForm(ClienteResource::getDadosForm()),
                Select::make('veiculo_id')
                    ->relationship('veiculo', titleAttribute: 'placa')
                    ->createOptionForm(VeiculoResource::getDadosForm())
                    ->editOptionForm(VeiculoResource::getDadosForm()),
                Select::make('mecanico_id')
                    ->relationship('mecanico', titleAttribute: 'nome')
                    ->createOptionForm(MecanicoResource::getDadosForm())
                    ->editOptionForm(MecanicoResource::getDadosForm()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dataEmissao')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dataEntrega')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mecanico.nome')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('veiculo.placa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ServicoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdemServicos::route('/'),
            'create' => Pages\CreateOrdemServico::route('/create'),
            'edit' => Pages\EditOrdemServico::route('/{record}/edit'),
        ];
    }
}
