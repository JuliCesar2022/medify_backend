<?php

namespace App\Http\Repositories\synchronizeUser;
use App\Models\User;
use App\Models\UserCopy;


class SynchronizeUser
{


    static function synByUserID($userID)
    {

        $datatSelect = \Illuminate\Support\Facades\DB::connection("mongodb");
        $user = $datatSelect->table('UserCopy')->where('id',$userID)->delete();

        $user = User::where('id',$userID)->first();
        UserCopy::insert($user->toArray());

        return true;

        
    }


}
