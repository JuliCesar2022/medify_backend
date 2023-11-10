<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ServicesController;
use App\Http\Repositories\Firebase\Firebase;
use App\Http\Repositories\ProfessionsDetail\ProfessionDetail;
use App\Http\Requests\AssignWorkRequest;
use App\Models\NotifyMeUsers;
use App\Models\Service;
use App\Models\User;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServicesCurd extends Controller
{
   static $module_name = "services";

    function index(){


      if(!CRUDBooster::myPrivilegeId()){
          return redirect('../');
      }

      $services = Service::latest()->paginate(20);


      $module_name = self::$module_name;

      $indexs = array_keys(Service::$columns);
      $columns = (Service::$columns);

      $indexs = array_intersect($indexs, ["client_id","status","technical_id","profession_id","amount","service_title","district","scheduled_date","is_public","municipality_id","revenue" ]);

      return view('Modules/Services/index_data',compact('services','indexs','columns','module_name'));

    }

    function from(){

        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        $module_name = self::$module_name;
        $columns = (Service::$columns);
        $indexs = [

            "scheduled_date"=>"",
            "scheduled_time"=>"",
            "service_title"=>"",
            "public_description"=>"",
            "service_description"=>"",
            "client_id"=>"",
            "profession_id"=>"",
            "amount"=>"",
            "technical_id"=>"",
            "country_id"=>"649a02ec60043e9f434a94f8",
            "department_id"=>"649a030660043e9f434a94fa",
            "municipality_id"=>"649a034560043e9f434a94fe",
            "is_public"=>"Si",
            "district"=>"",
            "direccion"=>"",
            "referencia"=>"",
            "revenue"=> Service::DiscountRate,

        ];

        return view('Modules/Services/create',compact('indexs',"columns",'module_name'));

    }



    function save(){

        // Firebase::sendNotificationById(Request("technical_id"),"Nuevo servicio.",null,null,"ASING");


        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        if(Request("update_one")){
            $Service = Service::where("_id",Request("update_one"))->first();
        }else{
            $Service = new Service();
        }

        $Service->scheduled_date = Request("scheduled_date");
        $Service->scheduled_time = Request("scheduled_time");
        $Service->client_id = Request("client_id");
//        $Service->technical_id = Request("technical_id");
        $Service->profession_id =  Request("profession_id");
        $Service->amount = str_replace(".","",Request("amount"));

        $Service->is_public = Request("is_public") == "Si"?true:false;
        $Service->start_date = null;
        $Service->last_update_status = null;
        $Service->finish_date = null;
        $Service->district = Request("district");
        $Service->direccion = Request("direccion");
        $Service->referencia = Request("referencia");
        $Service->revenue = Request("revenue")??Service::DiscountRate;
        $Service->latitude = null;
        $Service->longitude = null;
        $Service->department_id = Request("department_id");
        $Service->municipality_id = Request("municipality_id");
        $Service->country_id = Request("country_id");
        $Service->service_title = Request("service_title");
        $Service->service_description = Request("service_description");
        $Service->public_description = Request("public_description");
        $Service->cancelled = null;
        $Service->cancellation_reason = null;


        if(Request("update_one")){

            $asig = false;
            if(Request("technical_id") == null || Request("technical_id") == "0" ){

                $Service->technical_id = null;
                $Service->status = Service::CREATED;
                $asig = false;

            }else{
                $asig = true;
            }

            $Service->update();

            if(!$asig){
                return redirect('./services?success=1');
            }


            $resp = json_decode(ServicesController::assignWork(new AssignWorkRequest([
                "user_id"=>Request("technical_id"),
                "service_id"=>$Service->id
            ]))->getContent()) ;

            if($resp->success){

                Firebase::sendNotificationById(Request("technical_id"),"Nuevo servicio.",null,null,"ASING");

                return redirect('./services?success=1');

            }else{

                return redirect('./services?success=3&message='.$resp->message);

            }




        }else{

           if(Request("technical_id") == null || Request("technical_id") == "0"){

                $Service->status = "CREATED";
                $Service->save();

                if(Request("is_public") == "Si"?true:false){

                    $usersToNotify = NotifyMeUsers::where('notyfyMe', true)->get();
                    $uniqueUsersToNotify = $usersToNotify->unique('userID');
                    $already = [];

                    $sessionToken = \App\Http\Repositories\SessionTokensController::getSessionToken();
                    $resp = Http::withHeaders([
                        'Authorization' => $sessionToken,
                    ])->post(env('HOST_EXTERNAL_BACK') . '/sendNotifyMany', [

                      "title"=> Request("service_title")." ~ $".Request("amount"),
                      "body"=> "Hola $[user_name];, tenemos un Nuevo servicio disponible para ti en ".Request("district"),
                      "profession_filter"=> [
                        Request("profession_id")
                      ],
                      "type"=>"NEW_SERVICES"

                    ]);
//                    dd($resp);



//                    foreach ($uniqueUsersToNotify as $user ){
//
//                        if($user){
//
////                            $profesions = ProfessionDetail::getMyProfession($user->userID);
//
////                            if(in_array( Request("profession_id"), array_column($profesions,'_id'))){
//                                Firebase::sendNotificationById($user->userID,  Request("service_title")." ~ $".Request("amount"), "Nuevo servicio disponible en ".Request("district"),null,"NEW_SERVICES");
////                            }
//
//                        }
//                    }

                }



               return redirect('./services?success=1');


           }else{

              $Service->status = Service::ASSIGNED;
              $Service->is_public = false;
              $Service->save();

              $resp = json_decode(ServicesController::assignWork(new AssignWorkRequest([
                  "user_id"=>Request("technical_id"),
                  "service_id"=>$Service->id
              ]))->getContent()) ;

              if($resp->success){
                Firebase::sendNotificationById(Request("technical_id"),"Nuevo servicio.",null,null,"ASING");
                return redirect('./services?success=1');
              }else{
                return redirect('./services?success=3&message='.$resp->message);
              }


           }

        }


    }

    function delete($id){

        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        Service::where("_id",$id)->delete();

        return redirect('./services?delete=1');

    }

    function update($id){

        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        $service = Service::where("_id",$id)->first();

        if(!$service){
            return redirect('../');
        }

        $update = $id;
        $module_name = self::$module_name;
        $columns = (Service::$columns);
        $indexs = [
            "scheduled_date" => $service->scheduled_date,
            "scheduled_time" => $service->scheduled_time,
            "service_title" => $service->service_title,
            "public_description" => $service->public_description,
            "service_description" => $service->service_description,
            "client_id" => $service->client_id,
            "profession_id" => $service->profession_id,
            "amount" => $service->amount,
            "technical_id" => $service->technical_id,
            "department_id" => $service->department_id,
            "municipality_id" => $service->municipality_id,
            "country_id" => $service->country_id,
            "is_public" => $service->is_public == true?"Si":"No",
            "district" => $service->district,
            "direccion" => $service->direccion,
            "referencia" => $service->referencia,
            "revenue" => $service->revenue,
        ];

        return view('Modules/Services/create',compact('indexs',"columns","update","module_name"));

    }

    function detail($id){

        $service = Service::find($id)->toArray();
        $module_name = self::$module_name;
        $indexs = array_keys(Service::$columns);
        $columns = (Service::$columns);
        return view("Modules/Services/detail",compact('service','indexs','columns','module_name'));

    }




}
