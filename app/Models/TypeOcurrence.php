<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ocurrence> $ocurrences
 * @property-read int|null $ocurrences_count
 *
 * @method static \Database\Factories\TypeOcurrenceFactory                    factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeOcurrence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeOcurrence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypeOcurrence query()
 *
 * @mixin \Eloquent
 */
class TypeOcurrence extends Model
{
    use HasFactory;

    protected $table = 'types_ocurrence';

    protected $fillable = ['name'];

    public function ocurrences(): HasMany
    {
        return $this->hasMany(Ocurrence::class);
    }
}
