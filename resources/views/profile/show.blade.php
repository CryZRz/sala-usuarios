@extends("layouts.profileLayout")

@section("data")
    @if(session("success"))
        <div class="my-4">
                <span class="block p-2 bg-green-200 text-green-800 font-extralight">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{session("success")}}
                </span>
        </div>
    @endif
    <div class="bg-white p-4">
        <form action="{{route("profile.update", $user->id)}}" method="POST">
            @method("PUT")
            @csrf
            <div class="flex justify-between ">
                <div>
                    <span class="text-gray-500">Editar perfil</span>
                </div>
                <div>
                    <button class="cursor-pointer bg-brand-primary text-white p-2 rounded-md text-sm">Guardar</button>
                </div>
            </div>
            <div class="mt-4">
                <div>
                    <span class="uppercase text-gray-600 font-extralight text-sm">Informacion del usuario</span>
                </div>
                <div class="flex mt-5 gap-4">
                    <div class="w-1/2">
                        <label class="block text-sm text-gray-600 font-bold" for="username">Nombre de usuario</label>
                        <input
                            id="username"
                            type="text"
                            class="text-md text-gray-500 outline-0 border border-gray-400 rounded-sm w-full p-1 mt-1"
                            name="username"
                            value="{{$user->username}}"
                        >
                        @error("username")
                            <div>
                                <p class="text-xs text-red-400 pt-1">
                                    {{$message}}
                                </p>
                            </div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm text-gray-600 font-bold" for="email">Correo</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="text-md text-gray-500 outline-0 border border-gray-400 rounded-sm w-full p-1 mt-1"
                            value="{{$user->email}}"
                        >
                        @error("email")
                        <div>
                            <p class="text-xs text-red-400 pt-1">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="flex mt-5 gap-4">
                    <div class="w-1/2">
                        <label class="text-gray-600 block text-sm  font-bold" for="name">Nombres</label>
                        <input
                            type="text"
                            id="name"
                            class="text-md text-gray-500 outline-0 border border-gray-400 rounded-sm w-full p-1 mt-1"
                            name="name"
                            value="{{$user->name}}"
                        >
                        @error("name")
                        <div>
                            <p class="text-xs text-red-400 pt-1">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label class=" block text-sm text-gray-600 font-bold" for="lastName">Apellidos</label>
                        <input
                            type="text"
                            id="lastName"
                            name="lastName"
                            class="text-md text-gray-500 outline-0 border border-gray-400 rounded-sm w-full p-1 mt-1"
                            value="{{$user->last_name}}"
                        >
                        @error("lastName")
                        <div>
                            <p class="text-xs text-red-400 pt-1">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
