<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/scss/app.scss', 'resources/scss/styles.scss', 'resources/js/app.js', 'resources/js/session/navbarActions.js'])
    @yield('vite')
</head>

<body>
    <header class="sticky-top bg-black mb-2">
        <nav class="navbar navbar-dark navbar-expand-sm sticky-top sombraDegradado mb-3">
            <div class="container-fluid">
                <img src="/images/logoITL.png" class="img-fluid rounded-top me-3" style="max-width:60px;"
                    alt="Logo ITL">
                <a class="navbar-brand fw-bold" href="{{ route('session.show') }}">
                    Sala de Usuarios
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navColap"
                    aria-controls="navColap" aria-expanded="false" aria-label="menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Elementos que colapsan de la barra de navegación -->
                <div class="collapse navbar-collapse list-unstyled justify-content-between" id="navColap">
                    <!-- Parte izquierda -->
                    <ul class="navbar-nav mb-2 mb-sm-0 align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle  {{ Str::startsWith(Route::currentRouteName(), 'session.') ? 'active' : '' }}"
                                id="dropSesiones" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Sesiones
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropSesiones">
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('session.show') ? 'active' : '' }}"
                                        href="{{ route('session.show') }}">Ver sesiones</a></li>
                                <div class="dropdown-divider"></div>
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('session.new') ? 'active' : '' }}"
                                        href="{{ route('session.new') }}">Nueva sesión</a></li>
                                <li><a class="dropdown-item btn" data-bs-toggle="modal"
                                        data-bs-target="#modalReasignarGeneral">Reasignar equipo</a>
                                </li>
                                <li><a class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#modalTerminar"
                                        href="#">Terminar
                                        sesión</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Str::startsWith(Route::currentRouteName(), 'computer.') ? 'active' : '' }}"
                                href="#" id="dropEquipos" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Equipos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropEquipos">
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('computer.show') ? 'active' : '' }}"
                                        href="{{ route('computer.show') }}">Todos los
                                        equipos</a></li>
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('computer.show') ? 'active' : '' }}"
                                        href="{{ route('computer.show') }}"">Equipos
                                        disponibles</a></li>
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('computer.show') ? 'active' : '' }}"
                                        href="{{ route('computer.show') }}">Equipos
                                        ocupados</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Parte derecha -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a id="dropCuenta" class="link-light" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle fs-1"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="dropCuenta">
                                <li><a class="btn btn-secondary btn-sm rounded-0 fw-bold w-100 p-1 mt-2 text-nowrap"
                                        data-bs-toggle="modal" data-bs-target="#avisoCambio">Cambiar contraseña</a>
                                </li>
                                <li>
                                    <form action="{{ route('login.destroy') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input class="btn btn-danger btn-sm rounded-0 fw-bold w-100 p-1 mb-2" type="submit"
                                            value="Cerrar sesión">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Ventana emergente para el botón Cambiar contraseña -->
    <div class="modal fade" id="avisoCambio" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title titulo">Cambio de contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="m-0">¿Deseas cambiar tu contraseña?<br>Se enviará un correo de confirmación al correo
                        vinculado a
                        esta cuenta.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btnNuevo">Enviar correo</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana emergente para el botón Reasignar -->
    <div class="modal fade" id="modalReasignarGeneral" tabindex="-1">
        <form id="formReasignarGeneral" method="POST" action="{{ route('session.reassign') }}">
            @csrf
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title titulo">Reasignar equipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center text-sm-end mx-3 mx-sm-5">
                            <div class="row align-items-center mb-2">
                                <div class="col">
                                    <label for="numControl" class="form-label fw-bold">Número de control del
                                        alumno</label>
                                </div>
                                <div class="col">
                                    <input type="input" class="form-control" id="numControlReasignar"
                                        placeholder="Núm. control" name="numControl" required>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <label for="numEquipo" class="form-label fw-bold">Nuevo equipo</label>
                                </div>
                                <div class="col">
                                    <select id="equipoReasignadoGeneral" class="form-select" name="numEquipo"
                                        id="numEquipo" required>
                                    </select>
                                </div>
                            </div>
                            <p id="msgReasignarGeneral" class="text-danger mt-2 mb-0 text-center"> </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="confirmarReasignarGeneral" type="submit" class="btn btnNuevo"
                            disabled>Reasignar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Ventana emergente para el botón Terminar sesión -->
    <div class="modal fade" id="modalTerminar" tabindex="-1">
        <form id="formFin" method="POST" action="{{ route('session.destroy') }}">
            @csrf
            @method('delete')
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title titulo">Terminar sesión</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center text-sm-end mx-3 mx-sm-5">
                            <div class="row align-items-center mb-2">
                                <div class="col">
                                    <label for="opcionBuscar" class="form-label fw-bold">¿Cómo quieres ubicar la
                                        sesión?</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" name="opcionBuscar" id="opcionBuscar" required>
                                        <option value="numControl" required selected>Núm. de control</option>
                                        <option value="numEquipo" required>Núm. de equipo</option>
                                    </select>
                                </div>
                            </div>
                            <div id="busquedaNumControl" class="row align-items-center mb-2">
                                <div class="col">
                                    <label for="numControl" class="form-label fw-bold">Número de control del
                                        alumno</label>
                                </div>
                                <div class="col">
                                    <input type="input" class="form-control" id="numControlFin"
                                        placeholder="Núm. control" name="finNumControl" >
                                </div>
                            </div>
                            <div id="busquedaNumEquipo" class="row align-items-center" hidden>
                                <div class="col">
                                    <label for="numEquipo" class="form-label fw-bold">Número de equipo</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" name="finNumEquipo" id="selectEquiposFin" >
                                    </select>
                                </div>
                            </div>
                            <p id="msgFinGeneral" class="text-danger text-center mt-2 mb-0"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnFinGeneral" type="submit" class="btn btnNuevo">Finalizar la
                            sesión</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @yield('main')
    <!--Footer-->
</body>

</html>
