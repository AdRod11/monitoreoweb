<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Responsable_dispositivo extends Model
{
    protected $table='responsable_dispositivo';
    protected $fillable = ['id_dispositivo','id_responsable'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
