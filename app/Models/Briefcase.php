<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * @property int $technical_id
 * @property int $current_amount
 * @method static currentAmount()
 */
class Briefcase extends Model
{
    use HasFactory, SoftDeletes, HybridRelations;

    protected $connection = 'mongodb';

    protected $table = 'briefcases';
    protected $dates = ['deleted_at'];


    public function scopeCurrentAmount($query)
    {
        return $query->where('technical_id', Auth::id())->first(['current_amount']);
    }
}
