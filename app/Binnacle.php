<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Binnacle extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table='bitacora';
    protected $fillable = [
        'token','id_usuario','fecha_inicio','fecha_fin',
    ];
    protected $guarded = ['id'];
    public $timestamps  = false;

}
