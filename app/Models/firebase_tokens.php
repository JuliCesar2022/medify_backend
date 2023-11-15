<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class firebase_tokens extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'firebase_tokens';
}
