<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservaArea extends Model
{
    protected $fillable = [    
                    'id_reserva',
                    'hora'       , 
                    'cantidad'  ,  
                    'id_area'    ,
     ] ;           
}
