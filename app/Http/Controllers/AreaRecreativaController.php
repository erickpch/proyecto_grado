<?php

namespace App\Http\Controllers;

use App\Models\AreaRecreativa;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AreaRecreativaController extends Controller
{
    public function index()
    {
        $datos = AreaRecreativa::get();  
        dd($datos);
        return view("area_recreativa.index",compact('datos'));
    }

    public function store(Request $request)
    {

       try {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ], $this->rules);

        
        $nuevo = [
            "nombre" => $request->nombre   
        ];
   
        $nuevo = AreaRecreativa::create($nuevo);
            
        } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
          
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
 
            return back()->with('error', $e->getMessage());
       }

        return redirect()->route('mostrar.area_recreativa');
    }


    public function show(AreaRecreativa $area_recreativa)
    {
        //
    }


    public function update(Request $request)
    {
        
        try {
            $modificar = $request->validate([
                'nombre' => 'sometimes|string|max:255|unique:area_recreativas,nombre',    
            ], $this->rules);  

            $dato = AreaRecreativa::find($request->id);
            
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
        return redirect()->route('mostrar.area_recreativa');
    }

    public function destroy(Request $request)
    {        
       
        $datos= AreaRecreativa::find($request->inputIdEliminar);
        $datos->delete();
        return redirect()->route('mostrar.area_recreativa');
    }

    private $rules = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string' => 'El nombre debe ser texto.',
        'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
        'nombre.unique' => 'Ya existe un área recreativa con este nombre.',
    ];
}
