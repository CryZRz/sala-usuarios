<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sala de usuarios</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/scss/app.scss', 'resources/scss/auth/login.scss'])
</head>
<body>
    <main class="w-full vh-100 row g-0">
        <section class="section-left-container col-lg-7 col-md-7 col-sm-12">

        </section>
        <section class="col-lg-5 col-md-5 col-sm-12 h-full section-right-container">
            <div class="w-full d-flex justify-content-center align-items-center">
                <div class="login-container rounded col-12">
                    <section class="login-header d-flex justify-content-center align-items-center bg-azul-tecnm">
                        <img src="/images/tecnmLGW.png" alt="logo-itl">
                    </section>
                    <section class="login-body d-flex flex-column justify-content-center ">
                        <div>
                            <h3>Inicia sesion</h3>
                        </div>
                        <div>
                            <form class="d-flex flex-column" action="{{route("login.store")}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="col-12" for="email">Correo</label>
                                    <input
                                        class="col-12 p-1"
                                        type="email"
                                        name="email"
                                        placeholder="Ingresa tu correo"
                                    >
                                    @error("email")
                                        <p class="text-danger small m-0 fw-bold">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="col-12" for="password">Contraseña</label>
                                    <input
                                        class="col-12 p-1"
                                        type="password"
                                        name="password"
                                        placeholder="Ingresa tu contraseña"
                                    >
                                    @error("password")
                                        <p class="text-danger small m-0 fw-bold">{{$message}}</p>
                                    @enderror
                                    @if(session("error"))
                                        <p class="text-danger small m-0 fw-bold">
                                            {{session("error")}}
                                        </p>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <button class="col-12 p-2 rounded btn-login">Entrar</button>
                                </div>
                                <div>
                                    <a href="{{route("forgotPassword.show")}}" class="small ">¿Olvidaste tu contraseña?</a>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
