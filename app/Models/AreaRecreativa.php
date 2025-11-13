<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaRecreativa extends Model
{
    use SoftDeletes;
    protected $fillable = [ //todos los atributos usados para crear
        'nombre'
    ];
}
