<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table='usuario';
    protected $fillable = [
        'usuario','contrasena','estatus','id_persona',
    ];
    protected $guarded = ['id'];
    public $timestamps  = false;

}
