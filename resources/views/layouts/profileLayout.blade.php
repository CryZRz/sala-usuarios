@extends("layouts.mainLayout")

@section("title")
    Perfil
@endsection

@section("module")
    Perfil
@endsection

@section("bg")
    bg-profile relative bg-cover bg-center after:content-[''] after:absolute
    after:w-full after:h-full after:bg-[rgba(26,50,91,0.5)] after:z-30
@endsection

@section("content")
    <div class="w-full h-70"></div>
    <div class="w-full h-24 shadow-md rounded-lg bg-white p-2">
        <div class="flex items-center">
            <div>
                <picture class="">
                    <img class="w-18 h-18 rounded-md" src="https://argon-dashboard-laravel.creative-tim.com/img/team-1.jpg" alt="imagen por defecto de pefil">
                </picture>
            </div>
            <div class="m-3">
                <span class="font-semibold text-gray-600 block">
                    {{$user->name}}
                </span>
                <span class="text-gray-400 block">{{$user->email}}</span>
            </div>
        </div>
        <div></div>
    </div>
    <div class="mt-4 flex">
        <div class="w-3/4">
            @yield("data")
        </div>
        <div class="w-3/12">
            <div class="px-3">
                <div class="relative flex flex-col rounded-lg bg-white shadow-sm border border-slate-200 text-gray-600">
                    <nav class="flex min-w-[240px] flex-col gap-1 py-1.5">
                        <a
                            href="{{route("profile.show", $user->id)}}"
                            class=" cursor-pointer flex w-full items-center p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                        >
                            <i class="bi bi-card-text mr-2 text-lg"></i>
                            General
                        </a>
                        <a
                            href="{{route("profile.changePassword", $user->id)}}"
                            class=" flex w-full items-center p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                        >
                            <i class="bi bi-incognito mr-2 text-lg"></i>
                            Contraseña
                        </a>
                        <a
                            href="{{route("profile.viewRoles", $user->id)}}"
                            class=" flex w-full items-center p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                        >
                            <i class="bi bi-person-rolodex mr-2 text-lg"></i>
                            Roles
                        </a>
                        <a
                            href="{{route("tokens.show", $user->id)}}"
                            class=" flex w-full items-center p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                        >
                            <i class="bi bi-key mr-2 text-xl"></i>
                            Tokens
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
