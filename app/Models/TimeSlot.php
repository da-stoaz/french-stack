<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property \Illuminate\Support\Carbon $date
 * @property string $starts_at
 * @property string $ends_at
 * @property bool $is_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeSlot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TimeSlot extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'date',
        'starts_at',
        'ends_at',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_available' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
