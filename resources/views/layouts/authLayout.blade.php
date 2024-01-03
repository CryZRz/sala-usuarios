<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @yield("vite")
</head>
<body>
    <header class="sticky-top bg-black mb-2">
        <nav class="navbar navbar-dark navbar-expand-sm sticky-top sombraDegradado mb-3">
            <div class="container-fluid">
              <img src="/images/logoITL.png" class="img-fluid rounded-top me-3" style="max-width:60px;" alt="Logo ITL">
              <a class="navbar-brand fw-bold" href="/">
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
                    <a class="nav-link dropdown-toggle active" id="dropSesiones" role="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Sesiones
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropSesiones">
                      <li><a class="dropdown-item" href="prestamos.html">Ver sesiones</a></li>
                      <div class="dropdown-divider"></div>
                      <li><a class="dropdown-item active" href="nuevaSesion.html">Nueva sesión</a></li>
                      <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reasignar">Reasignar equipo</a>
                      </li>
                      <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#terminar" href="#">Terminar
                          sesión</a></li>
                    </ul>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropEquipos" role="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Equipos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropEquipos">
                      <li><a class="dropdown-item" href="equipos.html">Todos los equipos</a></li>
                      <li><a class="dropdown-item" href="equipos.html">Equipos disponibles</a></li>
                      <li><a class="dropdown-item" href="equipos.html">Equipos ocupados</a></li>
                    </ul>
                  </li>
                </ul>
                <!-- Parte derecha -->
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a id="dropCuenta" class="link-light" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-person-circle fs-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropCuenta">
                      <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#avisoCambio">Cambiar contraseña</a>
                      </li>
                      <div class="dropdown-divider"></div>
                      <li>
                        <form class="dropdown-item" action="{{route("login.destroy")}}" method="POST">
                          @csrf
                          @method("delete")
                          <input class="btn btn-danger col-12" type="submit" value="Cerrar sesion">
                        </form>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
    </header>
    @yield("main")
    <!--Footer-->
</body>
</html>