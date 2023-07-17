<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Dispositivo extends Model
{
    protected $table='dispositivo';
    protected $fillable = ['nombre', 'ip','mac','comando','id_grupo', 'id_sistema', 'id_ubicacion', 'id_categoria', 'id_periodo'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
