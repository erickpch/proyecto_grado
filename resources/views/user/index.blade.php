@extends('layout.navbar')

@section('titulo', 'Usuario')

@section('contenido')

<link rel="stylesheet" href="{{ asset('css/generalTable.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive/rol.css') }}">

@if (session('autorizacion'))
    <div class="alerta-error">
        {{ session('autorizacion') }}
    </div>
@endif    

<main class="content">
    <div class="header-section">
        <h1 style="color: #f8f9fa">Gestión de Usuarios</h1>    
        <a class="btn-add" href="{{ route('index.crear.usuario') }}">Agregar Usuario</a>
    </div>

    <div class="table-container">
        <table class="roles-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th> 
                    <th>Email</th> 
                    <th>Rol</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $dato)
                <tr>
                    <td>{{ $dato['id'] }}</td>
                    <td>{{ $dato['usuario']}}</td>  
                    <td>{{ $dato['email'] }}</td>  
                    <td>{{ $dato['rol'] }}</td> 
                    <td> <img src="{{asset($dato['foto'])}}"   class="fotoUsuario"></td>       
                    <td class="acciones">
                        <form action="{{ route('index.editar.usuario') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $dato['id'] }}">  
                            <button class="btn-edit" type="submit">Editar</button>
                        </form>

                        <form action="{{ route('eliminar.usuario') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $dato['id'] }}">  
                            <button class="btn-delete" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
</main>



@endsection
