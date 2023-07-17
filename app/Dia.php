<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Dia extends Model
{
    protected $table='dia';
    protected $fillable = ['descripcion'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
