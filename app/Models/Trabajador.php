<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'sueldo',
        'fecha_contrato',
    ];
}
