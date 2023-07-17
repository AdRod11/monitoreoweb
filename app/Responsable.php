<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Responsable extends Model
{
    protected $table='responsable';
    protected $fillable = ['id_persona','id_rol'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
