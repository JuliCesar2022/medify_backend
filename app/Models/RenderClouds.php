<?php

namespace App\Models;

//Mongodb
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class RenderClouds extends EloquentModel
{
    use SoftDeletes;
    //Mongodb
    protected $connection = 'mongodb';
    protected $collection = 'RenderClouds';

}
