<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = [ //todos los atributos usados para crear
        'nombre'
    ];
    protected $hidden = [ //todos los atributos que no queremos que traiga el get
        'created_at'
    ];
    

    public function toShow(){
        return [
            'nombre' => $this->name
        ];
    }
}
