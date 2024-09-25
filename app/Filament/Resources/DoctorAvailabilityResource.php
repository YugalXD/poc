<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorAvailabilityResource\Pages;
use App\Filament\Resources\DoctorAvailabilityResource\RelationManagers;
use App\Models\DoctorAvailability;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\DateColumn;
use Filament\Forms\Components\Hidden;


class DoctorAvailabilityResource extends Resource
{
    protected static ?string $model = DoctorAvailability::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('doctor_id')
                    ->default(fn() => auth::id())
                    ->required(),
            DatePicker::make('date')->required(),
            TimePicker::make('start_time')->required(),
            TimePicker::make('end_time')->required(),
            Select::make('slot_duration')
                ->options([
                    15 => '15 minutes',
                    30 => '30 minutes',
                ])
                ->default(15)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Date')
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Start Time')
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('H:i')),

                TextColumn::make('end_time')
                    ->label('End Time')
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('H:i')),

                TextColumn::make('slot_duration')
                    ->label('Slot Duration')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state . ' minutes'),

                TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListDoctorAvailabilities::route('/'),
            'create' => Pages\CreateDoctorAvailability::route('/create'),
            'edit' => Pages\EditDoctorAvailability::route('/{record}/edit'),
        ];
    }

}
