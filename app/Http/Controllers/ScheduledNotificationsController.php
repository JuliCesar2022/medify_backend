<?php

namespace App\Http\Controllers;


use App\Models\ScheduledNotifications;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class ScheduledNotificationsController extends Controller
{
    static $module_name = "notificaciones";

    function index(){


        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        $services = ScheduledNotifications::latest()->paginate(20);


        $module_name = self::$module_name;

        $indexs = array_keys(ScheduledNotifications::$columns);
        $columns = (ScheduledNotifications::$columns);


        $indexs = array_intersect($indexs, [ "title", "description", "delay", "dayOfWeek", "unique", "hour", "country_id","date" ]);

        return view('Modules/Services/index_data',compact('services','indexs','columns','module_name'));

    }

    function from(){

        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        $sessionToken = \App\Http\Repositories\SessionTokensController::getSessionToken();
        $HOST_EXTERNAL_BACK = env('HOST_EXTERNAL_BACK');

        $module_name = self::$module_name;
        $edit = false;

        return view('Modules/notify/create',compact('sessionToken','HOST_EXTERNAL_BACK','module_name','edit'));

    }



    function save(){


        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        if(Request("update_one")){
            $Service = ScheduledNotifications::where("_id",Request("update_one"))->first();
        }else{
            $Service = new ScheduledNotifications();
        }

        $Service->title = Request("title");
        $Service->description = Request("description");
        $Service->hour = Request("hour");
        $Service->delay = Request("delay");
        $Service->dayOfWeek = Request("dayOfWeek");
        $Service->unique = Request("unique") == "Si"?true:false;
        $Service->date = Request("date");

        $Service->country_id = Request("country_id");

        return redirect('./notificaciones?success=1');

    }

    function delete($id){

        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        ScheduledNotifications::where("_id",$id)->delete();

        return redirect('./notificaciones?delete=1');

    }

    function update($id){

//        if(!CRUDBooster::myPrivilegeId()){
//            return redirect('../');
//        }
//
//        $service = ScheduledNotifications::where("_id",$id)->first();
//
//        if(!$service){
//            return redirect('../');
//        }
//
//        $update = $id;
//        $module_name = self::$module_name;
//        $columns = (ScheduledNotifications::$columns);
//        $indexs = [
//
//            "title" => $service->title,
//            "description" => $service->description,
//            "hour" => $service->service_title,
//            "delay" => $service->delay,
//            "dayOfWeek" => $service->dayOfWeek,
//            "unique" => $service->unique == true?"Si":"No",
//            "date"=>$service->date,
//
//        ];

        if(!CRUDBooster::myPrivilegeId()){
            return redirect('../');
        }

        $service = ScheduledNotifications::where("_id",$id)->first();

        $sessionToken = \App\Http\Repositories\SessionTokensController::getSessionToken();
        $HOST_EXTERNAL_BACK = env('HOST_EXTERNAL_BACK');

        $module_name = self::$module_name;

        $defaulValues = $service;
        $edit = true;

//        dd($defaulValues);

        return view('Modules/notify/create',compact('sessionToken','HOST_EXTERNAL_BACK','module_name','defaulValues','edit','id'));

    }

    function detail($id){

        $service = ScheduledNotifications::find($id)->toArray();
        $module_name = self::$module_name;
        $indexs = array_keys(ScheduledNotifications::$columns);
        $columns = (ScheduledNotifications::$columns);
        return view("Modules/Services/detail",compact('service','indexs','columns','module_name'));

    }


}
