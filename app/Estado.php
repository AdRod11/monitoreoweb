<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Estado extends Model
{
    protected $table='estado';
    protected $fillable = ['descripcion'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
