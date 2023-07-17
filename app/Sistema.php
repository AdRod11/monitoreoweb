<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Sistema extends Model
{
    protected $table='sistema';
    protected $fillable = ['nombre','version'];
    protected $guarded = ['id'];
    public $timestamps  = false;
}
