<?php

namespace App\DTOs;

/**
 * @property-read string $type
 * @property-read float[] $coordinates
 */
class LocationDTO
{
    public readonly string $type;

    public readonly array $coordinates;

    public function __construct(array $data)
    {
        $this->type        = (string) $data['type'];
        $this->coordinates = (array) $data['coordinates'];
    }

    public function toArray(): array
    {
        return [
            'type'        => $this->type,
            'coordinates' => $this->coordinates,
        ];
    }
}
