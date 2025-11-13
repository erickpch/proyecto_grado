<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitacion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'numero',
        'cantidad',
        'disponibilidad',
        'documento'
    ];
}
