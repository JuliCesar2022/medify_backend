<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class SessionTokenModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $table = 'session_tokens';

}
