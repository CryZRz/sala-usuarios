@extends('layouts.authLayout')

@section('title')
    Sala de usuarios
@endsection

@section('vite') 
    @vite(['resources/js/session/show.js'])
@endsection

@section('main')
    <main>
        <!-- Menú desplegable de acciones-->
        <div class=" container-fluid pt-2 pb-3">
            <div class="d-flex justify-content-center">
                <div class="w-auto bg-light rounded-5 px-4 py-3 sombraBasica">
                    <div class="d-inline-flex ">
                        <a type="button" class="btn btn-sm btnNuevo me-3" href="{{ route('session.new') }}">Nueva sesión</a>
                        <button type="button" class="btn btn-sm btnReasignar me-3" data-bs-toggle="modal"
                            data-bs-target="#modalReasignarGeneral">Reasignar equipo</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modalTerminar">Terminar sesión</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recuadro de la tabla de sesiones de préstamo-->
        <div class="container-fluid mx-auto">
            <h4 class="titulo text-center">Sesiones de préstamo:</h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered sombraBasica">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>N° equipo</th>
                            <th>N° control</th>
                            <th>Alumno</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Tiempo</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sesiones as $sesion)
                            <tr>
                                <td>{{ $indice = $loop->index + 1 }}</td>
                                <td>{{ $sesion->computer_id }}</td>
                                <td>{{ $sesion->student_id }}</td>
                                <td>{{ $sesion->nombreAlumno }}</td>
                                <td>{{ $sesion->horaInicio }}</td>
                                <td>{{ $sesion->horaFin }}</td>
                                <td>{{ $sesion->timeAssigment }}</td>
                                <td>
                                    <div class="d-md-flex justify-content-center">
                                        <a class="btn btnNuevo btn-sm me-1 p-0 p-md-1 w-100" data-bs-toggle="modal"
                                            data-bs-target="{{ '#infoAlumno' . $indice }}">
                                            Info.
                                        </a>

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
                                                                <h5 class="titulo">Préstamo:</h5>
                                                            </thead>
                                                            <tbody class="tablaEquitativa">
                                                                <tr>
                                                                    <td>Número de préstamo</td>
                                                                    <td>{{ $indice }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Número de equipo</td>
                                                                    <td>{{ $sesion->computer_id }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tiempo asignado</td>
                                                                    <td>{{ $sesion->timeAssigment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Hora de inicio</td>
                                                                    <td>{{ $sesion->horaInicio }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Hora de fin</td>
                                                                    <td>{{ $sesion->horaFin }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Uso</td>
                                                                    <td>{{ $sesion->uso }}</td>
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
                                                                    <td>{{ $sesion->student_id }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nombre</td>
                                                                    <td>{{ $sesion->nombreAlumno }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Carrera</td>
                                                                    <td>{{ $sesion->carrera }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Semestre</td>
                                                                    <td>{{ $sesion->semestre }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btnNuevo"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a class="botonReasignar btn btnReasignar btn-sm me-1 p-0 p-md-1 w-100"
                                            data-ruta-reasignar="{{ route('session.reassign', ['numSesion' => $sesion->id]) }}"
                                            data-bs-toggle="modal" data-bs-target="#infoReasignar">
                                            Reasignar
                                        </a>

                                        <a class="botonFin btn btn-secondary btn-sm me-1 p-0 p-md-1 w-100"
                                            data-ruta-fin="{{ route('session.destroy', $sesion->id) }}"
                                            data-bs-toggle="modal" data-bs-target="#infoFin">
                                            Fin
                                        </a>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Ventana emergente para el botón Reasignar -->
                        <div class="modal fade" id="infoReasignar" tabindex="-1">
                            <form id="formReasignarIndividual" method="POST" action="">
                                @csrf
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title titulo">Reasignar equipo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <label for="numEquipo" class="form-label mb-1 fw-bold me-3">Nuevo
                                                    equipo</label>
                                                <select class="form-select w-auto" name="numEquipo"
                                                    id="equipoReasignadoIndividual">
                                                </select>
                                            </div>
                                            <p id="msgReasignarIndividual" class="text-danger text-center mt-2 mb-0"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="confirmarReasignarIndividual" type="submit" class="btn btnNuevo"
                                                disabled>Reasignar</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Regresar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Ventana emergente para el botón Fin -->
                        <div class="modal fade" id="infoFin" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title titulo">Terminar sesión</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        ¿Deseas finalizar esta sesión de préstamo?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="modalFin" method="POST" action="">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btnNuevo">Finalizar</button>
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
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
    </main>
@endsection
