@extends('layout.navbar')

@section('titulo', 'Habitacion')

@section('contenido')

<link rel="stylesheet" href="{{ asset('css/generalTable.css') }}">

@if (session('autorizacion'))
    <div class="alerta-error">
        {{ session('autorizacion') }}
    </div>
@endif    



<main class="content">
    <div class="header-section">
        <h1 style="color: #f8f9fa">Gestión de Habitaciones</h1>    
        <button class="btn-add" id="abrirModalCrear">Agregar Habitacion</button>  
    </div>

    <div class="table-container">
        <table class="roles-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Numero</th> 
                    <th>Cantidad</th> 
                    <th>documento</th> 
                    <th>disponibilidad</th> 
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($datos as $dato)
            <tr>
                <td>{{ $dato->id }}</td>
                <td>{{ $dato->numero }}</td>   
                <td>{{ $dato->cantidad }}</td>   
                <td> <a href="{{ $dato->documento }}" target="_blank"> <img src="{{asset('storage/general/PDF_file_icon.png') }}" class="pdf_icon"> </a> </td>   
                <td>
                    @if ($dato->disponibilidad == 1)
                        <span style="background-color:#00e078;color:white;padding:4px 10px;border-radius:8px;font-weight:bold;font-size:0.9rem;">
                            Disponible
                        </span>
                    @else
                        <span style="background-color:#dc3545;color:white;padding:4px 10px;border-radius:8px;font-weight:bold;font-size:0.9rem;">
                            No disponible
                        </span>
                    @endif    
                </td>   
                <td class="acciones">

                    <!-- Botón editar con data-atributos -->
                    <button class="btn-edit btn-abrir-editar"
                        data-id="{{ $dato->id }}"
                        data-numero="{{ $dato->numero }}"
                        data-cantidad="{{ $dato->cantidad }}"
                        data-disponibilidad="{{ $dato->disponibilidad }}">
                        Editar
                    </button>

                    <!-- Botón editar con data-atributos -->
                    <button class="btn-cancelar btn-abrir-eliminar"
                        data-id-Eliminar="{{ $dato->id }}">
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
<div id="modalCrear" class="modal-overlay" style="display:none" >
    <div class="modal-contenido">
        <div class="modal-header">
            <h2 style="color: black">Agregar Habitación</h2>
            <button id="cerrarModalCrear" class="btn-cerrar">&times;</button>
        </div>

        <form action="{{ route('crear.habitacion') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="campo-form">
                <label for="numero">Número de habitación:</label>
                <input type="text" id="numero" name="numero" required>
            </div>

            <div class="campo-form">
                <label for="cantidad">Cantidad de camas:</label>
                <input type="number" id="cantidad" name="cantidad" required min="1">
            </div>

            <div class="campo-form">
                <label for="cantidad">Cantidad de camas:</label>
                <input type="file" id="documento" name="documento" >
            </div>

            <div class="campo-form">
                <label for="disponibilidad">Disponibilidad:</label>
                <select id="disponibilidad" name="disponibilidad" required>
                    <option value="1">Disponible</option>
                    <option value="0">Ocupada</option>
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
<div id="modalEditar" class="modal-overlay" style="display:none" >
    <div class="modal-contenido">
        <div class="modal-header">
            <h2 style="color: black">Editar Habitación</h2>
            <button id="cerrarModalEditar" class="btn-cerrar">&times;</button>
        </div>

        <form action="{{ route('editar.habitacion') }}" method="POST">
            @csrf

            <div class="campo-form">
                <label for="numero">Número de habitación:</label>
                <input type="text" id="numero" name="numero" required>
            </div>

            <div class="campo-form">
                <label for="cantidad">Cantidad de camas:</label>
                <input type="number" id="cantidad" name="cantidad" required min="1">
            </div>

           
            <div class="campo-form">
                <label for="disponibilidad">Disponibilidad:</label>
                <select id="disponibilidad" name="disponibilidad" required>
                    <option value="1">Disponible</option>
                    <option value="0">Ocupada</option>
                </select>
            </div>

            <input type="hidden" name="id" id="id">

            <div class="modal-footer">
                <button type="button" class="btn-cancelar" id="cancelarEditar">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>


