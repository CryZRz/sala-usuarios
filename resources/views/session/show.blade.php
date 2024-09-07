@extends('layouts.authLayout')

@section('title')
    Sala de usuarios
@endsection

@section('vite')
    @vite(['resources/js/session/show.js'])
    @vite(['resources/js/session/counterManager.js'])
    @vite(['resources/js/session/manageSessionCheck.js'])
@endsection

@section('main')
    <main>
        <!-- Menú desplegable de acciones-->
        <div class="container mb-1 d-flex justify-content-center">
            <div class="col-12 bg-light px-4 py-3 sombraBasica">
                <div class="col-12 d-inline-flex flex-wrap gap-1 gap-sm-3 justify-content-center">
                    <a
                        type="button"
                        class="flex-fill btn btn-yw-primary lh-md fw-medium rounded-0 btn-sm"
                        href="{{ route('session.new') }}"
                    >
                        Nueva sesión
                    </a>
                    <button
                        type="button"
                        class="flex-fill btn btn-yw-primary lh-md fw-medium btn-sm rounded-0"
                        data-bs-toggle="modal"
                        data-bs-target="#modalReasignarGeneral"
                    >
                        Reasignar equipo
                    </button>
                    <button
                        type="button"
                        class="flex-fill btn btn-yw-primary btn-sm lh-md fw-medium rounded-0"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTerminar"
                    >
                        Terminar sesión
                    </button>
                    <button
                        type="button"
                        class="flex-fill btn btn-sm rounded-0 lh-md fw-medium"
                        id="btnTerminarMultiple"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTerminarMultiple"
                        disabled
                        style="background: #fbf304"
                    >
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
                            <button id="btnEndSelectSessions" type="submit" class="btn btn-turquesa">
                                Finalizar
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Regresar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(session("alert") != null)
            <div class="alert alert-primary p-2 mt-3 container" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{session("alert")}}</span>
            </div>
        @endif
        @foreach($errors->all() as $error)
            <div class="alert alert-danger p-2 mt-3 container" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{$error}}</span>
            </div>
        @endforeach
        <!-- Recuadro de la tabla de sesiones de préstamo-->
        <section class="d-flex gap-3 flex-wrap justify-content-center mt-3">
            @forelse ($sesiones as $sesion)
                <div class="card rounded-3" style="width: 18rem;">
                    <div class="col-12 px-2 py-1 text-end">
                        <input
                            class="rounded-2 form-check-input checkSesion"
                            data-id-sesion="{{ $sesion->id }}"
                            type="checkbox"
                        >
                    </div>
                    <div class="card-header mx-auto border-0">
                        <i class="bi bi-pc-display" style="font-size: 4.5rem"></i>
                    </div>
                    <div class="card-body py-2 px-3 border-1">
                        <div class="">
                            <p class="col-12 fw-bold m-0">Alumno:</p>
                            <p class="col-12 m-0">
                                {{$sesion->student->full_name}}
                                -
                                {{$sesion->studentUpdate->controlNumber}}
                            </p>
                        </div>
                        <div class="mt-1">
                            <p class="d-inline fw-bold m-0">N°equipo:</p>
                            <p class="d-inline m-0">{{$sesion->computer->computer_number}}</p>
                        </div>
                        <div class="mt-1">
                            <p class="d-inline col-12 fw-bold m-0">Horario:</p>
                            <p class="d-inline col-12 m-0">{{$sesion->timeInterval}}</p>
                        </div>
                        <div class="mt-1">
                            <p class="d-inline col-12 fw-bold m-0">Tiempo asignado:</p>
                            <p class="d-inline col-12 m-0">{{$sesion->timeAssigment}}</p>
                        </div>
                        <div class="mt-1">
                            <p class="col-12 fw-bold m-0">Tiempo restante:</p>
                            <p class="m-0" id="timeAssigment" sessionId="{{ $sesion->id }}">
                                {{$sesion->remainingTime}}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer p-2 d-flex flex-column gap-1">
                        <a class="botonReasignar btn btn-success btn-sm me-1 p-0 p-md-1 w-100 fw-bold"
                           sessionId="{{$sesion->id}}"
                           data-bs-toggle="modal" data-bs-target="#infoReasignar">
                            Reasignar
                        </a>
                        <a class="botonFin btn btn-primary btn-sm me-1 p-0 p-md-1 w-100 fw-bold"
                           sessionId="{{$sesion->id}}"
                           data-bs-toggle="modal" data-bs-target="#infoFin">
                            Fin
                        </a>
                    </div>
                </div>
            @empty

            @endforelse
        </section>

                        <!-- Ventana emergente para el botón Reasignar -->
                        <div class="modal fade" id="infoReasignar" tabindex="-1">
                            <form id="formReasignarIndividual" method="POST" action="{{route("session.reassign")}}">
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
                                                <select class="form-select w-auto" name="computerNumber"
                                                    id="list-computers-re-using">
                                                </select>
                                                <input type="hidden" name="sessionId" value="0" id="change-computer-input">
                                            </div>
                                            <p id="msgReasignarIndividual" class="text-danger text-center mt-2 mb-0"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="confirmarReasignarIndividual" type="submit" class="btn btn-turquesa">
                                                Reasignar
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Regresar
                                            </button>
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
                                        <p id="msgFinIndividual" class="text-danger text-center mt-2 mb-0"></p>
                                    </div>
                                    <div class="modal-footer">
                                        <form id="formFinIndividual" method="POST" action="{{route("session.destroy")}}">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="sessionId" id="inputEndSession">
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
                            <section class="text-center w-75 mx-auto">
                                @csrf
                                <label class="fw-bold mb-1" for="Tiempo a asignar">Tiempo adicional</label>
                                <input name="idSession" type="hidden" id="idExtenSession">
                                <input name="timeSession" class="col-12 text-center" type="time" min="00:05" max="06:00" value="01:00">
                                <input type="submit" class="btn btn-primary col-12 btn-sm mt-2" value="Extender"></input>
                            </section>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
