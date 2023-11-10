<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Cache;

class CodigosVerificacion
{

    static function generate($id, $tag)
    {
        $num_ale = rand(100000, 999999);
        Cache::tags($tag)->put($id, $num_ale, now()->addMinute(15));
        return $num_ale;
    }

    static function validar_codigo($key, $tag, $code)
    {
        if ($code != Cache::tags($tag)->get($key)) {
            return false;
        } else {
            Cache::tags($tag)->forget($key);
            return true;
        }
    }

}
