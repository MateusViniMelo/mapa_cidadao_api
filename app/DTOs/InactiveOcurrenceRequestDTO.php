<?php

namespace App\DTOs;

/**
 * @property string      $type_closure
 * @property string|null $solution_description
 */
class InactiveOcurrenceRequestDTO
{
    public string $type_closure;

    public ?string $solution_description;

    public function __construct(array $data)
    {
        $this->type_closure         = $data['type_closure'];
        $this->solution_description = $data['solution_description'] ?? null;
    }
}
