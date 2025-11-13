<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{

    public function index()
    {
       return view('permiso.index');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Permiso $permiso)
    {
        //
    }

    public function update(Request $request, Permiso $permiso)
    {
        //
    }

    public function destroy(Permiso $permiso)
    {
        //
    }
}
