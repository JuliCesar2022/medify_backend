<?php

namespace App\Http\Repositories\Firebase;

use App\Models\User;
use App\Models\NotifyMeUsers;

class Firebase
{

    // static function captureFcmToken($fcmToken, $username)
    // {
    //     $usuario = User::where('email', $username)->first();
    //     $usuario->fcm_token = $fcmToken;
    //     $usuario->save();
    // }


    static function sendNotificationById($id, $title = "Nuevo servicio.", $body = "Abrir para mas informacion", $request = '{}', $tipo = 'comun')
    {
        $fcmToken = NotifyMeUsers::where('userID',(int)$id)->first()->firebase_token;

        self::sendNotification($fcmToken,$title,$body,$request,$tipo);
    }


    static function sendNotification($fcmToken, $title = "Nuevo servicio.", $body = "Abrir para mas informacion", $request = '{}', $tipo = 'comun')
    
    {

        // dd($fcmToken);
        try {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "rules_version": "2",
                    "notification": {
                        "body": "' . $body . '",
                        "title": "' . $title . '"
                    },
                    "priority": "high",
                    "data": {
                        "click_action": "FLUTTER_NOTIFICATION_CLICK",
                        "body": "' . $body . '",
                        "title": "' . $title . '",
                        "data": {},
                        "tipo":"' . $tipo . '"
                    },
                    "to": "' . $fcmToken . '"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key=' . env('FIREBASE_TOKEN', 'AAAAC_DtIUM:APA91bHjVJSYtQLMpcFKV_b0Xtl0oCKK3FV_Kyob4mQEuT8W1f2-AAQVIVAlSMI1m8xOQLNmpmVW_slOftOMtWh9bYZJZ-_Q7lAmtCdF_XA067lYNQM0V1Um9IZlmnN9ZOy5nMs3PxeG'),
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            // dd($response);

//            echo $response;
//            echo $request;

//            dd($response);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
