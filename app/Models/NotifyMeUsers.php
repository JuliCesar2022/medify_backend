<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class NotifyMeUsers extends Model
{
    use SoftDeletes,HybridRelations;

    protected $connection = 'mongodb';
    protected $table = 'notifyMeOrders';
}