{{-- ventana modal eliminar --}}
<div id="modalEliminar" class="modal-overlay" style="display:none" >
    <div class="modal-contenido">
        <div class="modal-header">
            <h2 style="color: black">Eliminar Habitación</h2>
            <button id="cerrarModalEliminar" class="btn-cerrar">&times;</button>
        </div>
            <span>¿Seguro que desea eliminar la habitación?</span>
       

        <form action="{{ route('eliminar.habitacion') }}" method="POST">
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
    const modal = document.getElementById('modalCrear');
    const cerrarmodal = document.getElementById('cerrarModalCrear');
    const cancelarModal = document.getElementById('cancelarModal');
    const abrirModalCrear = document.getElementById('abrirModalCrear');

    cerrarmodal.addEventListener('click',()=>modal.style.display= 'none');
    cancelarModal.addEventListener('click',()=>modal.style.display= 'none');
    abrirModalCrear.addEventListener('click',()=>modal.style.display= 'flex');

    /* === Modal Eliminar === */
    const modalEliminar = document.getElementById('modalEliminar');
    const cerrarEliminar = document.getElementById('cerrarModalEliminar');
    const cancelarEliminar = document.getElementById('cancelarEliminar');   
    const botonesEliminar = document.querySelectorAll('.btn-abrir-eliminar');

    
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', () => {
            // obtener los datos desde los atributos del botón
            const id = boton.getAttribute('data-id-Eliminar');            

            // llenar los campos del formulario
            inputIdEliminar.value= id ;

            // mostrar el modal
            modalEliminar.style.display = 'flex';
        });
    });


    cerrarEliminar.addEventListener('click',()=>modalEliminar.style.display= 'none');
    cancelarEliminar.addEventListener('click',()=>modalEliminar.style.display= 'none');
   


    /* === Modal Editar === */
    const modalEditar = document.getElementById('modalEditar');
    const cerrarEditar = document.getElementById('cerrarModalEditar');
    const cancelarEditar = document.getElementById('cancelarEditar');

    // campos del formulario dentro del modal editar
    const inputNumero = modalEditar.querySelector('input[name="numero"]');
    const inputId = modalEditar.querySelector('input[name="id"]');
    const inputCantidad = modalEditar.querySelector('input[name="cantidad"]');
    const selectDisponibilidad = modalEditar.querySelector('select[name="disponibilidad"]');
    const formEditar = modalEditar.querySelector('form');

    // todos los botones "Editar" de la tabla
    const botonesEditar = document.querySelectorAll('.btn-abrir-editar');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', () => {
            // obtener los datos desde los atributos del botón
            const id = boton.getAttribute('data-id');
            const numero = boton.getAttribute('data-numero');
            const cantidad = boton.getAttribute('data-cantidad');
            const disponibilidad = boton.getAttribute('data-disponibilidad');

            // llenar los campos del formulario
            inputNumero.value = numero;
            inputCantidad.value = cantidad;
            selectDisponibilidad.value = disponibilidad;
            inputId.value= id ;
            // mostrar el modal
            modalEditar.style.display = 'flex';
        });
    });

    // botones para cerrar/cancelar
    cerrarEditar.addEventListener('click', () => modalEditar.style.display = 'none');
    cancelarEditar.addEventListener('click', () => modalEditar.style.display = 'none');

    // cerrar si hace clic fuera del modal
    window.addEventListener('click', (e) => {
        if (e.target === modalEditar) modalEditar.style.display = 'none';
        if (e.target === modalCrear) modalCrear.style.display = 'none';
    });


</script>

@endsection


