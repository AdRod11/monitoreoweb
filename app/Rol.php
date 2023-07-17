<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Rol extends Model
{
    protected $table='rol';
    protected $fillable = ['descripcion'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
