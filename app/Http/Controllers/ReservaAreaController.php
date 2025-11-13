<?php

namespace App\Http\Controllers;

use App\Models\AreaRecreativa;
use App\Models\Rerserva;
use App\Models\ReservaArea;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class ReservaAreaController extends Controller
{
  
    public function index()
    {
        $datos = Rerserva::get();

        $areas = AreaRecreativa::get();      
     
        $datos = $datos->map->toShow();
     
        return view("reserva_area.index",compact('datos','areas'));
    }

    public function AgregarMultiple(Request $request){
        try {
           
            $request->validate([
                'id' => 'required|exists:rerservas,id',            
                'hora' => 'required|date_format:H:i',
                'cantidad' => 'required|numeric|min:1',
                'id_areas.*' => 'required|exists:area_recreativas,id'
     
            ]);
            DB::transaction(function() use($request){
                foreach ($request->id_areas as $id_area) {
                    $nuevo = [
                        'id_reserva'   => $request->id,
                        'hora'          => $request->hora,
                        'cantidad'      => $request->cantidad,
                        'id_area'       => $id_area  
                    ];   
                    ReservaArea::create($nuevo);            
                }
                DB::commit();
            });            


        }  
        catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
            DB::rollBack();
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
       }

        return redirect()->route('mostrar.reserva_area');

    }

}
