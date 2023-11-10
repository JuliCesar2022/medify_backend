<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
//use Illuminate\Database\Eloquent\Model;

class DetailPofession extends Model
{
    protected $connection = 'mongodb';

    public $timestamps = false;
    protected $table = "professions_technical_details";

}
