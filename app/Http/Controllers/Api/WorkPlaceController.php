<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkPlaceRequest;
use App\Models\WorkPlaceModel;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class WorkPlaceController extends Controller
{


    function save(WorkPlaceRequest $request)
    {

        try {
            $workPlace = WorkPlaceModel::where("user_id", $request->user_id)->first();


            $new = false;
            if($workPlace == null){
                $workPlace = new WorkPlaceModel();
                $new = true;
            }

            $workPlace->countri_id = $request->countri_id;
            $workPlace->departament_id = $request->departament_id;
            $workPlace->municipality_id = $request->municipality_id;
            $workPlace->user_id = $request->user_id;


            if($new) {
                $workPlace->save();


            }else{
                $workPlace->update();

            }

            return response()->json([
                'success' => true,
                'message' => "Ok.",
                'data'=>  WorkPlaceModel::where("user_id", $request->user_id)->first()
            ]);
        }catch (Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }



    }


}
