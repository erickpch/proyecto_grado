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
        <h1 style="color: #f8f9fa">Gestión de Reservas</h1>    
        <button class="btn-add" id="abrirModalCrear">Agregar Reserva</button>  
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
                    <button class="btn-edit btn-abrir-editar"
                        data-id="{{ $dato['id'] }}"
                        data-costo="{{ $dato['costo'] }}"
                        data-fecha="{{ $dato['fecha'] }}"
                        data-hora="{{ $dato['hora'] }}"
                        data-trabajador="{{ $dato['trabajador'] }}"
                        data-user="{{ $dato['user'] }}"
                        data-habitacion="{{ $dato['habitacion'] }}">
                        Editar
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

{{-- ventana modal crear --}}
<div id="modalCrear" class="modal-overlay" style="display:none">
    <div class="modal-contenido">
        <div class="modal-header">
            <h2 style="color: black">Agregar Reserva</h2>
            <button id="cerrarModalCrear" class="btn-cerrar">&times;</button>
        </div>

        <form action="{{ route('crear.reserva') }}" method="POST">
            @csrf

            <div class="campo-form">
                <label>Costo:</label>
                <input type="number" name="costo" step="0.01" required>
            </div>

            <div class="campo-form">
                <label>Fecha:</label>
                <input type="date" name="fecha" required>
            </div>

            <div class="campo-form">
                <label>Hora:</label>
                <input type="time" name="hora" required>
            </div>

            <div class="campo-form">
                <label>Trabajador:</label>
                <select name="id_trabajador" required>
                    <option value="">-- Seleccione un trabajador --</option>
                    @foreach ($trabajadores as $trab)
                        <option value="{{ $trab['id'] }}">{{ $trab['nombre'] }} {{ $trab['apellido'] }}</option>
                    @endforeach
                </select>
            </div> 

            <div class="campo-form">
                <label>Usuario:</label>
                <select name="id_user" required>
                    <option value="">-- Seleccione un usuario --</option>
                    @foreach ($usuarios as $user)
                        <option value="{{ $user['id'] }}">{{ $user['username'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="campo-form">
                <label>Habitación:</label>
                <select name="id_habitacion" required>
                    <option value="">-- Seleccione una habitación --</option>
                    @foreach ($habitaciones as $hab)
                        <option value="{{ $hab['id'] }}">{{ 'Habitación '.$hab['numero'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancelar" id="cancelarModal">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- ventana modal editar --}}
<div id="modalEditar" class="modal-overlay" style="display:none">
    <div class="modal-contenido">
        <div class="modal-header">
            <h2 style="color: black">Editar Reserva</h2>
            <button id="cerrarModalEditar" class="btn-cerrar">&times;</button>
        </div>

        <form action="{{ route('editar.reserva') }}" method="POST">
            @csrf

            <input type="hidden" name="id" id="edit_id">

            <div class="campo-form">
                <label>Costo:</label>
                <input type="number" name="costo" id="edit_costo" step="0.01" required>
            </div>

            <div class="campo-form">
                <label>Fecha:</label>
                <input type="date" name="fecha" id="edit_fecha" required>
            </div>

            <div class="campo-form">
                <label>Hora:</label>
                <input type="time" name="hora" id="edit_hora" required>
            </div>

            <div class="campo-form">
                <label>Trabajador:</label>
                <select name="id_trabajador" id="edit_trabajador" required>
                    @foreach ($trabajadores as $trab)
                        <option value="{{ $trab['id'] }}">{{ $trab['nombre'] }} {{ $trab['apellido'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="campo-form">
                <label>Usuario:</label>
                <select name="id_user" id="edit_user" required>
                    @foreach ($usuarios as $user)
                        <option value="{{ $user['id'] }}">{{ $user['username'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="campo-form">
                <label>Habitación:</label>
                <select name="id_habitacion" id="edit_habitacion" required>
                    @foreach ($habitaciones as $hab)
                        <option value="{{ $hab['id'] }}">{{ 'Habitación '.$hab['id'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancelar" id="cancelarEditar">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

{{-- ventana modal eliminar --}}
<div id="modalEliminar" class="modal-overlay" style="display:none">
    <div class="modal-contenido">
        <div class="modal-header">
            <h2 style="color: black">Eliminar Reserva</h2>
            <button id="cerrarModalEliminar" class="btn-cerrar">&times;</button>
        </div>
        <span>¿Seguro que desea eliminar esta reserva?</span>

        <form action="{{ route('eliminar.reserva') }}" method="POST">
            @csrf
            <input type="hidden" name="inputIdEliminar" id="inputIdEliminar">

            <div class="modal-footer">
                <button type="button" class="btn-cancelar" id="cancelarEliminar">Cancelar</button>
                <button type="submit" class="btn-guardar">Eliminar</button>
            </div>
        </form>
    </div>
</div>

<script>
    /* === Modal Crear === */
    const modalCrear = document.getElementById('modalCrear');
    document.getElementById('abrirModalCrear').addEventListener('click', () => modalCrear.style.display = 'flex');
    document.getElementById('cerrarModalCrear').addEventListener('click', () => modalCrear.style.display = 'none');
    document.getElementById('cancelarModal').addEventListener('click', () => modalCrear.style.display = 'none');

    /* === Modal Eliminar === */
    const modalEliminar = document.getElementById('modalEliminar');
    const inputIdEliminar = document.getElementById('inputIdEliminar');

    document.querySelectorAll('.btn-abrir-eliminar').forEach(boton => {
        boton.addEventListener('click', () => {
            inputIdEliminar.value = boton.getAttribute('data-id-eliminar');
            modalEliminar.style.display = 'flex';
        });
    });

    document.getElementById('cerrarModalEliminar').addEventListener('click', () => modalEliminar.style.display = 'none');
    document.getElementById('cancelarEliminar').addEventListener('click', () => modalEliminar.style.display = 'none');

    /* === Modal Editar === */
    const modalEditar = document.getElementById('modalEditar');
    const editId = document.getElementById('edit_id');
    const editCosto = document.getElementById('edit_costo');
    const editFecha = document.getElementById('edit_fecha');
    const editHora = document.getElementById('edit_hora');
    const editTrabajador = document.getElementById('edit_trabajador');
    const editUser = document.getElementById('edit_user');
    const editHabitacion = document.getElementById('edit_habitacion');

    document.querySelectorAll('.btn-abrir-editar').forEach(boton => {
        boton.addEventListener('click', () => {
            editId.value = boton.getAttribute('data-id');
            editCosto.value = boton.getAttribute('data-costo');
            editFecha.value = boton.getAttribute('data-fecha');
            editHora.value = boton.getAttribute('data-hora');
            editTrabajador.value = boton.getAttribute('data-trabajador');
            editUser.value = boton.getAttribute('data-user');
            editHabitacion.value = boton.getAttribute('data-habitacion');

            modalEditar.style.display = 'flex';
        });
    });

    document.getElementById('cerrarModalEditar').addEventListener('click', () => modalEditar.style.display = 'none');
    document.getElementById('cancelarEditar').addEventListener('click', () => modalEditar.style.display = 'none');

    /* === Cerrar modales al hacer clic fuera === */
    window.addEventListener('click', (e) => {
        if (e.target === modalEditar) modalEditar.style.display = 'none';
        if (e.target === modalCrear) modalCrear.style.display = 'none';
        if (e.target === modalEliminar) modalEliminar.style.display = 'none';
    });
</script>

@endsection
