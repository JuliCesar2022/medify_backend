<?php

namespace App\Http\Controllers;

use App\Models\ConfigModel;
use App\Models\Customers;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Repositories\ApiWhatsApp\ApiWhasApp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ResponsesSystemBot extends Controller
{


    const hostPoe = "https://principalpoebot.onrender.com";
    static  function  whatsapp_webhook($phone, $message,$purge){
        Log::debug("###############whatsapp_webhook##################$phone $message");




        if(strlen($message) < 20){

            Log::debug("1");


            if(is_numeric($message[0])){

                $message = $message[0];

                Log::debug("2:".$message);

                if(strlen($message) == 1 && is_numeric($message)){

                    Log::debug("3");

                    try {

                        $customer = Customers::where('number_phone',strval($phone))->first();
                        if($customer){

                            Log::debug("cliente");
                            $service = Service::where('client_id',strval($customer->id))->where("status",Service::FINISHED)->latest()->first();

                            if($service){
                                Log::debug("servicio");

                                $value = Cache::tags("rate_service")->get($service->id);


                                if($value){

                                    Log::debug("sieee");

                                    if(((int)$message) > 5){

                                        self::rateService($service->id,"5");
                                        Cache::tags("rate_service")->forget($service->id);
                                        ApiWhasApp::senMessage($phone,"Listo! La calificación se estableció como 5.");
                                        ApiWhasApp::senMessage($phone,"Gracias por tu feedback 🤗.");

                                    }else if(((int)$message) < 0){

                                        self::rateService($service->id,"0");
                                        Cache::tags("rate_service")->forget($service->id);
                                        ApiWhasApp::senMessage($phone,"Listo! La calificación se estableció como 0.");
                                        ApiWhasApp::senMessage($phone,"Gracias por tu feedback 🤗.");

                                    }else{

                                        self::rateService($service->id,$message);
                                        Cache::tags("rate_service")->forget($service->id);
                                        ApiWhasApp::senMessage($phone,"Gracias por tu feedback 🤗.");

                                    }




                                }
                            }

                        }


                    }catch (\Exception $e){
                        Log::debug("ERROR". $e->getMessage());
                        ApiWhasApp::senMessage($phone,"Error 🥵");
                    }
                }



            }
        }




        return true;

    }


    static function executeAction($code = "void",$phone){

//        dd($code);
        switch ($code) {
            case "clear":
                self::sendGptMessage($phone,".",'purge',"2",true);
                ApiWhasApp::senMessage($phone,"El historial ha sido borrado con éxito.");

                break;


            case "need_call":

                ApiWhasApp::senMessage($phone,"Ha sido añadido a la cola de atención al cliente, prepárese para recibir una llamada 📞.");
                break;
        }

    }

    static function sendGptMessage($phone, $message,$method = "send",$botID="2", $purge = false): string {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::hostPoe."/".$method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "token"=>"1224",
                "message"=>$message,
                "phone"=>$phone,
                "purge"=>$purge,
//                "defaultProntID"=>$botID
            ]),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $resp = json_decode($response);
        if($method == "purge"){
            return "";
        }

//        dd($resp);

        return $resp->data->message;

    }

    static function  rateService($idService, $value){

        $token = ConfigModel::where('name','TokenWebhook')->first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('HOST_EXTERNAL_BACK').'/rate-service',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{

                "token":"'.$token->value.'",
                "service_id":"'.$idService.'",
                "value":"'.$value.'"

            }',

            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

//        dd($response);
        return true;
    }
}
