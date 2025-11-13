@extends('layout.navbar')

@section('titulo', 'Roles')

@section('contenido')

<link rel="stylesheet" href="{{ asset('css/generalTable.css') }}">

@if (session('autorizacion'))
    <div class="alerta-error">
        {{ session('autorizacion') }}
    </div>
@endif    

<main class="content">
    <div class="header-section">
        <h1 style="color: #f8f9fa">Gestión de Roles</h1>    
        <a class="btn-add" href="{{ route('index.crear.rol') }}">Agregar Rol</a>
    </div>

    <div class="table-container">
        <table class="roles-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th> 
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $dato)
                <tr>
                    <td>{{ $dato->id }}</td>
                    <td>{{ $dato->nombre }}</td>                   
                    <td class="acciones">
                        <form action="{{ route('index.editar.rol') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $dato->id }}">  
                            <button class="btn-edit" type="submit">Editar</button>
                        </form>

                        <form action="{{ route('eliminar.rol') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $dato->id }}">  
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
