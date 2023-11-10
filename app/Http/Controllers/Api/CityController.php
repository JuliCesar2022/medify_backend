<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Models\City;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $department
     * @return JsonResponse
     */
    public function show($department): JsonResponse
    {
        try {
            $cities = City::query()->where('departamento_id', $department)->get();

            if ($cities->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No exists'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'data' => $cities,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'data' => $exception,
                'message' => 'Fallo de excepción CityController@show'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
