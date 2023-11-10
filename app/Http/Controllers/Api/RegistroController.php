<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Repositories\ProfessionsDetail\ProfessionDetail;
use App\Http\Repositories\SynchronizeUser\SynchronizeUser;
use App\Http\Repositories\Wallet\WalletController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{

    private static function store(Request $request): JsonResponse
    {

        $user = User::where( 'id', Auth::user()->id )->first();

        if($user){
 
            if($request->photo_profile){
                $photoProfile = $request->photo_profile->store('profile');
                $user->photo_profile = $photoProfile;
            }
            
            if($request->face_card_one){
                $faceCardOne = $request->face_card_one->store('profile');
                $user->face_card_one = $faceCardOne;
            }

            if($request->face_card_two){
                $faceCardTwo = $request->face_card_two->store('profile');
                $user->face_card_two = $faceCardTwo;
            }
 

            if($request->name){ $user->name = $request->name; }
            if($request->last_name){ $user->last_name = $request->last_name; }
            if($request->email){ $user->email = $request->email; }
            if($request->email_aux){ $user->email_aux = $request->email_aux; }
            if($request->type_id){ $user->type_id = $request->type_id; }
            if($request->document){ $user->document = $request->document; }
            if($request->country_code){ $user->country_code = $request->country_code; }
            if($request->phone){ $user->phone = $request->phone; }
            if($request->address){ $user->address = $request->address; }
            if($request->type_blood){ $user->type_blood = $request->type_blood; }
            if($request->birthday){ $user->birthday = Carbon::parse($request->birthday); }
       
            $user->update();
            SynchronizeUser::synByUserID(Auth::user()->id);
            
            ProfessionDetail::setMyProsession($user->id, [$request->profession_id]);
            WalletController::make($user->id, 10000, WalletController::IN, "Bono de bienvenida.");

            return response()->json([
                     'success' => true,
                     'message' => "Usuario Actualizado!",
                     'data'=> User::where('id',Auth::user()->id)->first()
             ]);
 
        }
 
         return response()->json([
             'success' => false,
             'message' => "No se encontro el usuario"
         ], 404);
 
      
    }
   
}
