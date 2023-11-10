<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories;
use Illuminate\Http\Request;
use App\Http\Repositories\CodigosVerificacion;
use App\Models\User;
use App\Models\UserCopy;
use App\Http\Repositories\ApiWhatsApp\ApiWhasApp;
use App\Http\Repositories\SynchronizeUser\SynchronizeUser;


class ChangeNumerController extends Controller
{

    static function run(Request $request)
    {

        try {
            $user_id = $request->user_id;
            $code = $request->code;
            $newNumberPhone = $request->new_number_phone;
            $newCountrieCode = $request->new_country_code;

            if (!$user_id) {
                return "bad request";
            }

            if (!$newNumberPhone) {
                return "bad request";
            }

            if (!$newCountrieCode) {
                return "bad request";
            }

            $user = User::where('id', $user_id)->first();
            $numberPhone = $newCountrieCode.$newNumberPhone;

            // dd( $numberPhone );

            if ($user) {

                if ($code) {

                  

                    $isOk = CodigosVerificacion::validar_codigo($numberPhone, "ChanguePhoneTag", $code);

                    if ($isOk) {

                        $NumberOld = $user->country_code.$user->phone;

                        // dd($newNumber);
                        if($NumberOld == $numberPhone){

                            return response()->json([
                                'success' => true,
                                'data' => null,
                                'message' => "Este número ya esta vinculado."
    
                            ]);

                        }


                        $user->country_code = $newCountrieCode;
                        $user->phone = $newNumberPhone;

                        $user->update();

       
                        SynchronizeUser::synByUserID( $request->user_id);

                        $user = User::where('id', $request->user_id)->first();

                        return response()->json([
                            'success' => true,
                            'data' => $user,
                            'message' => "Número actualizado."

                        ]);


                    } else {

                        return response()->json([
                            'success' => false,
                            'data' => null,
                            'message' => "codigo invalido"

                        ]);
                    
                    }

                } else {

                    $code = CodigosVerificacion::generate($numberPhone, "ChanguePhoneTag");

                    ApiWhasApp::senMessage($numberPhone, "Tu código de verificación es: *$code*");

                    return response()->json([
                        'success' => true,
                        'data' => null,
                        'message' => "Codigo enviado"

                    ]);
                }
            }

            return false;

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => "Error interno"

            ], 500);
        }


    }
}