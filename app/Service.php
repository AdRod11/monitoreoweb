<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table='servicio';
    protected $fillable = ['nombre', 'descripcion','id_comando','id_tipo_servicio'];
    protected $guarded = ['id'];
    public $timestamps  = false;

}
