<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $promo_code
 * @property int $value
 * @property string $name
 */
class MonthlyValue extends Model
{
    use HasFactory;
    protected $table = "monthly_values";

    protected $fillable = [
        'id'
    ];
}
