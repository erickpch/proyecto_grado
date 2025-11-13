<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permiso::create(['nombre' =>'rol']);
        Permiso::create(['nombre' =>'permiso']);
        Permiso::create(['nombre' =>'user']);
        Permiso::create(['nombre' =>'habitacion']);
        Permiso::create(['nombre' =>'reservas']);
        
    }
}
