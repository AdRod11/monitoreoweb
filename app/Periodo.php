<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Periodo extends Model
{
    protected $table='periodo';
    protected $fillable = ['id_dia'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
