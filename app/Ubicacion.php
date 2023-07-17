<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Ubicacion extends Model
{
    protected $table='ubicacion';
    protected $fillable = ['descripcion','lugar'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
