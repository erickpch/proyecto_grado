<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    
    public function loginView(){
        return view('login');
    }

    public function login(Request $request){

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',           
        ]);
        
        $user = User::where('username', $request->username)->first(); 
        
        if(!$user){
            return back()->with('errorUser', 'El usuario no existe');
        }
        $credentials = $request->only('username', 'password');

        if (Auth::guard('web')->attempt($credentials)){ 

            Cache::put('persona', $user);
            if($user->id_rol == 1 ||$user->id_rol == 2 )
                return redirect()->route('dashboard');
            else{
                return redirect()->route('rol.index');
            }
        }
        {
            return back()->with('password', 'la constraseña es incorrecta');
        }       
    }
    public function logout(){
        Cache::forget('persona');
      
        return redirect()->route('welcome');
    }
}
