<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class ConfigModel extends Model
{
    use HasFactory, SoftDeletes,HybridRelations;

    protected $connection = 'mongodb';

    protected $table = 'Config';
}
