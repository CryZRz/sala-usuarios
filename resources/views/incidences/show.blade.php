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
                    <button type="button" class="btn btn-sm btn-turquesa lh-md fw-bold" data-bs-toggle="modal"
                        data-bs-target="#modalCrear">Registrar incidencia</button>
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
                    {{ $incidencias[0]->studentUpdate->student->lastName . ' ' . $incidencias[0]->studentUpdate->student->name }}:
                @endif
                @if ($muestra == 'resueltas')
                    Incidencias resueltas:
                @endif
                @if ($muestra == 'activas')
                    Incidencias activas:
                @endif
            </h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered sombraBasica">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Alumno</th>
                            <th>Descripción</th>
                            <th>Estatus</th>
                            <th>Alta</th>
                            @if ($muestra == 'estudiante' || $muestra == 'resueltas')
                                <th>Resolución</th>
                            @endif
                            <th>Actualización</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incidencias as $incidencia)
                            <tr>
                                <td>{{ $indice = $loop->index + 1 }}</td>
                                <td>{{ $incidencia->studentUpdate->controlNumber .
                                    ' - ' .
                                    ($incidencia->studentUpdate->student->nombreCompleto =
                                        $incidencia->studentUpdate->student->lastName . ' ' . $incidencia->studentUpdate->student->name) }}
                                </td>
                                <td>{{ $incidencia->descripción }}</td>
                                <td>{{ $incidencia->estatus }}</td>
                                <td>{{ $incidencia->fecha_alta->format('d/m/y H:i') }}</td>
                                @if ($muestra == 'estudiante' || $muestra == 'resueltas')
                                    @if (isset($incidencia->fecha_baja))
                                        <td>{{ $incidencia->fecha_baja->format('d/m/y H:i') }}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                @endif
                                <td>{{ $incidencia->fecha_actualización->format('d/m/y H:i') }}
                                <td>
                                    <div class="d-md-flex justify-content-center">
                                        <a class="btn btn-turquesa btn-sm me-1 p-0 p-md-1 w-100 fw-bold lh-1 d-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="{{ '#infoAlumno' . $indice }}">
                                            Info.
                                        </a>

                                        <a class="btn btn-verde btn-sm me-1 p-0 p-md-1 w-100 fw-bold lh-1"
                                            data-bs-toggle="modal" data-bs-target="{{ '#modalActualizar' . $indice }}">
                                            Actualizar descripción
                                        </a>

                                        @if (!isset($incidencia->fecha_baja))
                                            <a class="botonFin btn btn-secondary btn-sm me-1 p-0 p-md-1 w-100 fw-bold"
                                                data-ruta-fin="{{ route('incidence.destroy', $incidencia->id) }}"
                                                data-bs-toggle="modal" data-bs-target="#modalFin">Finalizar
                                            </a>
                                        @endif

                                        <!-- Ventana emergente para el botón Info. -->
                                        <div class="modal fade" id="{{ 'infoAlumno' . $indice }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title titulo">Detalles</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <h5 class="titulo">Incidencia:</h5>
                                                            </thead>
                                                            <tbody class="tablaEquitativa">
                                                                <tr>
                                                                    <td>Número de incidencia</td>
                                                                    <td>{{ $indice }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Descripción</td>
                                                                    <td>{{ $incidencia->descripción }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fecha de alta</td>
                                                                    <td>{{ $incidencia->fecha_alta->format('d/m/y H:i') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fecha de última actualización</td>
                                                                    <td>{{ $incidencia->fecha_actualización->format('d/m/y H:i') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Estatus</td>
                                                                    <td>{{ $incidencia->estatus }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <h5 class="titulo">Alumno:</h5>
                                                            </thead>
                                                            <tbody class="tablaEquitativa">
                                                                <tr>
                                                                    <td>Número de control</td>
                                                                    <td>{{ $incidencia->studentUpdate->controlNumber }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nombre</td>
                                                                    <td>{{ $incidencia->studentUpdate->student->nombreCompleto }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Carrera</td>
                                                                    <td>{{ $incidencia->studentUpdate->career }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Semestre</td>
                                                                    <td>{{ $incidencia->studentUpdate->semester }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <h5 class="titulo">Creado por:</h5>
                                                            </thead>
                                                            <tbody class="tablaEquitativa">
                                                                <tr>
                                                                    <td>Nombre</td>
                                                                    <td>{{ $incidencia->owner->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td>{{ $incidencia->owner->email }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-turquesa"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ventana emergente para el botón Actualizar -->
                                        <div class="modal fade" id="{{ 'modalActualizar' . $indice }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title titulo">Actualizar incidencia</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="form-crear-incidencia" method="POST"
                                                        action="{{ route('incidence.update') }}">
                                                        @csrf
                                                        <div class="modal-body text-center mb-2 mx-3 mx-sm-5 ">
                                                            <input type="text" name="id"
                                                                value="{{ $incidencia->id }}" hidden>
                                                            <div class="d-flex flex-column gap-1 mt-2">
                                                                <label for="descripción"
                                                                    class="form-label text-center fw-bold">Detalles</label>
                                                                <textarea type="text" class="form-control" name="descripción" id="descripción" required>{{ $incidencia->descripción }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="submit" class="btn btn-turquesa"
                                                                value="Confirmar">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                        @endforeach

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
                                        <form id="formFinIndividual" method="POST" action="">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-turquesa">Finalizar</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Regresar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </tbody>
                </table>
            </div>
            <section class="mt-3">
                @if ($incidencias instanceof \Illuminate\Pagination\AbstractPaginator)
                    {{ $incidencias->links() }}
                @endif
            </section>
        </div>
    </main>
@endsection
