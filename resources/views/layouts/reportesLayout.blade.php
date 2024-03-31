<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/scss/app.scss','resources/scss/utils/colors.scss', 'resources/scss/utils/sizes.scss'])
    @yield("vite")
    <title>
        @yield("title")
    </title>
</head>
<body>
<header class="w-100 d-flex justify-content-between bg-azul-tecnm align-items-center p-2">
    <section class="d-flex align-items-center">
        <div>
            <img class="w-20" src="/images/logoITL.png" alt="logo itl">
        </div>
        <div class="m-2">
            <h1 class="text-white fw-bold">SALA USUARIOS</h1>
        </div>
    </section>
    <section>
        <img class="w-16" src="/images/tecnmLGW.png" alt="tecnm logo">
    </section>
</header>
@yield("content")
</body>
</html>
