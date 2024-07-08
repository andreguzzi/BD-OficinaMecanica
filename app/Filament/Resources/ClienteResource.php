<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use App\Models\Endereco;
use Filament\Forms\Components\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Cliente')
                ->schema([
                    Forms\Components\TextInput::make('nome')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telefone')
                        ->tel()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Radio::make('tipo_pessoa')
                        ->options([
                            'PF' => 'Pessoa Física',
                            'PJ' => 'Pessoa Jurídica',
                        ])
                        ->reactive()
                        ->inline(),
                    Forms\Components\TextInput::make('CPF')
                        ->hidden(fn (Get $get) => $get('tipo_pessoa') !== 'PF') // Show CPF only if 'PF' is selected

                        ->maxLength(14), // Assuming Brazilian CPF format
                    Forms\Components\TextInput::make('CNPJ')
                        ->hidden(fn (Get $get) => $get('tipo_pessoa') !== 'PJ') // Initially hide CNPJ

                        ->maxLength(18), // Assuming Brazilian CNPJ format
                    Forms\Components\TextInput::make('razao_social')
                        ->hidden(fn (Get $get) => $get('tipo_pessoa') !== 'PJ') // Initially hide Razão Social

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
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('endereco.cidade')
                ->label('Cidade'),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('CPF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('CNPJ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                //
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
