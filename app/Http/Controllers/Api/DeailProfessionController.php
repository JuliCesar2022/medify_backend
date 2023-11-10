<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProfessionsDetail\ProfessionDetail;
use App\Models\Professions;
use Illuminate\Http\Request;

class DeailProfessionController extends Controller
{
   static function getAll($tecnicoID){

        $profession = Professions::all(['name','slug_name']);

        return response()->json([
            'success' => true,
            'data' => [
                "Profession"=>$profession,
                "MyProfessions"=>ProfessionDetail::getMyProfession($tecnicoID),
            ]
        ]);

    }

   static function setMyProsession($tecnicoID){

       Request()->validate([
           'newList' => 'required',
       ]);

       $newList = Request()->newList;

       if(ProfessionDetail::setMyProsession($tecnicoID,$newList)){
           return self::getAll($tecnicoID);
       }else{
           return response()->json([
               'success' => false,
               'data' => null,
               'message'=>"Fallo en DeailProfessionController@setMyProsession"
           ]);
       }


   }
}
