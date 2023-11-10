<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


/**
 * @property string $technical_id
 * @property mixed $fecha
 * @property mixed $text_response
 * @property mixed $title_response
 * @property mixed $transaction_id
 * @property mixed $amount
 * @property string $urlbanco
 * @property mixed $factura
 * @property string $status
 * @property mixed $data
 * @property string $type
 * @property bool $accepted_transaction
 */
class Payment extends Model
{
    use HasFactory, SoftDeletes, HybridRelations;

    protected $connection = 'mongodb';

    protected $table = 'payments';
    protected $dates = ['deleted_at'];


    const StatusTypeEpayco = 'Epayco';
    const StatusTypePaypal = 'Paypal';
    /**
     * @var int|mixed|string|null
     */
    public $technical_id;

    protected $primaryKey = '_id';
    protected $fillable = ['id', 'transaction_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
