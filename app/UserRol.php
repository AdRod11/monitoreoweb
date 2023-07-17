<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserRol extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table='usuario_rol';
    protected $fillable = [
        'id_rol','id_usuario',
    ];
    protected $guarded = ['id'];
    public $timestamps  = false;

}
