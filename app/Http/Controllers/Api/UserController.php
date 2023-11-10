<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProfessionsDetail\ProfessionDetail;
use App\Http\Repositories\SynchronizeUser\SynchronizeUser;
use App\Http\Requests\AssignWorkRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Repositories\Wallet\WalletController;
use App\Http\Requests\GenerateCodeWhatsAppRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Briefcase;
use App\Models\Service;
use App\Models\User;
use App\Models\UserCopy;
use App\Traits\HelpersAdmin;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use \App\Http\Repositories\ApiWhatsApp\ApiWhasApp;
use App\Http\Repositories\CodigosVerificacion;
use App\Mail\CodeVerification;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    use HelpersAdmin;

    /**
     * /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {






        
        try {

            $code = $request->code;

            if($code){

                $image = $request->file('photo_profile_url');

                // Obtener la extensión del archivo
                $extension = $image->getClientOriginalExtension();
                
                // Generar un nombre de archivo único basado en la fecha y un número aleatorio
                $fileName = 'profile_' . date('YmdHis') . '_' . rand(1, 9999) . '.' . $extension;
                
                // Mover el archivo a la carpeta de destino con el nuevo nombre
                $image->move('uploads/fotos', $fileName);
                
              

                $isOk = CodigosVerificacion::validar_codigo( $request->email, "CodigosDeRegistro", $code);
 
                 if($isOk){


                    $user = new User();

                    $user->nombre = $request->nombre;
                    $user->apellido = $request->apellido;
                    $user->email = $request->email;
                    $user->email_verified_at = now();
                    $user->type_document_id = $request->type_document_id;
                    $user->number_document = $request->number_document;
                    $user->password = Hash::make($request->password);
                    $user->photo_profile_url  = $fileName;
        
                    $user->save();
        
                
                    return response()->json([
                        'success' => true,
                        'data' => 'OK'
                    ]);
        

                 }else{

                    return response()->json([
                        'success' => false,
                        'data' => 'BAD REQUEST',
                        "message"=> "code invalid"
                    ]);
                 }
            }else{

                $code = CodigosVerificacion::generate( $request->email, "CodigosDeRegistro");

                Mail::to($request->email)->send(new CodeVerification( $code ));
                
                return response()->json([
                    'success' => true,
                    'data' => 'OK',
                    "message"=> "code generado"

                ]);

            }


            // if( $request->photo_profile_url){$photoProfile = $request->photo_profile_url->store('');}  

        } catch (Exception $exception) {
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
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    public function resetPassword($phone): JsonResponse
    {

        if (Cache::tags("resetPassword")->get($phone) === null) {

            $user = User::query()->where('phone', $phone)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => __('messagesWhatsapp.number_invalid')
                ], Response::HTTP_NOT_FOUND);
            }

            $code = rand(000000, 999999);
            $responseWhatsapp = ApiWhasApp::senMessage($phone,
                "El codigo de verificacion es: *$code*"
            );

            if ($responseWhatsapp) {

                Cache::tags("resetPassword")->put($phone, $code, now()->addMinute(5));

                return response()->json([
                    'success' => true,
                    'message' => __('messagesWhatsapp.code_generado')
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => __('messagesWhatsapp.active_code_generated')
        ], Response::HTTP_CONFLICT);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $phone = Cache::tags("resetPassword")->get($request->phone);
        if ($phone !== null) {

            /** @var User $user */
            $user = User::query()->where('phone', $request->phone)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => __('messagesWhatsapp.number_invalid')
                ], Response::HTTP_NOT_FOUND);
            }

            if ($phone != $request->code) {
                return response()->json([
                    'success' => false,
                    'message' => __('messagesWhatsapp.code_invalid')
                ], Response::HTTP_NOT_FOUND);
            }

            $user->password = Hash::make($request->password);
            $response = $user->update();

            if ($response) {
                Cache::tags("resetPassword")->forget($request->phone);

                return response()->json([
                    'success' => true,
                    'message' => __('messagesWhatsapp.ok')
                ]);
            }

        }

        return response()->json([
            'success' => false,
            'message' => __('messagesWhatsapp.not_code_generated')
        ], Response::HTTP_CONFLICT);
    }




    /**
     * @throws AuthorizationException
     */
    public function findPaymentById(User $user): JsonResponse
    {
        $this->authorize('viewUniqueUser', $user);

        return response()->json($user->payments()->paginate(self::NUMBER_PAGINATE), Response::HTTP_OK);
    }

    /**
     * @throws AuthorizationException
     */
    public function findServiceById(User $user): JsonResponse
    {
        $this->authorize('viewUniqueUser', $user);

        return response()->json($user->services()->paginate(self::NUMBER_PAGINATE), Response::HTTP_OK);
    }

    /**
     * @param $phone
     * @return JsonResponse
     */
    public function generateCodeVerificatePhoneWhatsApp($phone): JsonResponse
    {
        $user = User::query()->where('phone', '=', $phone)->first();

        if ($user->phone_verified_at != null) {
            return response()->json([
                'success' => false,
                'message' => __('messagesWhatsapp.number_verification')
            ], Response::HTTP_BAD_REQUEST);
        }

        $phone = $user->country_code . $phone;


        if (Cache::tags("verificatePhoneWhatsApp")->get($phone) === null) {
//            $user = User::query()->where('phone', $phone)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => __('messagesWhatsapp.number_invalid')
                ], Response::HTTP_NOT_FOUND);
            }

            $code = rand(000000, 999999);

            $responseWhatsapp = ApiWhasApp::senMessage($phone,
                "El codigo de verificacion es: *$code*"
            );

            if ($responseWhatsapp) {


                Cache::tags("verificatePhoneWhatsApp")->put($phone, $code, now()->addMinute(5));

                return response()->json([
                    'success' => true,
                    'message' => __('messagesWhatsapp.code_generado')
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => __('messagesWhatsapp.active_code_generated')
        ]);
    }

    public function activePhoneWhatsApp(GenerateCodeWhatsAppRequest $request): JsonResponse
    {
        $user = User::query()->where('phone', '=', $request->phone)->first();

        if ($user->phone_verified_at != null) {
            return response()->json([
                'success' => false,
                'message' => __('messagesWhatsapp.number_verification')
            ], Response::HTTP_BAD_REQUEST);
        }

        $request->phone = $user->country_code . $request->phone;

//        Log::debug('activePhoneWhatsApp | Verificar: ' . $request->phone );

        $phone = Cache::tags("verificatePhoneWhatsApp")->get($request->phone);
        if ($phone !== null) {

            /** @var User $user */
//            $user = User::query()->where('phone', $request->phone)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => __('messagesWhatsapp.number_invalid')
                ], Response::HTTP_NOT_FOUND);
            }

            if ($phone != $request->code) {
                return response()->json([
                    'success' => false,
                    'message' => __('messagesWhatsapp.code_invalid')
                ], Response::HTTP_NOT_FOUND);
            }

            $user->phone_verified_at = now();
            $response = $user->update();

            if ($response) {
                Cache::tags("verificatePhoneWhatsApp")->forget($request->phone);

                return response()->json([
                    'success' => true,
                    'message' => __('messagesWhatsapp.ok')
                ]);
            }

        }

        return response()->json([
            'success' => false,
            'message' => __('messagesWhatsapp.not_code_generated')
        ], Response::HTTP_CONFLICT);
    }

    public function listDoc(): JsonResponse
    {
        return response()->json([
            '1' => 'CC',
            '2' => 'CE',
        ]);
    }


}
