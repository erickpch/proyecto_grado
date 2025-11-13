@extends('layout.navbar')

@section('titulo', 'Area Recreativa')

@section('contenido')

<link rel="stylesheet" href="{{ asset('css/generalTable.css') }}">

@if (session('autorizacion'))
    <div class="alerta-error">
        {{ session('autorizacion') }}
    </div>
@endif    



<main class="content">
    <div class="header-section">
        <h1 style="color: #f8f9fa">Gestión de Area Recreativa</h1>    
        <button class="btn-add" id="abrirModalCrear">Agregar Area Recreativa</button>  
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

                    <!-- Botón editar con data-atributos -->
                    <button class="btn-edit btn-abrir-editar"
                        data-id="{{ $dato->id }}"
                        data-nombre="{{ $dato->nombre }}"
                    >Editar
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

        <form action="{{ route('crear.area_recreativa') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="campo-form">
                <label for="numero">Nombre de área recreativa:</label>
                <input type="text" id="nombre" name="nombre" required>
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

        <form action="{{ route('editar.area_recreativa') }}" method="POST">
            @csrf

                <div class="campo-form">
                    <label for="numero">Nombre de área recreativa:</label>
                    <input type="text" id="nombre" name="nombre" required>
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
            <h2 style="color: black">Eliminar Area</h2>
            <button id="cerrarModalEliminar" class="btn-cerrar">&times;</button>
        </div>
            <span>¿Seguro que desea eliminar el área?</span>
       

        <form action="{{ route('eliminar.area_recreativa') }}" method="POST">
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
    const inputNombre = modalEditar.querySelector('input[name="nombre"]');
    const inputId = modalEditar.querySelector('input[name="id"]');
   
    // todos los botones "Editar" de la tabla
    const botonesEditar = document.querySelectorAll('.btn-abrir-editar');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', () => {
            // obtener los datos desde los atributos del botón
            const id = boton.getAttribute('data-id');
            const nombre = boton.getAttribute('data-nombre');
            
            // llenar los campos del formulario
            inputId.value=id;
            inputNombre.value = nombre;

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


