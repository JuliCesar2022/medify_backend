<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed $face_card_two
 * @property mixed $face_card_one
 * @property string $name
 * @property string $password
 * @property int $municipality_id
 * @property int $department_id
 * @property string $address
 * @property int $country_code
 * @property int $phone
 * @property int $document
 * @property int $type_id
 * @property string $email
 * @property string $last_name
 * @property mixed $photo_profile
 * @property mixed $birthday
 * @property string $type_blood
// * @property int $profession_id
 * @property string $id
 * @property string $phone_verified_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HybridRelations;

    const TECNICO = 'TECNICO';
    const CLIENTE = 'CLIENTE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected
        $fillable = [
        'nombre',
        'apellido',
        'email',
        'type_document_id',
        'number_document',
        'password',
        'photo_profile_url',
       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected
        $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected
        $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }
}
