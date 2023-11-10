<?php
//
//namespace App\Models;
//
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//
//class UserCopy extends Model
//{
//    use HasFactory;
//}
//

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

//use Illuminate\Database\Eloquent\Model;

class UserCopy extends Model
{
    protected $connection = 'mongodb';

    public $timestamps = false;
    protected $table = "UserCopy";

}
