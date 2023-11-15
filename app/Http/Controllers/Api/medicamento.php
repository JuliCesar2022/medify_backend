<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicamentoRequest;
use App\Models\medicamentos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class medicamento extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            
           
            $usuario = Auth::guard('api')->user();
            
        
            // Obtener datos solo del usuario autenticado
            $response = medicamentos::where('user_id', $usuario->id)->get();

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicamentoRequest $request)
    {
        //
        try{

            $medicamento = new medicamentos();

            $medicamento->medicamento = $request->medicamento;
            $medicamento->tipomedicamento = $request->tipomedicaemnto;
            $medicamento->dosis = $request->dosis;
            $medicamento->frecuencia = $request->frecuencia;
            $medicamento->iniciotratamiento = $request->iniciotratamiento;
            $medicamento->fintratameinto = $request->fintratamiento;
            $medicamento->recordar = $request->recordar;
            $medicamento->usuario_id = $request->usuario_id;
            

            $medicamento->save();

        
            return response()->json([
                'success' => true,
                'data' => 'OK'
            ]);

        }catch (Exception $exception) {
            return response()->json([
                'data' => $exception->getMessage(),
                'success' => false,
                'message' => 'Fallo de excepción UserController@store'
            ], Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
