<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/scss/app.scss', 'resources/scss/utils/colors.scss', 'resources/scss/utils/sizes.scss'])
    <title>Email</title>
</head>
<body>
<header>
    <section class="d-flex flex-column justify-content-center align-items-center w-100">
        <img class="p-2" src="/images/tecnmLG.png" alt="tecnm-logo">
        <h2 class="h2 fw-bold color-azul-tecnm mt-3 text-uppercase">Hola {{$name}}</h2>
        <h1 class="h2 fw-bold color-azul-tecnm">¿Olvisaste tu contraseña?</h1>
    </section>
</header>
<main class="container">
    <section class="mt-5">
        <span class="text-center d-block fs-6">
            Si ha perdido su contraseña o desea restablecerla, utilice el siguiente enlace para comenzar:
        </span>
        <div class="text-center">
            <a href="{{route("resetPassword.show", $token)}}">
                <p>{{route("resetPassword.show", $token)}}</p>
            </a>
        </div>
    </section>
    <section class="mt-4">
        <p class="text-center">
            Por razones de seguridad, te recomendamos realizar este proceso tan pronto como sea posible.
            Si no has solicitado restablecer tu contraseña o consideras que este correo ha sido enviado por error,
            por favor ignóralo.
            Tu contraseña actual seguirá siendo válida y no se realizarán cambios sin tu confirmación.
        </p>
        <div class="d-flex align-items-center justify-content-center mt-4 p-2">
            <a class="bg-azul-tecnm text-white text-decoration-none p-2 px-4 rounded-4 fw-bold"
               href="{{route("resetPassword.show", $token)}}">
                Restablecer su contraseña
            </a>
        </div>
    </section>
    <section  class="color-azul-tecnm mt-4 d-flex align-items-center justify-content-center gap-2">
        <a href="https://www.facebook.com/TecNMITLeon" class="text-decoration-none h3">
            <i class="bi bi-facebook"></i>
        </a>
        <a href="https://twitter.com/TecNM_ITLeon" class="text-decoration-none h3">
            <i class="bi bi-twitter-x"></i>
        </a>
        <a href="https://www.instagram.com/tecnm_itleon/" class="h3 text-decoration-none">
            <i class="bi bi-instagram "></i>
        </a>
        <a href="https://leon.tecnm.mx/" class="h3 text-decoration-none">
            <i class="bi bi-globe h3"></i>
        </a>
    </section>
    <hr class="color-azul-tecnm">
    <section class="d-flex align-items-center justify-content-center flex-column mt-4">
        <img class="w-16 mx-a" src="/images/logoITL.png" alt="itl logo">
        <span class="mt-1 p-2 fw-bold ">Instituto Tecnlogico Nacional de México en León</span>
    </section>
</main>
</body>
</html>
