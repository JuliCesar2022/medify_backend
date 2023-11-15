<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\MonthlyValueController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RegistroController;
use App\Http\Controllers\ChangeNumerController;
use App\Http\Controllers\Api\ProfessionsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\medicamento;
use App\Http\Controllers\UpdateUser;
use App\Models\Briefcase;
use App\Models\ConfigModel;
use App\Models\Movement;
use App\Models\User;
use Laravel\Passport\Token;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeailProfessionController;
use \App\Http\Controllers\Api\GeneratePaymentLink;
use \App\Http\Repositories\ApiWhatsApp\ApiWhasApp;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::prefix('v1')->group(function () {


    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/user', [UserController::class, 'store']);
    
    Route::get('/mail',function(){
        Mail::to('julioabonae@gmail.com')->send(new CodeVerification);
        return "";
    });
    
    
    Route::middleware('auth:api')->group(function () {
        
        Route::post('/medicamento', [medicamento::class, 'store']);
        Route::get('/medicamento', [medicamento::class, 'index']);
        

        Route::post('/logout', function (Request $request) {
            // Obtener el usuario autenticado
            $user = Auth::guard('api')->user();
        
        
                $request->user()->token()->revoke();
                
      
        
            
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ], 200);
        });
        
         


    });

});
