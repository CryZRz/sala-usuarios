@extends('layouts.authLayout')

@section('title')
    Sala de usuarios
@endsection

@section('vite')
    @vite(['resources/js/incidence/show.js'])
@endsection

@section('main')
    <main>
        <!-- Menú desplegable de acciones-->
        <div class="container-fluid my-3 d-flex justify-content-center">
            <div class="w-auto bg-light rounded-5 px-4 py-3 sombraBasica">
                <div class="d-inline-flex flex-wrap gap-1 gap-sm-3 justify-content-center">
                    <a href="{{route("incidence.create")}}" class="btn btn-sm btn-turquesa lh-md fw-bold">
                        Registrar incidencia
                    </a>
                    <button type="button" class="btn btn-sm btn-verde lh-md fw-bold" data-bs-toggle="modal"
                        data-bs-target="#modalActualizar">Buscar incidencia</button>
                    @if ($muestra == 'estudiante' || $muestra == 'resueltas')
                        <a type="button" class="btn btn-sm text-light btn-warning lh-md fw-bold"
                            href="{{ route('incidence.show') }}">Regresar a ver incidencias activas</a>
                    @endif
                    @if ($muestra == 'activas')
                        <a type="button" class="btn btn-sm btn-secondary lh-md fw-bold"
                            href="{{ route('incidence.showSolved') }}">Ver incidencias resueltas</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recuadro de la tabla de sesiones de préstamo-->
        <div class="container-fluid mx-auto px-md-5">
            <h4 class="titulo text-center">
                @if ($muestra == 'estudiante')
                    Incidencias de
                    {{ $infoStudent->student->last_name_first }}:
                @endif
                @if ($muestra == 'resueltas')
                    Incidencias resueltas:
                @endif
                @if ($muestra == 'activas')
                    Incidencias activas:
                @endif
            </h4>
            <div class="table-responsive d-flex gap-3 flex-wrap">
                @foreach($incidencias as $index => $incidence)
                    <div class="card rounded-3" style="width: 18rem;">
                        <a
                            class="card-header mx-auto border-0 d-block"
                            href="{{route('incidence.showOne', $incidence->id)}}"
                        >
                            <i class="bi bi-person-square" style="font-size: 4.5rem"></i>
                        </a>
                        <div class="card-body py-2 px-3 border-1">
                            <div class="">
                                <p class="col-12 fw-bold m-0">Alumno:</p>
                                <p class="col-12 m-0">
                                    {{$incidence->studentUpdate->student->last_name_first }}
                                    -
                                    {{$incidence->studentUpdate->controlNumber}}
                                </p>
                            </div>
                            @if ($muestra == 'estudiante' || $muestra == 'resueltas')
                                @if (isset($incidence->deleted_at))
                                    <p class="fw-bold m-0">Resolución</p>
                                    <p class="m-0">{{$incidence->deleted_at}}</p>
                                @else
                                    <p class="fw-fold">Resolución</p>
                                    <p>-</p>
                                @endif
                            @endif
                            <div class="mt-1">
                                <p class="fw-bold m-0">Descripción:</p>
                                <p class="m-0">
                                    @if(strlen($incidence->description) < 50)
                                        {{$incidence->description  }}
                                    @else
                                        {{substr($incidence->description, 0, 50)}}...
                                    @endif
                                </p>
                            </div>
                            <div class="mt-1">
                                <p class="d-inline col-12 fw-bold m-0">Estatus:</p>
                                <p class="d-inline col-12 m-0">{{$incidence->status_text}}</p>
                            </div>
                            <div class="mt-1">
                                <p class="col-12 fw-bold m-0">Creado a:</p>
                                <p class="col-12 m-0">{{$incidence->created_at}}</p>
                            </div>
                            <div class="mt-1">
                                <p class="col-12 fw-bold m-0">Actulizado a:</p>
                                <p class="m-0">
                                    {{$incidence->updated_at}}
                                </p>
                            </div>
                        </div>
                        <div class="card-footer p-2 d-flex flex-column gap-1">
                            <a
                                class="btn col-12 btn-success btn-sm me-1 p-0 p-md-1 mb-1    fw-bold"
                                data-bs-toggle="modal"
                                data-bs-target="{{'#modalActualizar'.$index}}"
                            >
                                Actualizar descripción
                            </a>

                            @if (!isset($incidence->fecha_baja))
                                <a
                                    class="btn btn-primary btn-sm me-1 p-0 p-md-1 w-100 fw-bold btn-end-incidence"
                                    id-incidence="{{$incidence->id}}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalFin"
                                >
                                    Finalizar
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Ventana emergente para el botón Actualizar -->
                    <div class="modal fade" id="{{'modalActualizar'.$index}}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title titulo">
                                        Actualizar incidencia
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    >
                                    </button>
                                </div>
                                <form
                                    id="form-crear-incidencia"
                                    method="POST"
                                    action="{{ route('incidence.update', $incidence->id) }}"
                                >
                                    <div class="modal-body text-center mb-2 mx-3 mx-sm-5 ">
                                        <div class="d-flex flex-column gap-1 mt-2">
                                            @method("PUT")
                                            @csrf
                                            <label
                                                for="description"
                                                class="form-label text-center fw-bold"
                                            >
                                                Detalles
                                            </label>
                                            <textarea
                                                type="text"
                                                class="form-control"
                                                name="description"
                                                id="description"
                                                required
                                            >{{ $incidence->description }}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input
                                            type="submit"
                                            class="btn btn-turquesa"
                                            value="Confirmar"
                                        >
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                        >
                                            Cerrar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Ventana emergente para el botón Fin -->
                    <div class="modal fade" id="modalFin" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title titulo">Finalizar incidencia</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    ¿Deseas finalizar esta incidencia?
                                </div>
                                <div class="modal-footer">
                                    <form id="formEndIncidence" method="POST" action="">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-turquesa">
                                            Finalizar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                            Regresar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <section class="mt-3">
                {{ $incidencias->links() }}
            </section>
        </div>
    </main>
@endsection
