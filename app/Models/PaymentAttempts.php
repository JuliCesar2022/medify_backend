<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class PaymentAttempts extends Model
{

    const POR_DEFINIR = "Por definir";
    const NO_PAGADO = "No pagado";
    const PAGADO = "Pagado";
    const PAGO_PENDIENTE = "Pago pendiente";
    const MULTIPLES_INTENTOS = "Multiples intentos";
    const FALLIDA = "Fallida";
    const RECHAZADA = "Rechazada";
    const ACEPTADA = "Aceptada";
    const APROBADA = "Aprobada";
    const ABANDONADA = "Abandonada";
    const CANCELADA = "Cancelada";
    const OTRO = "OTRO";

    protected $connection = 'mongodb';

    protected $table = 'paymentAttempts';

}
