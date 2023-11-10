<?php

namespace App\Http\Controllers\Api;
use App\Http\Repositories\SynchronizeUser\SynchronizeUser;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use App\Console\Commands\MigrateCredentials;
use App\Http\Repositories\ProfessionsDetail\ProfessionDetail;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginByPhoneRequest;
use App\Models\User;
use App\Traits\HelpersAdmin;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Repositories\CodigosVerificacion;
use App\Http\Repositories\ApiWhatsApp\ApiWhasApp;

class AuthController extends Controller
{
    use HelpersAdmin;


    public function login(LoginRequest $request): JsonResponse
    {
        // dd($request);
        $http = new Client;
        try {

            $user = User::query()->where('email', $request->username)->first();

          
                
                $response = $http->post(config('services.passport.login_endpoint'), [
                    'form_params' => [
                        'grant_type' => 'password',
                        'username' => $request->username,   
                        'password' => $request->password,
                        'client_id' => config('services.passport.client_id'),
                        'client_secret' => config('services.passport.client_secret'),
                        
                    ],

                    
                ]); 

                



                
                return response()->json([
                    'success' => true,
                    'data' => json_decode((string)$response->getBody(), true),
                    'user' => $user->makeHidden(['deleted_at'])

                ]);
         
        } catch (BadResponseException $e) {

            if ($e->getCode() === 400) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid Request. Please enter a username or a password.'], $e->getCode());
            }

            if ($e->getCode() === 401) {
                return response()->json([
                    'success' => false,
                    'error' => 'Your credentials are incorrect. Please try again'], $e->getCode());
            }

            return response()->json([
                'success' => false,
                'error' => 'Something went wrong on the server.'], $e->getMessage());
        }
    }

    public function refresh(Request $request)
    {
        $http = new Client;
        try {

            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'refresh_token' => $request->refresh_token
                ]
            ]);

           

            return json_decode((string)$response->getBody(), true);

        } catch (BadResponseException $e) {

            if ($e->getCode() === 400) {
                return response()->json([
                    'success' => false,
                    'Invalid Request. Please enter a username or a password.'], $e->getCode());
            }

            if ($e->getCode() === 401) {
                return response()->json([
                    'success' => false,
                    'The refresh token is invalid. Please try again'], $e->getCode());
            }

            return response()->json([

                'success' => false,
                'Something went wrong on the server.'], $e->getCode());
        }
    }

    public function sendResetLinkEmail(Request $request)
    {

        $request->validate(['email' => 'required|email']);
        try {

            $verificar = User::where('email', $request->email)->first();

            if (!$verificar) {

                return response()->json([
                    'success' => false,
                    'data' => '¡El usuario no existe!'
                ], 422);


            } else {

                $status = Password::sendResetLink(
                    $request->only('email')
                );

                return response()->json([
                    'success' => true,
                    'data' => '¡Te hemos enviado por correo el enlace para restablecer tu contraseña!'
                ], 200);

            }


        } catch (Exception $exception) {

            return response()->json([
                'success' => false,
                'data' => $exception->getMessage()], 500);

        }
    }

    protected function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return response()->json([
            'success' => $status == Password::PASSWORD_RESET,
        ], 200);
    }

    public function ping()
    {
        return response()->json([
            'success' => true,
            'data' => 'ok'
        ], 200);
    }

   
}
