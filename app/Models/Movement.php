<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * @property string $type
 * @property string $table_ref
 * @property string $reason
 * @property int $amount
 * @property int $current_balance
 * @property int $technical_id
 */
class Movement extends Model
{
    use HasFactory, SoftDeletes, HybridRelations;

    protected $connection = 'mongodb';
    protected $table = "movements";
}
