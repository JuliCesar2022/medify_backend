<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professions;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = Professions::all(['name','slug_name']);
            return response()->json([
                'success' => true,
                'data' => $response
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'data' => $exception->getMessage(),
                'success' => false,
                'message' => 'Fallo de excepción ProfessionsController@index'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
