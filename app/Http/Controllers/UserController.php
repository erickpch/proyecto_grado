<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $datos = User::get();       
        $datos = $datos->map->toShow();
       
        return view("user.index",compact('datos'));
    }

    public function indexStore(){

        $roles = Rol::get();
        return view('user.crear',compact('roles'));
    }

    public function indexUpdate(Request $request){

        $dato = User::find($request->id);
        $roles = Rol::get();
        return view('user.editar',compact('dato','roles'));
    }

    public function store(Request $request)
    {          
  
      
       try {
        $request->validate([
            'username' => 'required|string|max:30|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_rol' => 'required|exists:rols,id',
        ], $this->rules);

        
        if($request->file('foto')){

           $nombre =  $request->username . ".jpg";
           $ubicacion = "storage/".$request->file('foto')->storeAs('fotoUsurio',$nombre,'public');
           
        }


        $nuevo = [
            "username" => $request->username,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "foto" => $request->foto ? $ubicacion: null,
            "id_rol" => $request->id_rol,
        ];

            $nuevo = User::create($nuevo);
       } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');

            
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
       }

        return redirect()->route('mostrar.usuario');
    }

    public function update(Request $request)
    {
        try {
            $modificar = $request->validate([
                    'username' => 'sometimes|string|max:30|unique:users,username',
                    'email' => 'sometimes|email|unique:users,email',
                    'password' => 'sometimes|string|min:8|max:50',
                    'foto' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
                    'id_rol' => 'sometimes|exists:rols,id',               
                ], $this->rules);  

            $dato = User::find($request->id);
            $dato->update($modificar);
        } 
       catch(ValidationException $e){
            $mensajes = collect($e->errors())->flatten()->join(' ');
            return back()->with('error', $mensajes);
       }
       catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
       }
        return redirect()->route('mostrar.usuario');
    }

    public function destroy(Request $request)
    {
        $datos= User::find($request->id);
        $datos->delete();
        return redirect()->route('mostrar.usuario');
    }

    private $rules = [
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string'   => 'El nombre de usuario debe ser texto válido.',
            'username.max'      => 'El nombre de usuario no puede superar los 30 caracteres.',

            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Debe ingresar un correo electrónico válido.',
            'email.unique'      => 'Este correo ya está registrado en el sistema.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string'   => 'La contraseña debe ser una cadena de texto.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max'      => 'La contraseña no puede tener más de 50 caracteres.',

            'foto.image'        => 'El archivo debe ser una imagen.',
            'foto.mimes'        => 'Solo se permiten imágenes en formato JPG o PNG.',
            'foto.max'          => 'La imagen no puede pesar más de 2 MB.',

            'id_rol.required'   => 'Debe seleccionar un rol.',
            'id_rol.exists'     => 'El rol seleccionado no existe en la base de datos.',
    ];
}
