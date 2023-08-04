<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;



class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('country_id')
                            ->relationship(
                                'country',
                                'name',
                                fn ($query) => $query
                                    ->whereHas('states')
                            )
                            ->reactive()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),

                        Select::make('state_id')
                            ->relationship(
                                'state',
                                'name',
                                fn ($query, callable $get) => $query
                                    ->when(
                                        $get('country_id'),
                                        fn ($query) => $query
                                            ->where('country_id', $get('country_id'))
                                    )
                            )
                            ->reactive()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),

                        Select::make('city_id')
                            ->relationship(
                                'city',
                                'name',
                            )
                            ->reactive()
                            ->required()
                            ->searchable()
                            ->preload(),


                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required(),

                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('address')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('zip_code')
                            ->required()
                            ->maxLength(5),

                        DatePicker::make('birth_date')
                            ->required(),

                        DatePicker::make('date_hired')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('first_name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('last_name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('department.name')
                    ->sortable(),

                TextColumn::make('date_hired')
                    ->date(),

                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship('department', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
