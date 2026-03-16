<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeSlotResource\Pages;
use App\Models\TimeSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TimeSlotResource extends Resource
{
    protected static ?string $model = TimeSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('date')
                ->required(),
            Forms\Components\TimePicker::make('starts_at')
                ->seconds(false)
                ->required(),
            Forms\Components\TimePicker::make('ends_at')
                ->seconds(false)
                ->required(),
            Forms\Components\Toggle::make('is_available')
                ->label('Available')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('date')
            ->query(TimeSlot::query()->orderBy('date')->orderBy('starts_at'))
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('starts_at')->label('Start'),
                Tables\Columns\TextColumn::make('ends_at')->label('End'),
                Tables\Columns\IconColumn::make('is_available')->boolean()->label('Available'),
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['date'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('date', $date)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimeSlots::route('/'),
            'create' => Pages\CreateTimeSlot::route('/create'),
            'edit' => Pages\EditTimeSlot::route('/{record}/edit'),
        ];
    }
}
