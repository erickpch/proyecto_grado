<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HabitacionController extends Controller
{

    public function index()
    {
        $datos = Habitacion::get();  
  
        return view("habitacion.index",compact('datos'));
    }

    public function store(Request $request)
    {

       try {
        $request->validate([
            'numero' => 'required|integer|unique:habitacions',
            'cantidad' => 'required|integer|min:1',
            'disponibilidad' => 'required',
            'documento'  => 'sometimes|max:4096'

        ], $this->rules);

        if($request->file('documento')){
            $ubicacion = 'storage/'.$request->file('documento')->store('documentos','public');
           
        }
        
        $nuevo = [
            "numero" => $request->numero,
            "cantidad" => $request->cantidad,
            "disponibilidad" => $request->disponibilidad,
            "documento"     => $ubicacion    
        ];
   
            $nuevo = Habitacion::create($nuevo);
            
        } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
           
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
 
            return back()->with('error', $e->getMessage());
       }

        return redirect()->route('mostrar.habitacion');
    }


    public function show(Habitacion $habitacion)
    {
        //
    }


    public function update(Request $request)
    {

        
        try {
            $modificar = $request->validate([
                    'id'    =>  'required',
                    'numero' => 'required|integer',
                    'cantidad' => 'required|integer|min:1',
                    'disponibilidad' => 'required',            
                ], $this->rules);  

            $dato = Habitacion::find($request->id);
            
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
        return redirect()->route('mostrar.habitacion');
    }

    public function destroy(Request $request)
    {        
       
        $datos= Habitacion::find($request->inputIdEliminar);
        $datos->delete();
        return redirect()->route('mostrar.habitacion');
    }

    private $rules = [
    'numero.required' => 'El número de habitación es obligatorio.',
    'numero.integer' => 'Debe ingresar un número válido.',
    'numero.unique' => 'El número de habitación ya existe.',

    'cantidad.required' => 'Debe especificar la cantidad de camas.',
    'cantidad.integer' => 'La cantidad debe ser un número entero.',
    'cantidad.min' => 'Debe haber al menos una cama.',

    'disponibilidad.boolean' => 'El valor de disponibilidad no es válido.',
    ];
}
