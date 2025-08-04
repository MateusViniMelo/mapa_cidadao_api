<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
