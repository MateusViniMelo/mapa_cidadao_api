<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $casts = [
        'location'  => Point::class,
        'is_active' => 'boolean',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeOcurrence::class, 'type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
