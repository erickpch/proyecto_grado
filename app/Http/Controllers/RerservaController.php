<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Rerserva;
use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RerservaController extends Controller
{
    public function index()
    {
        $datos = Rerserva::get();  

        $trabajadores = Trabajador::get();
        $usuarios= User::get();
        $habitaciones = Habitacion::get();
     
        $datos = $datos->map->toShow();
     
        return view("reserva.index",compact('datos','trabajadores','usuarios','habitaciones'));
    }

    public function store(Request $request)
    {

       try {
        $request->validate([
            'costo' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'id_trabajador' => 'required|exists:trabajadors,id',
            'id_user' => 'required|exists:users,id',
            'id_habitacion' => 'required|exists:habitacions,id',
        ], $this->rules);

        
        $nuevo = [
            "costo" => $request->costo,   
            "fecha" => $request->fecha,   
            "hora" => $request->hora,   
            "id_trabajador" => $request->id_trabajador,   
            "id_user" => $request->id_user,   
            "id_habitacion" => $request->id_habitacion 
        ];
   
        $nuevo = Rerserva::create($nuevo);
            
        } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
         
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
 
            return back()->with('error', $e->getMessage());
       }

        return redirect()->route('mostrar.reserva');
    }


    public function show(Rerserva $reserva)
    {
        //
    }


    public function update(Request $request)
    {
        
        try {
            $modificar = $request->validate([      
                'costo' => 'sometimes|numeric|min:0',
                'fecha' => 'sometimes|date',
                'hora' => 'sometimes|date_format:H:i',
                'id_trabajador' => 'sometimes|exists:trabajadors,id',
                'id_user' => 'sometimes|exists:users,id',
                'id_habitacion' => 'sometimes|exists:habitacions,id',  
            ], $this->rules);  

            $dato = Rerserva::find($request->id);
            
            $dato->update($modificar);
        } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
             dd($mensajes);
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
              dd($e->getMessage());
            return back()->with('error', $e->getMessage());
       }
        return redirect()->route('mostrar.reserva');
    }

    public function destroy(Request $request)
    {        
       
        $datos= Rerserva::find($request->inputIdEliminar);
        $datos->delete();
        return redirect()->route('mostrar.reserva');
    }

    private $rules = [
        'costo.required' => 'El costo es obligatorio.',
        'costo.numeric' => 'El costo debe ser un número.',
        'costo.min' => 'El costo no puede ser negativo.',
        'costo.max' => 'El costo excede el límite permitido.',

        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'Debe ingresar una fecha válida.',

        'hora.required' => 'La hora es obligatoria.',
        'hora.date_format' => 'Debe ingresar una hora válida en formato HH:MM.',

        'id_trabajador.required' => 'Debe seleccionar un trabajador.',
        'id_trabajador.exists' => 'El trabajador seleccionado no existe.',

        'id_user.required' => 'Debe seleccionar un usuario.',
        'id_user.exists' => 'El usuario seleccionado no existe.',

        'id_habitacion.required' => 'Debe seleccionar una habitación.',
        'id_habitacion.exists' => 'La habitación seleccionada no existe.',
    ];
}
