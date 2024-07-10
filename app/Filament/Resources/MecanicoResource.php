<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MecanicoResource\Pages;
use App\Filament\Resources\MecanicoResource\RelationManagers;
use App\Models\Mecanico;
use Filament\Forms\Components\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Get;


class MecanicoResource extends Resource
{
    protected static ?string $model = Mecanico::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::getDadosForm()
            ]);
    }

    public static function getDadosForm(): array
    {
        return [
            Fieldset::make('Dados do Mecânico')
                ->schema([

                    Forms\Components\TextInput::make('nome')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('descricao')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('especialidade')
                        ->required()
                        ->maxLength(255),
                ]),
            Fieldset::make('Endereço')
                ->relationship('endereco')
                ->schema([
                    TextInput::make('CEP')
                        ->label('CEP')
                        ->rules(['required', 'min:8', 'string'])
                        //->mask(fn (TextInput\Mask $mask) => $mask->pattern('00000-000'))
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 6,
                        ])
                        ->suffixAction(
                            fn ($state, \Filament\Forms\Set $set) =>
                            Action::make('search-action')
                                ->icon('heroicon-o-magnifying-glass')
                                ->action(function () use ($state, $set) {
                                    if (blank($state)) {
                                        Filament::notify('danger', 'Digite o CEP para buscar o endereço');
                                        return;
                                    }

                                    try {
                                        $cepData = Http::get("https://viacep.com.br/ws/{$state}/json/")
                                            ->throw()
                                            ->json();
                                    } catch (RequestException $e) {
                                        Filament::notify('danger', 'Erro ao buscar o endereço');
                                        return;
                                    }

                                    $set('bairro', $cepData['bairro'] ?? null);
                                    $set('logradouro', $cepData['logradouro'] ?? null);
                                    $set('cidade', $cepData['localidade'] ?? null);
                                    $set('unidade_federativa', $cepData['uf'] ?? null);
                                    //$set('complemento', $cepData['complemento'] ?? null);
                                    // $set('city_id', City::where('title', $cepData['localidade'])->first()->id ?? null);
                                    // $set('state', State::where('letter', $cepData['uf'])->first()->id ?? null);
                                })
                        ),
                    TextInput::make('logradouro')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Logradouro')
                        ->label('Logradouro')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 8,
                        ]),
                    TextInput::make('numero')
                        ->rules(['nullable', 'numeric'])
                        ->numeric()
                        ->placeholder('N/A')
                        ->label('Número')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 2,
                        ]),
                    TextInput::make('bairro')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Bairro')
                        ->label('Bairro')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 5,
                        ]),
                    TextInput::make('cidade')
                        ->rules(['max:255', 'string'])
                        //->required()
                        ->placeholder('Cidade')
                        ->label('Cidade')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 5,
                        ]),
                    TextInput::make('unidade_federativa')
                        //->required()
                        ->maxLength(2)
                        ->placeholder('UF')
                        ->label('UF')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 2,
                        ]),
                    TextInput::make('complemento')
                        ->rules(['nullable', 'max:255', 'string'])
                        ->placeholder('Complemento')
                        ->label('Complemento')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ])
                ])
        ];
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->searchable(),
                Tables\Columns\TextColumn::make('especialidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('endereco_id')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMecanicos::route('/'),
            'create' => Pages\CreateMecanico::route('/create'),
            'edit' => Pages\EditMecanico::route('/{record}/edit'),
        ];
    }
}
