<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Dispositivo_servicio extends Model
{
    protected $table='dispositivo_servicio';
    protected $fillable = ['id_dispositivo','id_servicio','id_estado','mensaje'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
