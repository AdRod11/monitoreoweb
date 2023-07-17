<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Historico extends Model
{
    protected $table='historico';
    protected $fillable = [
        'dispositivo','servicio','ip','fecha','estatus','mensaje',];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
