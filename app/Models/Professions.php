<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Professions extends Model
{

    protected $connection = 'mongodb';
    protected $table = 'professions';

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'slug_name',
        'status'
    ];

    protected $hidden = [];
}
