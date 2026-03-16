<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentBookings extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent bookings')
            ->query(
                Booking::query()
                    ->with(['service', 'timeSlot'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')->label('Patient')->searchable(),
                Tables\Columns\TextColumn::make('service.name')->label('Service'),
                Tables\Columns\TextColumn::make('timeSlot.date')->date(),
                Tables\Columns\TextColumn::make('timeSlot.starts_at')->label('Time'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ]);
    }
}
