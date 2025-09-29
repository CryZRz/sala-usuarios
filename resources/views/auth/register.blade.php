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
    <section class="w-3/5 bg-register bg-no-repeat bg-cover relative">
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
                <div class="border border-[#1a325b] pt-3 h-96 overflow-y-auto">
                    <form class="d-flex flex-column form-register" action="{{route("register.store")}}" method="post" id="formRegister">
                        @csrf
                        <div class="mb-2 px-3">
                            <label class="block text-base text-gray-700" for="username">Nombre usuario</label>
                            <input
                                id="username"
                                class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                type="text"
                                name="username"
                                placeholder="Ingresa tu nombre de usuario"
                                value="{{@old('username')}}"
                            >
                            @error("username")
                            <p class="text-xs text-red-500 p-0">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-2 px-3">
                            <label class="block text-base text-gray-700" for="name">Nombre</label>
                            <input
                                id="name"
                                class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                type="text"
                                name="name"
                                placeholder="Ingresa tu nombre"
                                value="{{@old('name')}}"
                            >
                            @error("name")
                                <p class="text-xs text-red-500 p-0">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-2 px-3">
                            <label class="block text-base text-gray-700" for="lastName">Apellidos</label>
                            <input
                                id="lastName"
                                class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                type="text"
                                name="lastName"
                                placeholder="Ingresa tus apellidos"
                                value="{{@old('lastName')}}"
                            >
                            @error("lastName")
                            <p class="text-xs text-red-500 p-0">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-2 px-3">
                            <label class="block text-base text-gray-700" for="email">Correo</label>
                            <input
                                id="email"
                                class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                type="email"
                                name="email"
                                value="{{@old('email')}}"
                                placeholder="Ingresa tu correo"
                            >
                            @error("email")
                                <p class="text-xs text-red-500 p-0">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="px-3 mb-2">
                            <div class="relative w-full" x-data="selectRoles()">
                                <label class="block text-base text-gray-600">Roles</label>
                                <input @focus="showListRoles = true"  @click.outside="showListRoles = false"  @input="findRole()" id="find-period" class="w-full border p-1 border-gray-600 outline-0 text-gray-600" type="text" x-model="findRoleText">
                                <input name="roleId" id="period-selected-id" type="hidden" :value="roleSelected">
                                <template x-if="showListRoles">
                                    <div @scroll.passive="($el.scrollHeight - $el.scrollTop <= $el.clientHeight+2) && loadMoreRoles()" id="periods-container" class="overflow-y-auto h-20 absolute top-full left-0 w-full border border-gray-400 bg-white rounded-sm z-50 group-focus-within:pointer-events-auto">
                                        <template x-if="!isLoadingRoles">
                                            <template x-for="role in roles">
                                                <div @click="selectRole(role)" class="p-1 hover:bg-gray-200 cursor-pointer rounded-md text-sm">
                                                    <span class="text-gray-600" x-text="role.name"></span>
                                                </div>
                                            </template>
                                        </template>
                                        <template x-if="isLoadingMoreRoles">
                                            <div class="py-1.5">
                                                <x-loading-spin-component styles="h-5 w-5"/>
                                            </div>
                                        </template>
                                        <template x-if="isLoadingRoles">
                                            <x-loading-spin-component/>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            @error("roleId")
                                <p class="text-xs text-red-500 p-0">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-2 px-3">
                            <label class="block text-base text-gray-700" for="password">Contraseña</label>
                            <input
                                id="password"
                                class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                type="password"
                                name="pass"
                                value="{{@old('pass')}}"
                                placeholder="Ingresa tu contraseña"
                            >
                            @error("pass")
                                <p class="text-xs text-red-500 p-0">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3 px-3">
                            <label class="block text-base text-gray-700" for="password">Confirmar contraseña</label>
                            <input
                                class="p-1 border border-gray-600 w-full outline-0 text-gray-600"
                                type="password"
                                name="confirm-password"
                                value="{{@old('confirm-password')}}"
                                placeholder="Confirma tu contraseña"
                            >
                            @error("confirm-password")
                                <p class="text-xs text-red-500 p-0">{{$message}}</p>
                            @enderror
                            @if(session("error"))
                                <p class="text-xs text-red-500 p-0">
                                    {{session("error")}}
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="">
                    <button form="formRegister" type="submit" class="w-full text-white bg-[#1a325b] p-1 rounded-b-md font-bold cursor-pointer">Registrar</button>
                </div>
            </div>
        </section>
    </section>
</main>
</body>
</html>
