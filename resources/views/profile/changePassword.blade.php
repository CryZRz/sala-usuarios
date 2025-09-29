@extends("layouts.profileLayout")

@section("data")
    @if(session("error"))
        <div class="my-4">
            <span class="block p-2 bg-red-200 text-brand-alert font-extralight">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{session("error")}}
            </span>
        </div>
      @endif
    <div class="bg-white p-4">

            <form action="{{route("profile.storeChangePassword", $user->id)}}" method="POST">
                @csrf
                @method("PUT")
                @if(\Auth::user()->id == $user->id)
                    <div>
                        <lael class="block text-sm text-gray-600 font-bold" for="currentPassword">
                            Contraseña actual
                        </lael>
                        <input
                            id="currentPassword"
                            type="password"
                            class="text-md text-gray-500 outline-0 border border-gray-400 rounded-sm w-full p-1 mt-1"
                            name="currentPassword"
                        >
                        @error("currentPassword")
                            <span class="text-xs text-brand-alert font-bold">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                @endif
                <div class="mt-2">
                    <lael class="block text-sm text-gray-600 font-bold" for="password">
                        Nueva Contraseña
                    </lael>
                    <input
                        id="password"
                        type="password"
                        class="text-md text-gray-500 outline-0 border border-gray-400 rounded-sm w-full p-1 mt-1"
                        name="password"
                    >
                    @error("password")
                            <span class="text-xs text-brand-alert ">
                                {{$message}}
                            </span>
                    @enderror
                </div>
                <div class="mt-3">
                    <lael class="block text-sm text-gray-600 font-bold" for="password_confirm">
                        Confirmar Contraseña
                    </lael>
                    <input
                        id="password_confirm"
                        type="password"
                        class="text-md text-gray-500 outline-0 border border-gray-400 rounded-sm w-full p-1 mt-1"
                        name="password_confirmation"
                    >
                    @error("password_confirmation")
                    <span class="text-xs text-brand-alert">
                                {{$message}}
                            </span>
                    @enderror
                </div>
                <div>
                    <button class="cursor-pointer text-sm bg-brand-primary text-white p-1 w-full mt-4 rounded-md">
                        Guardar
                    </button>
                </div>
            </form>
    </div>
@endsection
