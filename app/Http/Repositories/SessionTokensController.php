<?php

namespace App\Http\Repositories;

use App\Models\SessionTokenModel;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\Request;

class SessionTokensController
{


    static function getSessionToken()
    {

        if ( CRUDBooster::myPrivilegeId() ) {

            $token = Request::ip() .":". $_SERVER['HTTP_USER_AGENT'] . ":" . $_COOKIE['laravel_session'] . ":". $_COOKIE['XSRF-TOKEN'];
            $session = SessionTokenModel::where("user_id", CRUDBooster::myId())->first();

            $new = false;
            if ($session == null) {
                $new = true;
                $session = new SessionTokenModel();
            }

            $session->session_token = $token;
            $session->isSuperadmin = CRUDBooster::isSuperadmin();
            $session->privilegeId = CRUDBooster::myPrivilegeId();
            $session->user_id = CRUDBooster::myId();

            if ($new) {
                $session->save();
            } else {
                $session->update();
            }
            return $token;
        }
        return null;
        // ¿        return ;
    }


}
