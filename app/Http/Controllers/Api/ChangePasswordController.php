<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories;
use Illuminate\Http\Request;
use App\Http\Repositories\CodigosVerificacion;
use App\Models\User;
use App\Models\UserCopy;
use App\Http\Repositories\ApiWhatsApp\ApiWhasApp;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\SynchronizeUser\SynchronizeUser;

class ChangePasswordController extends Controller
{

    static function run(Request $request)
    {

        try {

            $email = $request->email;
            $code = $request->code;
            $newPassword = $request->new_password;

            if (!$email) {
                return "bad request";
            }

            $user = User::where('email_aux', $email)->first();
            $numberPhone = $user->country_code.$user->phone;

            // dd( $numberPhone );

            if ($user) {

                if ($code) {

                    if (!$newPassword) {
                        return "bad request";
                    }

                    $isOk = CodigosVerificacion::validar_codigo($numberPhone, "ChanguePasswordTag", $code);

                    if ($isOk) {


                        $user->password_aux = Hash::make($newPassword);

                        $user->update();


                        $user = User::where('email_aux',$email)->first();
                        SynchronizeUser::synByUserID($user->id);


                        return response()->json([
                            'success' => true,
                            'data' => $user,
                            'message' => "Contraseña actualizada."

                        ]);


                    } else {
                        
                        return response()->json([
                            'success' => false,
                            'data' => null,
                            'message' => "Código invalido"

                        ]);
                    }

                } else {

                    $code = CodigosVerificacion::generate($numberPhone, "ChanguePasswordTag");

                    ApiWhasApp::senMessage($numberPhone, "Tu código de verificación es: *$code*");

                 
                    return response()->json([

                        'success' => true,
                        'data' =>  null,
                        'message' => "Código enviado a ".str_replace(substr($user->phone, 0, 7),  str_repeat("*", 7), $user->phone)

                    ]);

                }

            }else{

                return response()->json([
                    'success' => true,
                    'data' => null,
                    'message' => "El email no existe."
    
                ], 500);
                
            }


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => "Error interno"

            ], 500);
        }


    }
}