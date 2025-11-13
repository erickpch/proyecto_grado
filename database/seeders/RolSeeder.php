<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create([ 'nombre'=> 'administrador']);
        Rol::create([ 'nombre'=> 'trabajador']);
        Rol::create([ 'nombre'=> 'cliente']);
    }
}
