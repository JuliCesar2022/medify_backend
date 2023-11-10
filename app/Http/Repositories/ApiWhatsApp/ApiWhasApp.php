<?php

namespace App\Http\Repositories\ApiWhatsApp;
use Illuminate\Support\Facades\Http;

use App\Models\ConfigModel;
use Illuminate\Support\Facades\Log;
//use const http\Client\Curl\Features\HTTP2;
//use Illuminate\Support\Facades\Http;

class ApiWhasApp
{
    static public function senMessage($phone, $message){


//        Log::debug('senMessage' );
        $HostBotWhatsApp = ConfigModel::where('name','HostBotWhatsApp')->first();
        $token = ConfigModel::where('name','TokenWebhook')->first();

        Log::debug('senMessage | send: ' .$HostBotWhatsApp->value.'/send  '. $phone."   #   ".$message );
        try {

            $resp = json_decode(Http::post($HostBotWhatsApp->value."/send", [
                "token"=>$token->value,
                "phone"=>$phone,
                "message"=>$message,
            ]))->data;

//            return $resp;

//            $curl = curl_init();
//
//            curl_setopt_array($curl, array(
//                CURLOPT_URL => $HostBotWhatsApp->value."/send",
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => '',
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 0,
//                CURLOPT_FOLLOWLOCATION => true,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => 'POST',
//                CURLOPT_POSTFIELDS => `{
//                    "token":"$token->value",
//                    "phone":".$phone.",
//                    "message":"$message"
//                }`,
////                CURLOPT_POSTFIELDS => json_encode(array(
////                    "token"=>$token->value,
////                    "message"=>$message,
////                    "phone"=>$phone
////                )),
//                CURLOPT_HTTPHEADER => array(
//                    'Accept: application/json',
//                    'Content-Type: application/json'
//                ),
//            ));
//
//            $response = curl_exec($curl);
//            Log::debug($response);
//
////            dd($response);
//            curl_close($curl);

            return true;
        }catch (\Exception $exception){
            return false;
        }


    }
}
