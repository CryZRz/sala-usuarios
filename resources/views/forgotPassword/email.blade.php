<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css'])
    <title>Email</title>
</head>
<body>
<header>
    <section class="flex flex-col items-center justify-center w-full">
        <img class="p-2" src="/images/tecnmLG.png" alt="tecnm-logo">
        <h2 class="text-xl font-extralight text-brand-primary mt-3 uppercase">Hola {{$name}}</h2>
        <h1 class="font-bold text-brand-primary text-3xl">¿Olvisaste tu contraseña?</h1>
    </section>
</header>
<main class="">
    <section class="mt-10">
        <span class="text-center block text-lg w-[500px] mx-auto text-gray-800">
            Si ha perdido su contraseña o desea restablecerla, utilice el siguiente enlace para comenzar:
        </span>
        <div class="text-center">
            <a href="{{route("resetPassword.show", $token)}}">
                <p class="text-blue-400 underline">{{route("resetPassword.show", $token)}}</p>
            </a>
        </div>
    </section>
    <section class="mt-10">
        <p class="text-center w-[600px] mx-auto text-gray-700">
            Por razones de seguridad, te recomendamos realizar este proceso tan pronto como sea posible.
            Si no has solicitado restablecer tu contraseña o consideras que este correo ha sido enviado por error,
            por favor ignóralo.
            Tu contraseña actual seguirá siendo válida y no se realizarán cambios sin tu confirmación.
        </p>
        <div class="w-full flex justify-center items-center mt-10">
            <a class="block bg-brand-primary text-white w-96 rounded-md p-1 text-center"
               href="{{route("resetPassword.show", $token)}}">
                Restablecer su contraseña
            </a>
        </div>
    </section>
    <section  class="text-brand-primary mt-10 flex items-center justify-center gap-2">
        <a href="https://www.facebook.com/TecNMITLeon" class="text-decoration-none h3">
            <i class="bi bi-facebook text-xl"></i>
        </a>
        <a href="https://twitter.com/TecNM_ITLeon" class="text-decoration-none h3">
            <i class="bi bi-twitter-x text-xl"></i>
        </a>
        <a href="https://www.instagram.com/tecnm_itleon/" class="h3 text-decoration-none">
            <i class="bi bi-instagram text-xl"></i>
        </a>
        <a href="https://leon.tecnm.mx/" class="h3 text-decoration-none">
            <i class="bi bi-globe text-xl"></i>
        </a>
    </section>
    <hr class="bg-brand-primary">
    <section class="flex justify-center items-center flex-col mt-6">
        <img class="w-16 mx-a" src="/images/logoITL.png" alt="itl logo">
        <span class="mt-1 p-2 font-bold text-xs text-center">
            Sala de Usuarios<br>
            Instituto Tecnlogico Nacional de México en León</span>
    </section>
</main>
</body>
</html>
