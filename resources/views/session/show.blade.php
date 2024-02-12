@extends('layouts.authLayout')

@section('title')
    Sala de usuarios
@endsection

@section('vite')
    @vite(['resources/js/session/show.js'])
    @vite(['resources/js/session/counterManager.js'])
@endsection

@section('main')
    <main>
        <!-- Menú desplegable de acciones-->
        <div class="container-fluid my-3 d-flex justify-content-center">
            <div class="w-auto bg-light rounded-5 px-4 py-3 sombraBasica">
                <div class="d-inline-flex flex-wrap gap-1 gap-sm-3 justify-content-center">
                    <a type="button" class="btn btn-sm btnNuevo lh-md fw-bold" href="{{ route('session.new') }}">Nueva
                        sesión</a>
                    <button type="button" class="btn btn-sm btnReasignar lh-md fw-bold" data-bs-toggle="modal"
                        data-bs-target="#modalReasignarGeneral">Reasignar equipo</button>
                    <button type="button" class="btn btn-sm btn-secondary lh-md fw-bold" data-bs-toggle="modal"
                        data-bs-target="#modalTerminar">Terminar sesión</button>
                    <button type="button" class="btn btn-sm btn-secondary lh-md fw-bold" id="btnTerminarMultiple"
                        data-bs-toggle="modal" data-bs-target="#modalTerminarMultiple" disabled>
                        Terminar seleccionadas</button>
                </div>
            </div>
        </div>

        <!-- Ventana emergente para el botón Terminar seleccionadas -->
        <div class="modal fade" id="modalTerminarMultiple" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title titulo">Terminar sesiones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        ¿Deseas finalizar las sesiones de préstamo seleccionadas?
                    </div>
                    <div class="modal-footer">
                        <form id="formFinMultiple" method="POST" action=""
                            data-ruta-fin-multiple="{{ route('session.destroyMany') }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btnNuevo">Finalizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recuadro de la tabla de sesiones de préstamo-->
        <div class="container-fluid mx-auto px-md-5">
            <h4 class="titulo text-center">Sesiones de préstamo</h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered sombraBasica">
                    <thead class="table-light">
                        <tr>
                            <th><input class="form-check-input" id="checkGlobal" type="checkbox"></th>
                            <th>#</th>
                            <th>N° equipo</th>
                            <th>Alumno</th>
                            <th>Horario</th>
                            <th>Tiempo asignado</th>
                            <th>Tiempo restante</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sesiones as $sesion)
                            <tr>
                                <th><input class="form-check-input checkSesion" data-id-sesion="{{ $sesion->id }}"
                                        type="checkbox"></th>
                                <td>{{ $indice = $loop->index + 1 }}</td>
                                <td>{{ $sesion->computer->id }}</td>
                                <td>{{ $sesion->student->controlNumber .
                                    ' - ' .
                                    ($sesion->nombreCompleto = $sesion->student->lastName . ' ' . $sesion->student->name) }}
                                </td>
                                <td>{{ $sesion->horario =
                                    $sesion->startTime->format('H:i') .
                                    ' - ' .
                                    $sesion->startTime->add(
                                            new DateInterval(
                                                'PT' . str_replace(':', 'H', $sesion->timeAssigment = substr($sesion->timeAssigment, 0, -3)) . 'M',
                                            ),
                                        )->format('H:i') }}
                                </td>
                                <td>{{ $sesion->timeAssigment }}</td>
                                <td id="timeAssigment" sessionId="{{ $sesion->id }}">{{ $sesion->timeAssigment }}</td>
                                <td>
                                    <div class="d-md-flex justify-content-center">
                                        <a class="btn btnNuevo btn-sm me-1 p-0 p-md-1 w-100 fw-bold" data-bs-toggle="modal"
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
                                                                    <td>{{ $sesion->computer->id }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tiempo asignado</td>
                                                                    <td>{{ $sesion->timeAssigment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Horario de sesión</td>
                                                                    <td>{{ $sesion->horario }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Uso</td>
                                                                    <td>{{ $sesion->application->name }}</td>
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
                                                                    <td>{{ $sesion->student->controlNumber }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nombre</td>
                                                                    <td>{{ $sesion->nombreCompleto }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Carrera</td>
                                                                    <td>{{ $sesion->student->career }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Semestre</td>
                                                                    <td>{{ $sesion->student->semester }}</td>
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

                                        <a class="botonReasignar btn btnReasignar btn-sm me-1 p-0 p-md-1 w-100 fw-bold"
                                            data-ruta-reasignar="{{ route('session.reassign', ['numSesion' => $sesion->id]) }}"
                                            data-bs-toggle="modal" data-bs-target="#infoReasignar">
                                            Reasignar
                                        </a>

                                        <a class="botonFin btn btn-secondary btn-sm me-1 p-0 p-md-1 w-100 fw-bold"
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
        <!--Modal extender session-->
        <div class="modal fade" id="idOption" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Extender sesión</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('session.changeTime') }}" method="POST">
                            <section>
                                @csrf
                                <label class="fw-bold mb-1" for="Tiempo a asignar">Tiempo a asignar</label>
                                <input name="idSession" type="hidden" id="idExtenSession">
                                <input name="timeSession" class="col-12" type="time">
                                <input type="submit" class="btn btn-primary col-12 btn-sm mt-2" value="Enviar"></input>
                            </section>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
    </main>
@endsection
