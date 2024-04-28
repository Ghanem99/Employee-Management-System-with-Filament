<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\State;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('first_name')
                        ->label('First Name')
                        ->required()
                        ->placeholder('John'),
                    TextInput::make('last_name')
                        ->label('Last Name')
                        ->required()
                        ->placeholder('Doe'),
                    TextInput::make('address')
                        ->label('Address')
                        ->required()
                        ->placeholder('1234 Elm St.'),
                    TextInput::make('zip_code')
                        ->label('Zip Code')
                        ->required()
                        ->placeholder('12345'),
                    DatePicker::make('birth_date')
                        ->label('Birth Date')
                        ->required(),
                    DatePicker::make('date_hired')
                        ->label('Date Hired')
                        ->required(),
                    Select::make('department_id')
                        ->label('Department')
                        ->placeholder('Select the department')
                        ->relationship('department', 'name')
                        ->required(),
                    // make dependent dropdowns from the country, state, and city tables
                    Select::make('country_id')
                        ->label('Country')
                        ->placeholder('Select the country')
                        ->relationship('country', 'name')
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('state_id', null))
                        ->required(),
                    Select::make('state_id')
                        ->label('State')
                        ->placeholder('Select the state')
                        ->options(function (callable $get) {
                            $country = $get('country_id');
                            if (!$country) {
                                return State::all()->pluck('name', 'id');
                            }
                            return State::where('country_id', $country)->get()->pluck('name', 'id');
                        })
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('city_id', null))
                        ->required(),
                    Select::make('city_id')
                        ->label('City')
                        ->placeholder('Select the city')
                        ->options(function (callable $get) {
                            $state = $get('state_id');
                            if (!$state) {
                                return State::all()->pluck('name', 'id');
                            }
                            return State::find($state)->cities->pluck('name', 'id');
                        })
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('zip_code')
                    ->label('Zip Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('birth_date')
                    ->label('Birth Date')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_hired')
                    ->label('Date Hired')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('department.name')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('country.name')
                    ->label('Country')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('state.name')
                    ->label('State')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city.name')
                    ->label('City')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
