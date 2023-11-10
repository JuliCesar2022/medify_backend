<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class ScheduledNotifications extends Model
{

    protected $connection = 'mongodb';
    protected $table = "scheduled_notifications";

    static $columns = [
        "title"        => ["type"=>"textarea","label"=>"Titulo", "required"=>false],
        "description" => ["type"=>"textarea","label"=>"Descripcion", "required"=>false],
        "delay"       => ["type"=>"text","label"=>"Delay", "required"=>false],
        "dayOfWeek"   => ["type"=>"text","label"=>"Dia de la semana", "required"=>false],
        "unique"      => [ "type" => "enum", "data"=>['Si','No'], "label"=>"Unico"],
        "hour"        => [ "type" => "enum", "data"=>['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'], "label"=>"Hora"],
        "country_id"  => ["type"=>"select","table"=>"countries,name","label"=>"Pais","mongo"=>true, "required"=>false],
        "date"        => ["type"=>"date","label"=>"Fecha", "required"=>false],

    ];

    static $Buttoms = [

    ];


}
