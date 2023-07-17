<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table='tipo_servicio';
    protected $fillable = ['descripcion',];
    protected $guarded = ['id'];
    public $timestamps  = false;


}
