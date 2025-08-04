<?php

namespace App\Http\Requests;

use App\DTOs\OcurrenceStoreRequestDTO;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Rules\GeometryGeojsonRule;
use Illuminate\Foundation\Http\FormRequest;

class OcurrenceStoreRequets extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location'     => ['required', new GeometryGeojsonRule([Point::class])],
            'type_id'      => 'required|exists:types_ocurrence,id',
            'description'  => 'nullable|string|max:250',
            'address_name' => 'required|string|max:500',
            'city'         => 'nullable|string|max:250',
            'state'        => 'nullable|string|max:250',
            'country'      => 'nullable|string|max:250',
        ];
    }

    public function getDto(): OcurrenceStoreRequestDTO
    {

        return new OcurrenceStoreRequestDTO($this->validated());
    }

    public function bodyParameters(): array
    {
        return [
            'location' => [
                'description' => 'Coordenadas geográficas no formato GeoJSON Point.',
                'example'     => ['type' => 'Point', 'coordinates' => [-15.7801, -47.9292]],
            ],
            'type_id' => [
                'description' => 'ID do tipo de ocorrência existente.',
                'example'     => 2,
            ],
            'description' => [
                'description' => 'Descrição do problema (opcional, até 250 caracteres).',
                'example'     => 'Buraco na rua dificultando o tráfego',
            ],
            'address_name' => [
                'description' => 'Endereço descritivo da ocorrência.',
                'example'     => 'Rua das Palmeiras, 123',
            ],
            'city' => [
                'description' => 'Cidade da ocorrência.',
                'example'     => 'Belém',
            ],
            'state' => [
                'description' => 'Estado da ocorrência.',
                'example'     => 'PA',
            ],
            'country' => [
                'description' => 'País da ocorrência.',
                'example'     => 'Brasil',
            ],
        ];
    }
}
