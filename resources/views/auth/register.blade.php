<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sala de usuarios</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    @vite(['resources/scss/app.scss', 'resources/scss/auth/register.scss'])
</head>
<body>
<main class="w-full vh-100 row g-0">
    <section class="section-left-container col-lg-7 col-md-7 col-sm-12">

    </section>
    <section class="col-lg-5 col-md-5 col-sm-12 h-full section-right-container">
        <div class="w-full d-flex justify-content-center align-items-center">
            <div class="login-container rounded col-12">
                <section class="login-header d-flex justify-content-center align-items-center bg-azul-tecnm">
                    <img src="/images/tecnmLGWL.png" alt="logo-itl">
                </section>
                <section class="login-body d-flex flex-column justify-content-center ">
                    <form class="d-flex flex-column form-register" action="{{route("register.store")}}" method="post">
                        @csrf
                        <div class="mb-1">
                            <label class="col-12 small" for="email">Nombre</label>
                            <input
                                class="col-12"
                                type="text"
                                name="name"
                                placeholder="Ingresa tu nombre"
                                value="{{@old('name')}}"
                            >
                            @error("name")
                                <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label class="col-12 small" for="email">Correo</label>
                            <input
                                class="col-12"
                                type="email"
                                name="email"
                                value="{{@old('email')}}"
                                placeholder="Ingresa tu correo"
                            >
                            @error("email")
                                <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label class="col-12 small" for="password">Contraseña</label>
                            <input
                                class="col-12"
                                type="password"
                                name="pass"
                                value="{{@old('pass')}}"
                                placeholder="Ingresa tu contraseña"
                            >
                            @error("pass")
                            <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-12 small" for="password">Confirmar contraseña</label>
                            <input
                                class="col-12"
                                type="password"
                                name="confirm-password"
                                value="{{@old('confirm-password')}}"
                                placeholder="Confirma tu contraseña"
                            >
                            @error("confirm-password")
                                <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                            @enderror
                            @if(session("error"))
                                <p class="text-danger small m-0 fw-bold">
                                    {{session("error")}}
                                </p>
                            @endif
                        </div>
                        <div class="mb-2">
                            <button class="col-12 p-2 rounded btn-login">Registrar</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </section>
</main>
</body>
</html>
