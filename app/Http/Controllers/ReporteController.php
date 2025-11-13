<?php

namespace App\Http\Controllers;

use App\Models\Rerserva;
use App\Models\ReservaArea;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function dashboard(){
        $cantidad_ventas = Rerserva::count();

        $servicio_mas_vendido = ReservaArea::select('ar.nombre', DB::raw('COUNT(*) as total'))
                                ->join('area_recreativas as ar', 'ar.id', 'reserva_areas.id_area')
                                ->groupBy('ar.nombre')
                                ->orderBy('total','DESC')
                                ->take(2)
                                ->get();

        $ganancia_total = Rerserva::sum('costo');


        $trabajadores_mas_ventas = Rerserva::select('t.nombre', 't.apellido'  , DB::raw('COUNT(*) as total'))
                                    ->join('trabajadors as t', 't.id', 'rerservas.id_trabajador')
                                    ->groupBy('t.nombre', 't.apellido')
                                    ->orderBy('total','DESC')
                                    ->take(2)
                                    ->get();

        $cantidad_clientes = Rerserva::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('COUNT(DISTINCT id_user) as total_clientes')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha', 'ASC')
            ->get();

        // Formatear datos para el gráfico
        $labels = $cantidad_clientes->pluck('fecha')->map(function($f){
            return Carbon::parse($f)->format('d/m');
        });
        $data = $cantidad_clientes->pluck('total_clientes');

        return view('dashboard', compact(
            'cantidad_ventas',
            'servicio_mas_vendido',
            'ganancia_total',
            'trabajadores_mas_ventas',
            'labels',
            'data'
        ));
    }
}
