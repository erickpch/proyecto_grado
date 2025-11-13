<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    protected $fillable = [
        'username',
        'email',
        'foto',
        'id_rol',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol(){
        return $this->belongsTo(Rol::class,'id_rol'); //uno a muchos, solo tiene 1
    }

    
    public function toShow(){
        return[
            'id'        => $this->id,
            'usuario'   => $this->username,
            'email'     => $this->email,
            'foto'      => $this->foto,
            'rol'       => $this->rol->nombre ?? null
        ];
    }
}
