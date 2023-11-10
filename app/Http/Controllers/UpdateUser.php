<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Models\UserCopy;
use App\Models\User;
use App\Http\Repositories\SynchronizeUser\SynchronizeUser;

class UpdateUser extends Controller
{
    public function update(UpdateUserRequest $request)
    {
       $user = User::where('id',$request->user_id)->first();
       if($user){

           if($request->photo_profile){
               $photoProfile = $request->photo_profile->store('profile');
               $user->photo_profile = $photoProfile;
           }

           if($request->email){ $user->email_aux = $request->email; }
        //    if($request->country_code){$user->country_code =  $request->country_code;}
//           if($request->phone){$user->phone =  $request->phone;}


           $user->update();

           SynchronizeUser::synByUserID($request->user_id);

           $user = User::where('id',$request->user_id)->first();

           return response()->json([
                    'success' => true,
                    'message' => __('messagesWhatsapp.ok'),
                    'data'=> $user
            ]);

       }

        return response()->json([
            'success' => false,
            'message' => "No se encontro el usuario"
        ], 404);

    }
}
