<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Mail\BookingNotification;
use App\Models\Booking;
use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    public function show(Request $request): Response
    {
        $availableDates = TimeSlot::query()
            ->where('is_available', true)
            ->whereDate('date', '>=', now()->toDateString())
            ->select('date')
            ->distinct()
            ->orderBy('date')
            ->pluck('date')
            ->map(fn ($date) => (string) $date);

        return Inertia::render('Book', [
            'services' => Service::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'availableDates' => $availableDates,
            'preselectedServiceId' => $request->query('service'),
        ]);
    }

    public function slots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
        ]);

        $slots = TimeSlot::query()
            ->whereDate('date', $validated['date'])
            ->where('is_available', true)
            ->orderBy('starts_at')
            ->get();

        return response()->json([
            'data' => $slots,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'uuid', Rule::exists('services', 'id')->where('is_active', true)],
            'time_slot_id' => ['required', 'uuid', 'exists:time_slots,id'],
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_email' => ['required', 'email', 'max:255'],
            'patient_phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $booking = DB::transaction(function () use ($validated): Booking {
            $slot = TimeSlot::query()
                ->lockForUpdate()
                ->findOrFail($validated['time_slot_id']);

            if (! $slot->is_available || $slot->date->lt(today())) {
                throw ValidationException::withMessages([
                    'time_slot_id' => 'This time slot is no longer available.',
                ]);
            }

            $slot->update(['is_available' => false]);

            $booking = Booking::query()->create([
                ...$validated,
                'status' => 'pending',
                'confirmation_token' => Str::random(64),
            ]);

            return $booking->load(['service', 'timeSlot']);
        });

        Mail::to($booking->patient_email)->queue(new BookingConfirmation($booking));
        Mail::to(config('brand.email'))->queue(new BookingNotification($booking));

        return to_route('booking.confirmed')->with([
            'success' => 'Your appointment request has been received.',
            'bookingSummary' => [
                'service' => $booking->service->name,
                'date' => $booking->timeSlot->date->format('Y-m-d'),
                'time' => substr((string) $booking->timeSlot->starts_at, 0, 5).' - '.substr((string) $booking->timeSlot->ends_at, 0, 5),
                'price' => $booking->service->price,
            ],
        ]);
    }

    public function confirmed(Request $request): Response
    {
        return Inertia::render('Confirmation', [
            'bookingSummary' => $request->session()->get('bookingSummary'),
        ]);
    }
}
