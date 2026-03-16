<?php

namespace App\Filament\Resources\TimeSlotResource\Pages;

use App\Filament\Resources\TimeSlotResource;
use App\Models\TimeSlot;
use Carbon\CarbonImmutable;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;

class ListTimeSlots extends ListRecords
{
    protected static string $resource = TimeSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('bulkCreate')
                ->label('Bulk create slots')
                ->icon('heroicon-o-plus-circle')
                ->form([
                    Forms\Components\DatePicker::make('start_date')->required(),
                    Forms\Components\DatePicker::make('end_date')->required(),
                    Forms\Components\Textarea::make('slot_times')
                        ->label('Slot start times (one per line, HH:MM)')
                        ->default("09:00\n10:00\n11:00\n14:00\n15:00\n16:00")
                        ->required(),
                    Forms\Components\TextInput::make('duration_minutes')
                        ->numeric()
                        ->default(60)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $start = CarbonImmutable::parse($data['start_date']);
                    $end = CarbonImmutable::parse($data['end_date']);
                    $durationMinutes = (int) $data['duration_minutes'];
                    $times = collect(explode("\n", trim((string) $data['slot_times'])))
                        ->map(fn (string $time) => trim($time))
                        ->filter()
                        ->values();

                    for ($date = $start; $date->lte($end); $date = $date->addDay()) {
                        if ($date->isWeekend()) {
                            continue;
                        }

                        foreach ($times as $time) {
                            $slotStart = CarbonImmutable::parse($date->format('Y-m-d').' '.$time);
                            $slotEnd = $slotStart->addMinutes($durationMinutes);

                            TimeSlot::query()->firstOrCreate([
                                'date' => $date->format('Y-m-d'),
                                'starts_at' => $slotStart->format('H:i:s'),
                                'ends_at' => $slotEnd->format('H:i:s'),
                            ], [
                                'is_available' => true,
                            ]);
                        }
                    }
                }),
        ];
    }
}
