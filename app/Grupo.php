<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Grupo extends Model
{
    protected $table='grupo';
    protected $fillable = [
        'descripcion',];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
