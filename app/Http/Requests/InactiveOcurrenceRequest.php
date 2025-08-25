<?php

namespace App\Http\Requests;

use App\DTOs\InactiveOcurrenceRequestDTO;
use App\Enums\TypeOcurrenceClosure;
use Illuminate\Foundation\Http\FormRequest;

class InactiveOcurrenceRequest extends FormRequest
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
            'type_closure'         => 'required|in:'.implode(',', array_map(fn ($value) => $value->value, TypeOcurrenceClosure::cases())),
            'solution_description' => 'required_if:type_closure,'.TypeOcurrenceClosure::RESOLVED->value.'|string|max:500',
        ];
    }

    public function getDto(): InactiveOcurrenceRequestDTO
    {

        return new InactiveOcurrenceRequestDTO($this->validated());
    }

    /**
     * Get the body parameters for API documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'type_closure' => [
                'description' => 'Tipo de encerramento de ocorrência.',
                'example'     => 'mistake',
            ],
            'solution_description' => [
                'description' => 'Descrição da solução aplicada. Obrigatório se type_closure for resolved.',
                'example'     => 'Problema resolvido pela companhia',

            ],
        ];
    }
}
