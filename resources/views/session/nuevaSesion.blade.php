@extends('layouts.authLayout')

@section('title')
    Nueva Sesión
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/session/create.js'])
@endsection

@section('main')
    <main>
        <!-- Pantalla de carga durante la subida del registro -->
        <section id="section-loading"></section>
        <!-- Apartado del formulario -->
        <div class="container-fluid mx-auto">
            <h4 class="titulo text-center mb-3">Nuevo préstamo</h4>
            <form class="bg-light rounded-5 p-4 sombraBasica formRegistro" novalidate method="POST"
                action="{{ route('session.store') }}">
                @csrf
                <div class="row mb-4">
                    <div class="col d-flex align-items-center justify-content-center">
                        <div class="input-group w-auto">
                            <label for="numControl" class="input-group-text">Número de control</label>
                            <input type="text" class="form-control text-center" id="numControl" name="numControl" required>
                        </div>
                        <div class="mt-1 invalid-feedback text-center">
                            El número de control no es válido.
                        </div>
                        <button id="botonBuscar" type="button" class="btn-secondary btn btn-sm ms-2">Buscar</button>
                    </div>
                    <div class="mt-1 text-center text-danger" id="msgNumControl"></div>
                    <input type="hidden" id="registrado" name="registrado">
                </div>

                <div class="row justify-content-center gx-3 gy-2 mb-2">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="input-group">
                            <label class="input-group-text" for="nombre">Nombre</label>
                            <input class="form-control" type="text" id="nombre" name="nombre" required>
                            <div class="mt-1 invalid-feedback text-center">
                                Ingresa el nombre del alumno.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="input-group">
                            <label class="input-group-text" for="apellidos">Apellidos</label>
                            <input class="form-control" type="text" id="apellidos" name="apellidos" required>
                            <div class="mt-1 invalid-feedback text-center">
                                Ingresa el apellido del alumno.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center gx-3 gy-2">
                    <div class="col-12 col-sm-auto col-lg-2">
                        <div class="input-group">
                            <label class="input-group-text" for="semestre">Semestre</label>
                            <input type="number" class="form-control" id="semestre" name="semestre" min="1"
                                max="13" required>
                            <div class="mt-1 invalid-feedback text-center">
                                Ingresa el semestre del alumno.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5 col-lg-4 ">
                        <div class="input-group">
                            <label class="input-group-text" for="carrera">Carrera</label>
                            <select class="form-select" id="selectCarreras" name="carrera" required>
                                <option selected class="d-none"></option>
                                {{-- Las carreras se agregan programáticamente --}}
                            </select>
                            <div class="mt-1 invalid-feedback text-center">
                                Ingresa la carrera del alumno.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="hr mx-5 my-4" />

                <div class="row justify-content-center gx-3 gy-2 mb-2">
                    <div class="col-12 col-sm-5 col-lg-3">
                        <div class="input-group">
                            <label class="input-group-text" for="uso">Uso</label>
                            <select class="form-select" id="uso" name="uso" required></select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-auto">
                        <div class="input-group">
                            <label class="input-group-text" for="equipos">Equipo</label>
                            <select class="form-select" id="equipos" name="equipo" required></select>
                            <div class="mt-1 invalid-feedback text-center">
                                Elige un equipo disponible.
                            </div>
                        </div>
                    </div>
                    <div class="mt-1 text-center text-danger" id="msgEquipo"></div>
                </div>

                <div class="row justify-content-center gx-3 gy-2 mb-4">
                    <div class="col-12 col-sm-auto">
                        <div class="input-group">
                            <label class="input-group-text" for="tiempo">Tiempo asignado</label>
                            <input type="time" class="form-control" id="tiempo" name="tiempo" value="01:00"
                                min="00:10" max="05:00" required>
                            <div class="mt-1 invalid-feedback text-center">
                                Ingresa un tiempo válido.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button class="btn btnNuevo" type="submit">Registrar sesión</button>
                </div>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
    </main>
@endsection
