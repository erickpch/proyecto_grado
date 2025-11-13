@extends('layout.navbar')

@section('titulo', 'Gestión de Reservas')

@section('contenido')

<link rel="stylesheet" href="{{ asset('css/generalTable.css') }}">

{{-- Mensajes de error o éxito --}}
@if (session('error'))
    <div class="alerta-error">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="alerta-exito">{{ session('success') }}</div>
@endif    

<main class="content">
    <div class="header-section">
        <h1 style="color: #f8f9fa">Reserva de áreas comunes</h1>    
       
    </div>

    <div class="table-container">
        <table class="roles-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Costo</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Trabajador</th>
                    <th>Usuario</th>
                    <th>Habitación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($datos as $dato)
            <tr>
                <td>{{ $dato['id'] }}</td>
                <td>{{ $dato['costo'] }}</td>
                <td>{{ $dato['fecha'] }}</td>
                <td>{{ $dato['hora'] }}</td>
                <td>{{ $dato['trabajador'] }}</td>
                <td>{{ $dato['user'] }}</td>
                <td>{{ $dato['habitacion'] }}</td>
                <td class="acciones">
                    <!-- Botón editar -->   
                    <button class="btn-edit btn-abrir-agregar"
                        data-id="{{ $dato['id'] }}">                 
                            Pedir Area
                     
                    </button>

                    <!-- Botón eliminar -->
                    <button class="btn-cancelar btn-abrir-eliminar"
                        data-id-eliminar="{{ $dato['id'] }}">
                        Eliminar
                    </button>
                </td>
            </tr> 
            @endforeach
            </tbody>
        </table>
    </div>
</main>


{{-- ventana modal editar --}}
<div id="modalAgregar" class="modal-overlay" style="display:none">
    <div class="modal-contenido">
        <div class="modal-header">
            <h2 style="color: black">Reservar áreas</h2>
            <button id="cerrarModalAgregar" class="btn-cerrar">&times;</button>
        </div>

        <form action="{{ route('multiple.reserva') }}" method="POST">
            @csrf

            <input type="hidden" name="id" id="ag_id">

            <div class="campo-form">
                <label>Cantidad de personas:</label>
                <input type="number" name="cantidad" id="ag_cantidad"  required>
            </div>
 
            <div class="campo-form">
                <label>Hora:</label>
                <input type="time" name="hora" id="ag_hora" required>
            </div>            
         
        <div id="contenedor-actividades">
            <div class="campo-form">
                <label>Área:</label>
                <select name="id_areas[]" id="ag_area" required>
                    @foreach ($areas as $area)
                        <option value="{{ $area['id'] }}">{{ $area['nombre'] }}</option>
                    @endforeach
                </select>
            </div>



        </div>


            <button type="button" class="btn"  id="agregar_campo">Agregar Campo</button>

            


            <div class="modal-footer">
                <button type="button" class="btn-cancelar" id="cancelarAgregar">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {

    /* === Modal Eliminar === */
    const modalEliminar = document.getElementById('modalEliminar');
    const inputIdEliminar = document.getElementById('inputIdEliminar');

    document.querySelectorAll('.btn-abrir-eliminar').forEach(boton => {
        boton.addEventListener('click', () => {
            inputIdEliminar.value = boton.getAttribute('data-id-eliminar');
            modalEliminar.style.display = 'flex';
        });
    });

    document.getElementById('cerrarModalEliminar')?.addEventListener('click', () => modalEliminar.style.display = 'none');
    document.getElementById('cancelarEliminar')?.addEventListener('click', () => modalEliminar.style.display = 'none');

    /* === Modal Agregar === */
    const modalAgregar = document.getElementById('modalAgregar');
    const agregarId = document.getElementById('ag_id');   

    document.querySelectorAll('.btn-abrir-agregar').forEach(boton => {
        boton.addEventListener('click', () => {
            agregarId.value = boton.getAttribute('data-id');
            modalAgregar.style.display = 'flex';
        });
    });

    document.getElementById('cerrarModalAgregar').addEventListener('click', () => modalAgregar.style.display = 'none');
    document.getElementById('cancelarAgregar').addEventListener('click', () => modalAgregar.style.display = 'none');

    /* === Cerrar modales al hacer clic fuera === */
    window.addEventListener('click', (e) => {
        if (e.target === modalAgregar) modalAgregar.style.display = 'none';
        if (e.target === modalEliminar) modalEliminar.style.display = 'none';
    });

    /* === Agregar campos dinámicos === */
    const contenedor = document.getElementById('contenedor-actividades');
    const botonAgregar = document.getElementById('agregar_campo');

    botonAgregar.addEventListener('click', function() {
        const nuevoCampo = document.createElement('div');
        nuevoCampo.classList.add('campo-form');
        nuevoCampo.innerHTML = `
            <label>Área:</label>
            <select name="id_areas[]" required>
                @foreach ($areas as $area)
                    <option value="{{ $area['id'] }}">{{ $area['nombre'] }}</option>
                @endforeach
            </select>
        `;
        contenedor.appendChild(nuevoCampo);
    });

});
</script>


@endsection
