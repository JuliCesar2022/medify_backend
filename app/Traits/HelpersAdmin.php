<?php

namespace App\Traits;

use App\Http\Repositories\ApiWhatsApp\ApiWhasApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait HelpersAdmin
{

    public function sendSMSWhatsApp(int $number, string $text):bool
    {
//        Log::debug('sendSMSWhatsApp' );


        return ApiWhasApp::senMessage($number,$text);

//        return Http::withToken(env('TOKEN_FACEBOOK'))
//            ->post(
//                env('URL_FACEBOOK'),
//                [
//                    "messaging_product" => "whatsapp",
//                    "recipient_type" => "individual",
//                    "to" => $number,
//                    "type" => "text",
//                    "text" => [
//                        "body" => $text
//                    ]
//                ]
//            );
    }

}

Validator::extend('not_exists', function ($attribute, $value, $parameters) {
    return ! DB::table($parameters[0])
            ->where($parameters[1], '=', (string)$value)
            ->count()<1;
});
