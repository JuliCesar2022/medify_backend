<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class WorkPlaceModel extends EloquentModel
{

    protected $connection = 'mongodb';

    protected $table = 'technical_workplace';

}
