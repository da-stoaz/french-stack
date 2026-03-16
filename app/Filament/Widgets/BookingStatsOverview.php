<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalBookings = Booking::query()->count();
        $pendingBookings = Booking::query()->where('status', 'pending')->count();
        $confirmedBookings = Booking::query()->where('status', 'confirmed')->count();

        $totalRevenue = Booking::query()
            ->where('status', 'confirmed')
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->sum('services.price');

        return [
            Stat::make('Total bookings', (string) $totalBookings),
            Stat::make('Pending bookings', (string) $pendingBookings),
            Stat::make('Confirmed bookings', (string) $confirmedBookings),
            Stat::make('Total revenue', 'EUR '.number_format((float) $totalRevenue, 2)),
        ];
    }
}
