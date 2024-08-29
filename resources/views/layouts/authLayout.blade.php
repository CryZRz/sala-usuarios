<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/scss/app.scss', 'resources/scss/authLayout.scss', 'resources/js/app.js', 'resources/js/session/navbarActions.js'])
    @yield('vite')
</head>

<body>
    <!-- Pantalla de carga durante la subida del registro -->
    <section id="section-loading"></section>

    <header class="sticky-top bg-black mb-2">
        <nav class="navbar navbar-dark navbar-expand-md sticky-top sombraDegradado mb-3">
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
                    <ul
                        class="navbar-nav mb-sm-0 d-flex flex-row gap-3 gap-md-0 align-items-top align-items-md-center justify-content-center">
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
                                        href="#">Terminar sesión</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Str::startsWith(Route::currentRouteName(), 'computer.') ? 'active' : '' }}"
                                id="dropEquipos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Equipos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropEquipos">
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('computer.show') ? 'active' : '' }}"
                                        href="{{ route('computer.show') }}">Ver equipos</a></li>
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('computer.create') ? 'active' : '' }}"
                                        href="{{ route('computer.create') }}">Nuevo equipo</a></li>
                                <div class="dropdown-divider"></div>
                                <li>
                                    <a class="dropdown-item btn" href="{{route('program.show')}}">
                                        Programas
                                    </a>
                                </li>
                                <div class="dropdown-divider"></div>
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('computer.showUses') ? 'active' : '' }}"
                                    href="{{ route('computer.showUses') }}">Ver tipos de uso</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle  {{ Str::startsWith(Route::currentRouteName(), 'incidence.') ? 'active' : '' }}"
                                id="dropIncidencias" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Incidencias
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropIncidencias">
                                <li>
                                    <a
                                        class="dropdown-item btn {{ Route::currentRouteNamed('incidence.show') ? 'active' : '' }}"
                                        href="{{ route('incidence.show') }}"
                                    >
                                        Ver incidencias activas
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item btn {{ Route::currentRouteNamed('incidence.showFinished') ? 'active' : '' }}"
                                        href="{{ route('incidence.showSolved') }}"
                                    >
                                        Ver incidencias resueltas
                                    </a>
                                </li>
                                <div class="dropdown-divider"></div>
                                <li>
                                    <a
                                        class="dropdown-item btn"
                                        href="{{route("incidence.create")}}"
                                    >
                                        Registrar incidencia
                                    </a>
                                </li>
                                <li><a class="dropdown-item btn" data-bs-toggle="modal"
                                        data-bs-target="#modalActualizar">Buscar incidencia</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Parte derecha -->
                    <ul
                        class="navbar-nav d-flex flex-row justify-content-center align-items-top align-items-md-center gap-3 gap-md-0">
                        <li class="nav-item dropdown me-sm-4">
                            <a class="nav-link dropdown-toggle
                            {{ Str::startsWith(Route::currentRouteName(), 'report') ||
                            Str::startsWith(Route::currentRouteName(), 'register') ||
                            Str::startsWith(Route::currentRouteName(), 'import')
                                ? 'active'
                                : '' }}"
                                id="dropSesiones" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Herramientas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropSesiones">
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('reports.show') ? 'active' : '' }}"
                                        href="{{ route('reports.show') }}">Generar reporte</a></li>
                                <div class="dropdown-divider"></div>
                                <li><a class="dropdown-item btn lh-sm {{ Route::currentRouteNamed('register.show') ? 'active' : '' }}"
                                        href="{{ route('register.show') }}">Registrar<br>administrador</a></li>
                                <div class="dropdown-divider"></div>
                                <li><a class="dropdown-item btn {{ Route::currentRouteNamed('import.show') ? 'active' : '' }}"
                                        href="{{route('importe.show')}}">Importar alumnos</a></li>
                                <li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="dropCuenta" class="link-light" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle fs-1"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="dropCuenta">
                                <p class="text-center text-light btn-sm rounded-0 fw-bold w-100 p-1 mt-2 mb-2">
                                    {{ auth()->user()->name }}
                                </p>
                                <li><a class="btn btn-secondary btn-sm rounded-0 fw-bold w-100 p-1 text-nowrap"
                                        data-bs-toggle="modal" data-bs-target="#avisoCambio">Cambiar contraseña</a>
                                </li>
                                <li>
                                    <a id="btnCierre" class="btn btn-danger btn-sm rounded-0 fw-bold w-100 p-1 mb-2"
                                        data-bs-target="#avisoCierre">Cerrar sesión</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <!-- Ventana emergente para el confirmar cerrar sesión -->
    <div class="modal fade" id="avisoCierre" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title titulo">Cerrar sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p id="msgCierre"></p>
                    <p>¿Deseas finalizar los préstamos automáticamente, o dejarlos activos para al siguiente
                        administrador?</p>
                </div>
                <div class="modal-footer">
                    <form id="formCierre" action="{{ route('login.destroy') }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" name="accion" value="salir" class="btn btn-turquesa">Dejarlos
                            activos</button>
                        <button type="submit" name="accion" value="finalizar"
                            class="btn btn-secondary">Finalizarlos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana emergente para el botón Cambiar contraseña -->
    <div class="modal fade" id="avisoCambio" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title titulo">Cambio de contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3 px-4">
                    <p class="mb-2 text-center">¿Deseas cambiar tu contraseña?</p>
                    <p class="mb-0">Se enviará un correo de confirmación al correo
                        vinculado a esta cuenta.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-turquesa">Enviar correo</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana emergente para el botón Reasignar -->
    <x-end-session-component></x-end-session-component>

    <!-- Ventana emergente para el botón de actualizar incidencia -->
    <div class="modal fade" id="modalActualizar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title titulo">Buscar incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formBuscarIncidencia" method="GET" action="{{ route('incidence.showStudent') }}">
                    <div class="modal-body text-center mb-2">
                        <div class="d-flex flex-column mx-3 mx-sm-5 gap-2">
                            <div class="input-group d-flex flex-column gap-1 justify-content-center">
                                <label id="" for="controlNumber" class="fw-bold text-center">Número de
                                    control del
                                    alumno</label>
                                <input type="text" class="form-control text-center w-100" id="numControlReasignar"
                                    placeholder="Núm. control" name="controlNumber" autocomplete="off" required>
                            </div>
                            <p id="msgBuscarIncidencia" class="text-success mt-2 mb-0 text-center"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-turquesa" data-bs-dismiss="modal">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @yield('main')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
</body>

</html>
