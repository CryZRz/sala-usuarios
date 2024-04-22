@extends('layouts.authLayout')

@section('title')
    Nueva Sesión
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/session/create.js'])
@endsection

@section('main')
    <main class="d-flex justify-content-center">
        <!-- Apartado del formulario -->
        <div class="container-fluid mx-auto">
            <form id="formSesion" class="bg-light sombraBasica rounded-5 p-4 mx-sm-5" novalidate method="POST"
                action="{{ route('session.store') }}">
                @csrf
                <h4 class="titulo text-center mb-3">Nueva sesión</h4>
                <div class="row mb-4">
                    <div class="col d-flex align-items-center justify-content-center">
                        <div class="input-group w-auto">
                            <label for="numControl" class="input-group-text">Número de control</label>
                            <input type="text" class="form-control text-center" id="numControl" name="numControl"
                                autocomplete="off" required>
                        </div>
                        <div class="mt-1 invalid-feedback text-center">
                            El número de control no es válido.
                        </div>
                        <button id="botonBuscar" type="button"
                            class="btn-secondary btn btn-sm fw-bold ms-2">Buscar</button>
                    </div>
                    <div class="mt-1 text-center text-danger" id="msgNumControl"></div>
                </div>

                <div class="d-flex flex-column justify-content-center gap-2 mb-2">
                    <div class="row justify-content-center gx-3 gy-2">
                        <div class="col-12 col-sm-6 col-lg-5 col-xl-4">
                            <div class="input-group">
                                <label class="input-group-text" for="nombre">Nombre</label>
                                <input class="form-control" type="text" id="nombre" name="nombre" autocomplete="off"
                                    required>
                                <div class="mt-1 invalid-feedback text-center">
                                    Ingresa el nombre del alumno.
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-5 col-xl-4">
                            <div class="input-group">
                                <label class="input-group-text" for="apellidos">Apellidos</label>
                                <input class="form-control" type="text" id="apellidos" name="apellidos"
                                    autocomplete="off" required>
                                <div class="mt-1 invalid-feedback text-center">
                                    Ingresa el apellido del alumno.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-10 col-md-7 col-lg-6 col-xl-5 mx-auto">
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

                    <div class="col-12 col-sm-5 col-md-4 col-lg-3 col-xl-2 mx-auto">
                        <div class="input-group">
                            <label class="input-group-text" for="semestre">Semestre</label>
                            <input type="number" class="form-control" id="semestre" name="semestre" min="1"
                                max="13" required>
                            <div class="mt-1 invalid-feedback text-center">
                                Ingresa el semestre del alumno.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="hr mx-5 my-4" />

                <div class="row justify-content-center gx-3 gy-2 mb-2">
                    <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-3">
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
                                min="00:01" max="05:00" required>
                            <div class="mt-1 invalid-feedback text-center">
                                Ingresa un tiempo válido.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button class="btn btn-turquesa fw-bold" type="submit">Registrar sesión</button>
                </div>
            </form>
        </div>

    </main>
@endsection
