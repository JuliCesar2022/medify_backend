<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class MovimentsController extends Controller
{
    static function getHistoryByID($technical_id){

        try {

            $moviments = Movement::where('technical_id', $technical_id )->latest()->paginate(10);

            return response()->json([
                'success' => true,
                'message' => "OK",
                'data'=>$moviments
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Error interno"
            ]);
        }

    }
}
