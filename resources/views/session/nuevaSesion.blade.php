@extends('layouts.authLayout')

@section('title')
    Nueva Sesión
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/session/createSession.js'])
@endsection

@section('main')
    <main class="d-flex justify-content-center">
        @if(count($listComputers) <= 0)
            <x-show-alert-component
                text="No hay equipos disponibles."
            />
        @else
            <div class="container-fluid mx-auto">
                <form id="formSesion" class="bg-light sombraBasica rounded-5 p-4 mx-sm-5" novalidate method="POST"
                      action="{{ route('session.store') }}">
                    @csrf
                    <h4 class="titulo text-center mb-3">Nueva sesión</h4>
                    <div class="row mb-4">
                        <div class="col d-flex align-items-center justify-content-center">
                            <div class="input-group w-auto">
                                <label for="numControl" class="input-group-text">Número de control</label>
                                <input
                                    type="text"
                                    class="form-control rounded-end-0 text-center @error("controlNumber") is-invalid @enderror"
                                    id="numControl"
                                    name="controlNumber"
                                    autocomplete="off"
                                    value="{{old("controlNumber")}}"
                                    required
                                >
                            </div>
                            @error("controlNumber")
                                <div class="mt-1 invalid-feedback text-center">
                                    {{$message}}
                                </div>
                            @enderror
                            <button
                                id="botonBuscar"
                                class="btn-yw-primary btn rounded-end-1 rounded-start-0"
                            >
                                Buscar
                            </button>
                        </div>
                        <div class="mt-1 text-center text-danger" id="msgNumControl"></div>
                    </div>

                    <div id="section-info-session" hidden >
                        <div class="d-flex flex-column justify-content-center gap-2 mb-2">
                            <div class="row justify-content-center gx-3 gy-2">
                                <div class="col-12 col-sm-6 col-lg-5 col-xl-4">
                                    <div class="input-group">
                                        <label class="input-group-text" for="nombre">Nombre</label>
                                        <input
                                            class="form-control info-student @error("name") is-invalid @enderror"
                                            type="text"
                                            id="nombre"
                                            name="name"
                                            autocomplete="off"
                                            value="{{old("name")}}"
                                            required
                                        >
                                        @error("name")
                                            <div class="mt-1 invalid-feedback text-center">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-lg-5 col-xl-4">
                                    <div class="input-group">
                                        <label class="input-group-text" for="apellidos">Apellidos</label>
                                        <input
                                            class="form-control info-student @error("lastName") is-invalid @enderror"
                                            type="text"
                                            id="apellidos"
                                            name="lastName"
                                            autocomplete="off"
                                            required
                                            value="{{old("lastName")}}"
                                        >
                                        @error("lastName")
                                            <div class="mt-1 invalid-feedback text-center">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-10 col-md-7 col-lg-6 col-xl-5 mx-auto">
                                <div class="input-group">
                                    <label class="input-group-text" for="carrera">Carrera</label>
                                    <select
                                        class="form-select info-student @error("career") is-invalid @enderror"
                                        id="selectCarreras"
                                        name="career"
                                        required
                                    >
                                        @foreach($careers as $career)
                                            <option value="{{$career}}">
                                                {{$career}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("career")
                                        <div class="mt-1 invalid-feedback text-center">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-5 col-md-4 col-lg-3 col-xl-2 mx-auto">
                                <div class="input-group">
                                    <label class="input-group-text" for="semestre">Semestre</label>
                                    <input
                                        type="number"
                                        class="form-control info-student @error("semester") is-invalid @enderror"
                                        id="semestre"
                                        name="semester"
                                        min="1"
                                        max="13"
                                        required
                                        value="{{old("semester")}}"
                                    >
                                    @error("semester")
                                        <div class="mt-1 invalid-feedback text-center">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="hr mx-5 my-4" />

                        <div class="row justify-content-center gx-3 gy-2 mb-2">
                            <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-3">
                                <div class="input-group">
                                    <label class="input-group-text" for="uso">Uso</label>
                                    <select
                                        class="form-select @error("application") is-invalid @enderror"
                                        id="uso"
                                        name="application"
                                        required
                                    >
                                        @foreach($usesPrograms as $useProgram)
                                            <option value="{{$useProgram->id}}">
                                                {{$useProgram->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("application")
                                        <div class="mt-1 invalid-feedback text-center">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-auto">
                                <div class="input-group">
                                    <label class="input-group-text" for="equipos">Equipo</label>
                                    <select
                                        class="form-select @error("computer") is-invalid @enderror"
                                        id="equipos"
                                        name="computer"
                                        required
                                    >
                                        @foreach($listComputers as $computer)
                                            <option value="{{$computer->id}}">
                                                {{$computer->computer_number}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("computer")
                                        <div class="mt-1 invalid-feedback text-center">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-1 text-center text-danger" id="msgEquipo"></div>
                        </div>

                        <div class="row justify-content-center gx-3 gy-2 mb-4">
                            <div class="col-12 col-sm-auto">
                                <div class="input-group">
                                    <label class="input-group-text" for="tiempo">Tiempo asignado</label>
                                    <input
                                        type="time"
                                        class="form-control @error("timeAssigment") is-invalid @enderror"
                                        id="tiempo"
                                        name="timeAssigment"
                                        value="01:00"
                                        min="00:01"
                                        max="05:00"
                                        required
                                    >
                                    @error("timeAssigment")
                                        <div class="mt-1 invalid-feedback text-center">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-yw-primary fw-medium" type="submit">Registrar sesión</button>
                        </div>
                    </div>
                </form>
            </div>
            @if ($errors->any())
                <script>
                    const errors = @json($errors->messages());
                </script>
            @endif
        @endif
    </main>
@endsection
