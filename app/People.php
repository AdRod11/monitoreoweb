<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class People extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table='persona';
    protected $fillable = [
        'nombre','a_paterno','a_materno','curp','rfc','correo','telefono','domicilio',
    ];
    protected $guarded = ['id'];
    public $timestamps  = false;

}
