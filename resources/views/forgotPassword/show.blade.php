<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sala de usuarios</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body>
    <main>
        <section>
            <section class="relative w-full h-80 bg-forgot-password bg-no-repeat bg-cover">
                <div class="w-full h-full absolute bg-[rgba(26,50,91,0.3)]"></div>
            </section>
            <section>
                <form action="{{route('forgotPassword.store')}}" class="w-full flex items-center justify-center" method="POST">
                    @csrf
                    <div class="w-80 border border-brand-primary rounded-md absolute top-40 bg-white">
                        <div class="p-3">
                            <img class="w-24 h-24 mx-auto" src="/images/logoITL.png" alt="tecnm logo">
                        </div>
                        <div class="w-full text-center">
                            <span class="text-gray-800 font-bold">¿Olvidaste tu contraseña?</span>
                        </div>
                        <div>
                            <p class="text-gray-700 text-center text-md px-3 py-2">
                                Ingresa aqui tu correo y te enviaremos un
                                enlace para recuperarla
                            </p>
                        </div>
                        <div class="px-4 py-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <input
                                    type="text"
                                    id="input-group-1"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 outline-0"
                                    placeholder="Ingresa tu correo"
                                    name="email"
                                >
                            </div>
                            <div>
                                @error("email")
                                    <span class="text-red-500 text-xs mb-0 ">{{$message}}</span>
                                @enderror
                                @if(session("message") != null)
                                    <span class="text-yellow-300 ttext-xs mb-0">{{session("message")}}</span>
                                @endif
                                @if(session("success") != null)
                                    <span class="text-green-700 text-xs mb-0">{{session("success")}}</span>
                                @endif
                            </div>
                            <div class="px-1 py-3 mt-3">
                                <button class="bg-brand-primary text-white py-1 rounded-md w-full cursor-pointer">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </section>
    </main>
</body>
</html>
