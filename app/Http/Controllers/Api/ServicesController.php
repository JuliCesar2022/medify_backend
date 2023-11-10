<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Firebase\Firebase;
use App\Http\Repositories\Wallet\WalletController;
use App\Http\Requests\AssignWorkRequest;
use App\Http\Requests\ToCanselServicesRequest;
use App\Models\Customers;
use App\Models\Movement;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\Response;
use \App\Http\Repositories\ApiWhatsApp\ApiWhasApp;

class ServicesController extends Controller
{

   static public function assignWork(AssignWorkRequest $request): JsonResponse
    {

        try {

            $service = Service::where('_id', $request->service_id)->first();

            if($service){

                if($service->technical_id == null ||$service->technical_id == "0" || $service->technical_id == 0 || $service->technical_id == ""){


                    $serviceInProgress = self::getServiceInProgress( $request->user_id);

                    if($serviceInProgress){
                        return response()->json([
                            'success' => false,
                            'message' => "Ya tiene un servicio en curso.",
                            'data'=>$serviceInProgress
                        ]);
                    }

                    $service->technical_id = $request->user_id;
                    $service->status = Service::ASSIGNED;

                    if($service->revenue == 0){
                        $discount = 0;
                    }else{
                        $discount = $service->amount * ( intval($service->revenue??Service::DiscountRate) / 100 );
                    }





                    $resp = WalletController::make($request->user_id, $discount,WalletController::OUT,"Descuento del servicio: ".$request->service_id );

                    if($resp['success']){

                        $service->save();

                        $tecnico = User::where('id',$request->user_id)->first();
                        $customer = Customers::where('id',$service->client_id)->first();
                        ApiWhasApp::senMessage($customer->number_phone,"Hola $customer->name! Te informamos que el tecnico ".$tecnico->name." ".$tecnico->last_name." es responsable su servicio.");

                        ApiWhasApp::senMessage($customer->number_phone,"Telefono del tecnico: +".$tecnico->country_code.$tecnico->phone);

                        ApiWhasApp::senMessage($customer->number_phone,"Para asegurar tu seguridad, te recordamos que todas las contrataciones deben efectuarse a través de nuestro servicio de WhatsApp. *No se deben realizar acuerdos directamente con el técnico.* Puedes confiar en nosotros para obtener una experiencia segura y de alta calidad con garantía.");


                        return response()->json([
                            'success' => true,
                            'message' => 'Servicio Seleccionado exitosamente'
                        ]);

                    }

                    if(!$resp['success']){

                        return response()->json([
                            'success' => false,
                            'message' => $resp['message']
                        ]);

                    }





                }else{
                    return response()->json([
                        'success' => false,
                        'message' => "El servicio ya esta asignado"
                    ]);
                }

            }

            if($service == null){

                return response()->json([
                    'success' => false,
                    'message' => "Esta orden no existe."
                ]);

            }


        } catch (Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => "El servicio ya esta asignado"
            ]);

        }

        return response()->json([
            'success' => false,
            'message' => "ERROR INTERNO"
        ]);

    }


    public static function getServiceInProgress($UserID){

        $service = Service::where('technical_id',$UserID)->where("status",Service::ASSIGNED)->join('customers', 'client_id', '=', 'customers.id')->first();
        return $service;

    }

    public static function  getMyLastService($UserID){

        try{

            $serviceInProgress = self::getServiceInProgress( $UserID );

            if( $serviceInProgress == null ){
                return response()->json([
                    'success' => true,
                    'in_progess'=>false,
                    'message' => "No tienes ningun servicio en progreso.",
                    "data"=>null
                ]);
            }

           $customer = Customers::where('id',$serviceInProgress->client_id)->first();
           $location = [
              "departamento" => DB::table('departamentos')->where('id',$serviceInProgress->department_id)->first()->departamento,
              "municipio" => DB::table('municipios')->where('id',$serviceInProgress->municipality_id)->first()->municipio,
           ];

//            dd($customer);
            return response()->json([
                'success' => true,
                'in_progess'=>true,
                'message' => "Tienes un servicio en progreso.",
                "data"=>["service"=>$serviceInProgress,"client"=>$customer, "location"=>$location]
            ]);
        } catch (Exception $exception) {
            return response()->json([
            'success' => false,
            'message' => "Error interno"
            ]);
        }
    }

    public static function toEndService( $ServicesID ){

        try{

            $service = Service::where("_id",$ServicesID)->first();

            if($service == null ){
                return response()->json([
                    'success' => false,
                    'message' => "Este servicio no existe o no te pertenece."
                ]);
            }

            $service->status =  Service::FINISHED;
            $service->finish_date = now();
            $service->save();


            $customer = Customers::where('id',$service->client_id)->first();

            $msj = "¿Cómo calificarías del 1 al 5 la calidad del servicio ofrecido por el tecnico?

1. Muy insatisfecho/a :(
2. Insatisfecho/a
3. Neutral
4. Satisfecho/a
5. Muy satisfecho/a 😊

Escribe solo el número que aparece al inicio de la opción de tu interés!";



            ApiWhasApp::senMessage($customer->number_phone,$msj);


//            ApiWhasApp::senMessage($customer->number_phone,$msj);
            Cache::tags("rate_service")->put($service->id, true, now()->addMinute(360));


            return response()->json([
                'success' => true,
                'message' => "Servicio finalizado correctamente."
            ]);

        } catch (Exception $exception) {
            return response()->json([
            'success' => false,
            'message' => "Error interno"
            ]);
        }

    }


    public static function toCanselService(ToCanselServicesRequest $request ){

        try{

            $service = Service::where("_id",$request->service_id)->first();

            if($service == null ){
                return response()->json([
                    'success' => false,
                    'message' => "Este servicio no existe o no te pertenece."
                ]);
            }

            if($service->status == Service::FINISHED ){
                return response()->json([
                    'success' => false,
                    'message' => "No es pocible canselar un servicio finalizado."
                ]);
            }


            if($service->status == Service::DECLINED ){
                return response()->json([
                    'success' => false,
                    'message' => "Este servicio ya esta canselado."
                ]);
            }

            $service->status =  Service::DECLINED;
            $service->finish_date = now();
            $service->cancellation_reason = $request->cancellation_reason;
            $service->save();

            return response()->json([
                'success' => true,
                'message' => "Servicio cancelado correctamente."
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Error interno"
            ]);
        }

    }



    static function getHistoryByID($technical_id){

        try {

            $moviments = Service::where('technical_id', $technical_id )->latest()->paginate(10);

            return response()->json([
                'success' => true,
                'message' => "OK",
                'data'=>$moviments
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Error interno"
            ]);
        }

    }
 }
