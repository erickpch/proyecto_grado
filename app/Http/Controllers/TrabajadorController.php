<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TrabajadorController extends Controller
{
    public function index()
    {
        $datos = Trabajador::get();  

        return view("trabajador.index",compact('datos'));
    }

    public function store(Request $request)
    {

       try {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'sueldo' => 'required|numeric|min:0',
            'fecha_contrato' => 'required|date',
        ], $this->rules);

        
        $nuevo = [
            "nombre" => $request->nombre ,
            "apellido" => $request->apellido ,
            "sueldo" => $request->sueldo,
            "fecha_contrato" => $request->fecha_contrato   
        ];
   
        $nuevo = Trabajador::create($nuevo);
            
        } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
          
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
 
            return back()->with('error', $e->getMessage());
       }

        return redirect()->route('mostrar.trabajador');
    }


    public function show(Trabajador $trabajador)
    {
        //
    }


    public function update(Request $request)
    {
        
        try {
            $modificar = $request->validate([
                'nombre' => 'sometimes|string|max:100',
                'apellido' => 'sometimes|string|max:100',
                'sueldo' => 'sometimes|numeric|min:0',
                'fecha_contrato' => 'sometimes|date',   
            ], $this->rules);  

            $dato = Trabajador::find($request->id);
            
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
        return redirect()->route('mostrar.trabajador');
    }

    public function destroy(Request $request)
    {        
       
        $datos= Trabajador::find($request->inputIdEliminar);
        $datos->delete();
        return redirect()->route('mostrar.trabajador');
    }

    private $rules = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string' => 'El nombre debe ser un texto válido.',
        'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',

        'apellido.required' => 'El apellido es obligatorio.',
        'apellido.string' => 'El apellido debe ser un texto válido.',
        'apellido.max' => 'El apellido no puede tener más de 100 caracteres.',

        'sueldo.required' => 'El sueldo es obligatorio.',
        'sueldo.numeric' => 'El sueldo debe ser un número.',
        'sueldo.min' => 'El sueldo no puede ser negativo.',

        'fecha_contrato.required' => 'La fecha de contrato es obligatoria.',
        'fecha_contrato.date' => 'Debe ingresar una fecha de contrato válida.',
    ];
}
