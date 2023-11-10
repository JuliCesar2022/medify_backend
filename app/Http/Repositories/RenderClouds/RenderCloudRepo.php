<?php

namespace App\Http\Repositories\RenderClouds;

class RenderCloudRepo
{

    static  function ping(string $url):string
    {

        try {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url."/ping",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
//                dd($response);

            return $response;
        }catch (\Exception $exception){
            return $exception;
        }

    }
}
