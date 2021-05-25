<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //模型类成员，表、主键、时间戳
    protected $table='user';
    protected $primaryKey='user_id';
    public $timestamps=false;
}
