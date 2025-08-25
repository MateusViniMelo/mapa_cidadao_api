<?php

namespace App\Http\Controllers;

use App\Http\Requests\InactiveOcurrenceRequest;
use App\Http\Requests\OcurrenceStoreRequets;
use App\Models\Ocurrence;
use App\Services\OcurrenceService;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Http\JsonResponse;

class OcurrenceController extends Controller
{
    public function __construct(private OcurrenceService $ocurrenceService) {}

    /**
     * @group Ocorrências
     * Listar todas as ocorrências
     *
     * Este endpoint retorna uma lista de todas as ocorrências registradas.
     *
     * @response 200 {
     *   "ocurrences": [
     *     {
     *       "id": 1,
     *       "type_id": 2,
     *       "user_id": 8,
     *       "description": "Buraco na rua que está dificultando o tráfego",
     *       "location": {
     *         "type": "Point",
     *         "coordinates": [-15.7801, -47.9292]
     *       },
     *       "address_name": "Rua das Palmeiras, 123",
     *       "city": "Belém",
     *       "state": "PA",
     *       "country": "Brasil",
     *       "created_at": "2025-07-10T20:30:00.000000Z",
     *       "updated_at": "2025-07-10T20:30:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index(): JsonResponse
    {
        $ocurrences = Ocurrence::all();

        return response()->json([
            'ocurrences' => $ocurrences,
        ]);
    }

    /**
     * @group Ocorrências
     * Registrar nova ocorrência
     *
     * Este endpoint permite que usuários autenticados registrem uma nova ocorrência no sistema.
     *
     * @authenticated
     *
     * @response 201 {
     *   "ocurrence": {
     *     "id": 1,
     *     "type_id": 2,
     *     "user_id": 8,
     *     "description": "Buraco na rua dificultando o tráfego",
     *     "location": {
     *       "type": "Point",
     *       "coordinates": [-15.7801, -47.9292]
     *     },
     *     "address_name": "Rua das Palmeiras, 123",
     *     "city": "Belém",
     *     "state": "PA",
     *     "country": "Brasil",
     *     "is_active": true,
     *     "created_at": "2025-07-10T20:30:00.000000Z",
     *     "updated_at": "2025-07-10T20:30:00.000000Z"
     *   }
     * }
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "type_id": ["O tipo informado não existe."],
     *     "location": ["O campo location deve ser um ponto GeoJSON válido."]
     *   }
     * }
     */
    public function store(OcurrenceStoreRequets $request): JsonResponse
    {
        $ocurrenceStore = $request->getDto();

        $ocurrence = $this->ocurrenceService->create($ocurrenceStore, $request->user()->id);

        return response()->json(['ocurrence' => $ocurrence], 201);
    }

    /**
     * @group Ocorrências
     * Inativar ocorrência
     *
     * Este endpoint permite que usuários autenticados inativem uma ocorrência existente, fornecendo uma descrição da solução e o tipo de resolução.
     *
     * @urlParam ocurrence required O ID da ocorrência a ser inativada. Example: 1
     *
     * @authenticated
     *
     * @response 200 {
     *   "message": "Ocorrência inativada com sucesso."
     * }
     * @response 422 {
     *   "message": "Tipo de resolução inválido."
     * }
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Ocurrence] 999"
     * }
     */
    public function inactiveOcurrence(InactiveOcurrenceRequest $request, Ocurrence $ocurrence): JsonResponse
    {

        if ($ocurrence->is_active === false) {
            return response()->json(['message' => 'Ocorrência já inativada.'], 422);
        }

        if ($ocurrence->user_id === $request->user()->id) {
            try {
                $inactiveOcurrence = $request->getDto();
                $this->ocurrenceService->inactivate($ocurrence, $inactiveOcurrence);
            } catch (\Exception $e) {
                return response()->json('Não foi possível inativar a ocorrência.', 422);
            }

            return response()->json(['message' => 'Ocorrência inativada com sucesso.']);

        }

        return response()->json(['message' => 'Você não tem permissão para inativar esta ocorrência.'], 403);

    }
}
