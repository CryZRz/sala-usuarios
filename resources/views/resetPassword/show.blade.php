<!DOCTYPE html>
<html lang="es">
<head>
    <title>Sala de usuarios | Restablecer contraseña</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
<main class="w-full h-screen overflow-y-hidden flex">
    <section class="w-3/5 bg-login bg-no-repeat bg-cover relative">
        <section class="absolute w-full h-full bg-gradient-to-l from-white to-black/15">

        </section>
    </section>
    <section class="w-2/5 bg-white">
        <section class="w-full h-full flex justify-center items-center">
            <div class="w-3/4 shadow-2xl">
                <div class="h-40">
                    <div class="bg-[#1a325b] rounded-t-md h-full flex justify-center items-center">
                        <img class="w-24 h-34 mx-auto py-2" src="/images/tecnmLGW.png" alt="logo-itl">
                    </div>
                </div>
                <div class="border border-[#1a325b] rounded-b-md py-3 px-3">
                    <form action="{{ route('resetPassword.store') }}" method="POST"
                          class="bg-white w-full">
                        @csrf

                        <!-- Info -->
                        <div class="text-center space-y-1">
                            <span class="block text-lg font-bold text-gray-800">Restablecer contraseña</span>
                            <p class="text-gray-600 text-sm">
                                Ingresa la nueva contraseña para tu cuenta. Asegúrate de que coincidan.
                            </p>
                        </div>

                        <!-- Inputs -->
                        <div class="space-y-4 mt-6">
                            <div>
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Nueva contraseña"
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-0"
                                >
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">
                            </div>
                            <div>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Confirmar contraseña"
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-0"
                                >
                            </div>
                            @error("password")
                                <p class="text-red-400 text-xs font-semibold p-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="mt-6">
                            <button type="submit"
                                    class="w-full bg-brand-primary text-white py-2 px-4 rounded-lg font-bold cursor-pointer">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</main>
</body>
</html>
