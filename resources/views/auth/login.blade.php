<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <title>Inicio de sesion</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body>
    <main class="w-full h-screen overflow-y-hidden flex">
        <section class="w-3/5 bg-login bg-no-repeat bg-cover relative">
            <section class="absolute w-full h-full bg-gradient-to-l from-white to-black/15">

            </section>
        </section>
        <section class="w-2/5 ">
            <section class="w-full h-full flex justify-center items-center">
                <div class="w-3/4 shadow-2xl">
                    <div class="h-40">
                        <div class="bg-[#1a325b] rounded-t-md h-full flex justify-center items-center">
                            <img class="w-24 h-34 mx-auto py-2" src="/images/tecnmLGW.png" alt="logo-itl">
                        </div>
                    </div>
                    <div class="border border-[#1a325b] rounded-b-md">
                        <div class="p-3 py-4">
                            <h3 class="text-2xl text-gray-500 font-bold">Inicia sesion</h3>
                        </div>
                        <form class="d-flex flex-column" action="{{route("login.store")}}" method="post">
                            @csrf
                            <div class="mb-4 px-2">
                                <label class="block text-base text-gray-700" for="email">Correo</label>
                                <input
                                    class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                    type="email"
                                    name="email"
                                    placeholder="Ingresa tu correo"
                                >
                                @error("email")
                                    <p class="text-xs text-red-500 p-0">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3 px-2">
                                <label class="block text-base text-gray-700" for="password">Contraseña</label>
                                <input
                                    class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                    type="password"
                                    name="password"
                                    placeholder="Ingresa tu contraseña"
                                >
                                @error("password")
                                    <p class="text-xs text-red-500 p-0">{{$message}}</p>
                                @enderror
                                @if(session("error"))
                                    <p class="text-xs text-red-500 p-0">
                                        {{session("error")}}
                                    </p>
                                @endif
                            </div>
                            <div class="mb-2 px-2 mt-6">
                                <button class="w-full text-white bg-[#1a325b] p-1 rounded-md font-bold cursor-pointer">Entrar</button>
                            </div>
                            <div class="px-3 pb-3">
                                <a href="{{route("forgotPassword.show")}}" class="text-blue-400 underline text-sm">¿Olvidaste tu contraseña?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </section>
    </main>
</body>
</html>
