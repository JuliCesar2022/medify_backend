<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Service extends Model
{
    const DiscountRate = 10;


    const CREATED = 'CREATED';
    const ASSIGNED = 'ASSIGNED';
    const FINISHED = 'FINISHED';
    const DECLINED = 'DECLINED';
    const STATUS_ERROR = 'ERROR';

    static $columns = [
        "client_id" => ["type"=>"select","table"=>"customers,name","label"=>"Cliente", "required"=>true,"href"=>"customers"],
        "technical_id" => ["type"=>"select","table"=>"users,name","label"=>"Tecnico","href"=>"usersApp"],
        "profession_id" => ["type"=>"select","table"=>"professions,name","label"=>"Profesion","mongo"=>true, "required"=>true],
        "amount" => ["type"=>"money","label"=>"Costo", "required"=>true],
        "status" => [ "type" => "enum", "data"=>['CREATED','ASSIGNED', 'FINISHED', 'DECLINED', 'ERROR'],"label"=>"Estado"],
        "is_public" => [ "type" => "enum", "data"=>['Si','No'], "label"=>"Publico"],
        "start_date" => ["type"=>"date","label"=>"Fecha de inicio"],
        "last_update_status" => ["type"=>"data","label"=>"Ultima vez"],
        "finish_date" => ["type"=>"date","label"=>"Fecha de inicio"],
        "district" => ["type"=>"text","label"=>"Distrito", "required"=>true],
        "direccion" => ["type"=>"textarea","label"=>"direccion", "required"=>true],
        "referencia" => ["type"=>"textarea","label"=>"referencia"],
        "latitude" => ["type"=>"number","label"=>"Latitud"],
        "longitude" => ["type"=>"number","label"=>"Longitud"],

        "revenue" => ["type"=>"text","label"=>"Ganancia"],

        "country_id" => ["type"=>"select","table"=>"countries,name","label"=>"Pais","mongo"=>true, "required"=>true],
        "department_id" => ["type"=>"select","table"=>"departments,name","label"=>"Departamento","mongo"=>true, "required"=>true],
        "municipality_id" => ["type"=>"select","table"=>"municipalities,name","label"=>"Municipio","mongo"=>true, "required"=>true],
        "service_title" => [ "type" => "text", "label"=>"Titulo" , "required"=>true],
        "service_description" => [ "type" => "textarea", "label"=>"Descripcion detallada" , "required"=>true],
        "public_description" => [ "type" => "textarea", "label"=>"Descripcion general", "required"=>true ],
        "cancelled" => [ "type" => "enum", "data"=>['CLIENT', 'TECNICO', 'SOPORT', 'OTHER'], "label"=>"Tipo de cancelación"],
        "cancellation_reason" => [ "type" => "textarea", "label"=>"Rason de cancelación" ],
        "scheduled_date" => [ "type" => "date", "label"=>"Fecha agendada" ],
        "scheduled_time" => [ "type" => "time", "label"=>"Hora agendada" ],
    ];

    static $Buttoms = [

    ];

    use HasFactory, SoftDeletes, HybridRelations;

    protected $connection = 'mongodb';

    protected $table = 'services';
    protected $dates = ['deleted_at'];

    protected $primaryKey = '_id';
    protected $fillable = ['id'];
}


