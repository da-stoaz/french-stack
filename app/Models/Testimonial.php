<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $author_name
 * @property string $body
 * @property int $rating
 * @property bool $is_visible
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereAuthorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Testimonial extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'author_name',
        'body',
        'rating',
        'is_visible',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }
}
