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
            TypeOcurrenceClosure::RESOLVED->value => $this->closeOcurrenceWithDescription($ocurrence, $dto->type_closure, $dto->solution_description),
            TypeOcurrenceClosure::MISTAKE->value  => $ocurrence->delete(),
            TypeOcurrenceClosure::OTHER->value    => $this->closeOcurrenceWithDescription($ocurrence, $dto->type_closure, $dto->solution_description),
            default                               => abort(404, 'Não existe esse tipo de encerramento.')
        };

        return $ocurrence;
    }

    private function closeOcurrenceWithDescription(Ocurrence $ocurrence, string $type, string $solutionDescription): void
    {
        $ocurrence->update([
            'type_closure'         => $type,
            'is_active'            => false,
            'solution_description' => $solutionDescription,
        ]);
    }
}
