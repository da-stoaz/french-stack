<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $service_id
 * @property string $time_slot_id
 * @property string $patient_name
 * @property string $patient_email
 * @property string|null $patient_phone
 * @property string|null $notes
 * @property string $status
 * @property string $confirmation_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Service $service
 * @property-read \App\Models\TimeSlot $timeSlot
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePatientEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePatientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePatientPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereTimeSlotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'service_id',
        'time_slot_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'notes',
        'status',
        'confirmation_token',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
