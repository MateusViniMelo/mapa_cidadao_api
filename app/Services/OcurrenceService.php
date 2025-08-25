<?php

namespace App\Services;

use App\DTOs\InactiveOcurrenceRequestDTO;
use App\DTOs\OcurrenceStoreRequestDTO;
use App\Enums\TypeOcurrenceClosure;
use App\Models\Ocurrence;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Model;

class OcurrenceService
{
    public function create(OcurrenceStoreRequestDTO $dto, int $userId): Ocurrence
    {
        $locationFormated = Point::makeGeodetic(
            $dto->location->coordinates[0],
            $dto->location->coordinates[1]
        );

        $data             = $dto->toArray();
        $data['user_id']  = $userId;
        $data['location'] = $locationFormated;

        return Ocurrence::create($data);
    }

    public function inactivate(Ocurrence $ocurrence, InactiveOcurrenceRequestDTO $dto): Model
    {
        match ($dto->type_closure) {
            TypeOcurrenceClosure::RESOLVED->value => $ocurrence->update([
                'type_closure'         => $dto->type_closure,
                'is_active'            => false,
                'solution_description' => $dto->solution_description,
            ]),
            TypeOcurrenceClosure::MISTAKE->value => $ocurrence->delete(),
            default                              => abort(422, 'Tipo de resolução inválido.')
        };

        return $ocurrence;
    }
}
