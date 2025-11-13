<?php

use App\Http\Controllers\AreaRecreativaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RerservaController;
use App\Http\Controllers\ReservaAreaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get("/",[AuthController::class,'welcome'])->name('welcome');
Route::get("/login", [AuthController::class,'loginView'])->name('login');
Route::post("/login",[AuthController::class,'login'])->name('sendLogin');

Route::get("/logout",[AuthController::class,'logout'])->name('logout');

Route::middleware('rolMiddleware')->get("/dasboard",[ReporteController::class,'dashboard'])->name('dashboard');

Route::prefix('/rol')->middleware('rolMiddleware')->group(function(){
    Route::get("/",[RolController::class,'index'])->name('mostrar.rol');
    //crear nuevo rol
    Route::get("/crear",[RolController::class,'indexStore'])->name('index.crear.rol');
    Route::post("/crear",[RolController::class,'store'])->name('crear.rol');

    //modificar rol
    Route::post("/modificar",[RolController::class,'indexUpdate'])->name('index.editar.rol');
    Route::post("/modificarPost",[RolController::class,'update'])->name('editar.rol');

    Route::post("/eliminar",[RolController::class,'destroy'])->name('eliminar.rol');
});


Route::prefix('/usuario')->middleware('userMiddleware')->group(function(){
    Route::get("/",[UserController::class,'index'])->name('mostrar.usuario');
    //crear nuevo usuario
    Route::get("/crear",[UserController::class,'indexStore'])->name('index.crear.usuario');
    Route::post("/crear",[UserController::class,'store'])->name('crear.usuario');

    //modificar usuario
    Route::post("/modificar",[UserController::class,'indexUpdate'])->name('index.editar.usuario');
    Route::post("/modificarPost",[UserController::class,'update'])->name('editar.usuario');

    Route::post("/eliminar",[UserController::class,'destroy'])->name('eliminar.usuario');
});

Route::prefix('/permiso')->middleware('permisoMiddleware')->group(function(){
    Route::get("/",[PermisoController::class,'index'])->name('mostrar.permiso');
    Route::post("/",[PermisoController::class,'store'])->name('crear.permiso');
    Route::patch("/",[PermisoController::class,'update'])->name('editar.permiso');
    Route::delete("/",[PermisoController::class,'destroy'])->name('eliminar.permiso');
});

Route::prefix('/habitacion')->group(function(){
    Route::get("/",[HabitacionController::class,'index'])->name('mostrar.habitacion');
    Route::post("/",[HabitacionController::class,'store'])->name('crear.habitacion');
    Route::post("/editar",[HabitacionController::class,'update'])->name('editar.habitacion');
    Route::post("/eliminar",[HabitacionController::class,'destroy'])->name('eliminar.habitacion');
});


Route::prefix('/area_recreativa')->group(function(){
    Route::get("/",[AreaRecreativaController::class,'index'])->name('mostrar.area_recreativa');
    Route::post("/",[AreaRecreativaController::class,'store'])->name('crear.area_recreativa');
    Route::post("/editar",[AreaRecreativaController::class,'update'])->name('editar.area_recreativa');
    Route::post("/eliminar",[AreaRecreativaController::class,'destroy'])->name('eliminar.area_recreativa');
});

Route::prefix('/trabajador')->group(function(){
    Route::get("/",[TrabajadorController::class,'index'])->name('mostrar.trabajador');
    Route::post("/",[TrabajadorController::class,'store'])->name('crear.trabajador');
    Route::post("/editar",[TrabajadorController::class,'update'])->name('editar.trabajador');
    Route::post("/eliminar",[TrabajadorController::class,'destroy'])->name('eliminar.trabajador');
});

Route::prefix('/reserva')->group(function(){
    Route::get("/",[RerservaController::class,'index'])->name('mostrar.reserva');
    Route::post("/",[RerservaController::class,'store'])->name('crear.reserva');
    Route::post("/editar",[RerservaController::class,'update'])->name('editar.reserva');
    Route::post("/eliminar",[RerservaController::class,'destroy'])->name('eliminar.reserva');
});


Route::prefix('/reservar_area')->group(function(){
    Route::get("/",[ReservaAreaController::class,'index'])->name('mostrar.reserva_area');
    Route::Post("/",[ReservaAreaController::class,'AgregarMultiple'])->name('multiple.reserva');


});
 