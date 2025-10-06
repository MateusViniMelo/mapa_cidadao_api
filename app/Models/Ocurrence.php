<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Point $location
 * @property-read \App\Models\TypeOcurrence|null $type
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\OcurrenceFactory                    factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ocurrence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ocurrence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ocurrence query()
 *
 * @mixin \Eloquent
 */
class Ocurrence extends Model
{
    use HasFactory;

    protected $table = 'ocurrences';

    protected $fillable = [
        'location',
        'type_id',
        'user_id',
        'description',
        'is_active',
        'address_name',
        'city',
        'state',
        'country',
        'solution_description',
        'type_closure',
        'resolution_date',
    ];

    protected $casts = [
        'location'           => Point::class,
        'is_active'          => 'boolean',
        'resolution_date'    => 'datetime',
        'liked_by_auth_user' => 'boolean',
    ];

    protected $with = ['type'];

    protected $appends = ['liked_by_auth_user', 'likes_count'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeOcurrence::class, 'type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(LikeOcurrence::class, 'ocurrence_id');
    }

    public function getLikedByAuthUserAttribute(): bool
    {

        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }
}
