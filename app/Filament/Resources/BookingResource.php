<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Placeholder::make('service')
                ->content(fn (?Booking $record): string => $record?->service?->name ?? '-'),
            Forms\Components\Placeholder::make('time_slot')
                ->content(fn (?Booking $record): string => $record ? ($record->timeSlot?->date?->format('Y-m-d').' '.$record->timeSlot?->starts_at) : '-'),
            Forms\Components\TextInput::make('patient_name')->disabled(),
            Forms\Components\TextInput::make('patient_email')->disabled(),
            Forms\Components\TextInput::make('patient_phone')->disabled(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ])
                ->disabled(),
            Forms\Components\Textarea::make('notes')->disabled()->columnSpanFull(),
            Forms\Components\TextInput::make('confirmation_token')->disabled(),
            Forms\Components\DateTimePicker::make('created_at')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Booking::query()->with(['service', 'timeSlot']))
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')->searchable(),
                Tables\Columns\TextColumn::make('service.name')->label('Service'),
                Tables\Columns\TextColumn::make('timeSlot.date')->label('Date')->date(),
                Tables\Columns\TextColumn::make('timeSlot.starts_at')->label('Time'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Booking $record): bool => $record->status !== 'confirmed')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => 'confirmed']);
                    }),
                Tables\Actions\Action::make('cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => $record->status !== 'cancelled')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => 'cancelled']);
                        $record->timeSlot()->update(['is_available' => true]);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'view' => Pages\ViewBooking::route('/{record}'),
        ];
    }
}
