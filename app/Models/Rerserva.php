<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rerserva extends Model
{
    protected $fillable = [
        'costo',
        'fecha',
        'hora',
        'id_trabajador',
        'id_user',
        'id_habitacion',
    ];

    public function trabajador(){
        return $this->belongsTo(Trabajador::class,'id_trabajador'); 
    }

    public function user(){
        return $this->belongsTo(User::class,'id_user'); 
    }

    public function habitacion(){
        return $this->belongsTo(Habitacion::class,'id_habitacion'); 
    }

    public function toShow(){
        return[
            'id'    => $this->id,
            'costo' => $this->costo,
            'fecha'=> $this->fecha,
            'hora'=> $this->hora,
            'trabajador'=> $this->trabajador->nombre,
            'user'=> $this->user->username,
            'habitacion'=> $this->habitacion->numero,

        ];
    }

}
