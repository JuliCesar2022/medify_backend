<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use App\Models\ConfigModel;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use League\Uri\Http;


class WhatsAppController extends Controller
{
    public function index()
    {

        if (CRUDBooster::isSuperadmin()){
            $HostBotWhatsApp = ConfigModel::where('name','HostBotWhatsApp')->first()->value;
            $requireScan = self::requireScan($HostBotWhatsApp);
            return view('WhatsApp/whatsapp',compact('requireScan','HostBotWhatsApp'));
        }
       return redirect('/admin');
    }

    static private function requireScan($url): bool{


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url.'/require-scan',
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

        $bool = $response == "true";

        return $bool;

    }






}
