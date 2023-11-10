<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = Department::all();
            return response()->json([
                'success' => true,
                'data' => $response,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'data' => $exception->getMessage(),
                'success' => false,
                'message' => 'Fallo de excepción DepartmentController@index'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
