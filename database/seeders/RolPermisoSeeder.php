<?php

namespace Database\Seeders;

use App\Models\RolPermiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permisos administrador
        RolPermiso::create(['id_permiso'=> 1,'id_rol'=> 1]);
        RolPermiso::create(['id_permiso'=> 2,'id_rol'=> 1]);
        RolPermiso::create(['id_permiso'=> 3,'id_rol'=> 1]);
        RolPermiso::create(['id_permiso'=> 4,'id_rol'=> 1]);


        //permisos trabajador
        RolPermiso::create(['id_permiso'=> 4,'id_rol'=> 2]);
        RolPermiso::create(['id_permiso'=> 5,'id_rol'=> 2]);

        //permisos cliente
        RolPermiso::create(['id_permiso'=> 5,'id_rol'=> 3]);
    }
}
