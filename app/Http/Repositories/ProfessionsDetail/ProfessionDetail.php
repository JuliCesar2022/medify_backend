<?php

namespace App\Http\Repositories\ProfessionsDetail;

use App\Models\DetailPofession;
use App\Models\Professions;
use http\Env\Request;
use http\Env\Response;

class ProfessionDetail
{

    static function setMyProsession($tecnicoID,$newList):bool{

        DetailPofession::where('technical_id',$tecnicoID)->delete();

        foreach ($newList as $e){
           $profesion = new DetailPofession();
            $profesion->technical_id = (string)$tecnicoID;
            $profesion->profession_id = $e;
            $profesion->save();
        }

        return true;
    }

    static function getMyProfession($tecnicoID){

        $finalData = [];
        $myProfessions = DetailPofession::where('technical_id',(string)$tecnicoID)->get();
        foreach ($myProfessions as $e){
            $profession = Professions::where('_id',$e->profession_id)->select('_id','name','slug_name')->first();
           if( $profession ) array_push($finalData,$profession);
        }

        return $finalData;

    }

}
