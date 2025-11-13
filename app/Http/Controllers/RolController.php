<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RolController extends Controller
{

    public function index()
    {
        $datos = Rol::get();       
        
        return view("rol.index",compact('datos'));
    }

    public function indexStore(){
        return view('rol.crear');
    } 

    public function indexUpdate(Request $request){

        $dato = Rol::find($request->id);
        
        return view('rol.editar',compact('dato'));
    }

    public function store(Request $request)
    {
       try {
            $request->validate([
                'nombre' => 'required|string|max:15',
            ], [
                'nombre.required' => 'El campo nombre es obligatorio.',
                'nombre.string'   => 'El nombre debe ser una cadena de texto válida.',
                'nombre.max'      => 'El nombre no puede tener más de 15 caracteres.',
            ]);    
            $nuevo = [
                "nombre" => $request->nombre
            ];

            $nuevo = Rol::create($nuevo);
       } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
       }

        return redirect()->route('mostrar.rol');
    }

    public function update(Request $request)
    {
        try {
            $modificar = $request->validate([
                    'nombre' => 'required|string|max:15'                
                ], [
                    'nombre.required' => 'El campo nombre es obligatorio.',
                    'nombre.string'   => 'El nombre debe ser una cadena de texto válida.',
                    'nombre.max'      => 'El nombre no puede tener más de 15 caracteres.',
                ]);  

            $dato = Rol::find($request->id);
            $dato->update($modificar);
                } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
       }
        return redirect()->route('mostrar.rol');
    }

    public function destroy(Request $request)
    {
        $datos= Rol::find($request->id);
        $datos->delete();
        return redirect()->route('mostrar.rol');
    }
}
