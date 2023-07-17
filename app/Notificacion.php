<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Notificacion extends Model
{
    protected $table='notificacion_personalizada';
    protected $fillable = [
        'id_responsable','id_grupo','fecha','dispositivo','mensaje','visto'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
