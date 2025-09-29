@extends("layouts.mainLayout")

@section("title")
    Usuarios
@endsection

@section("module")
    Listado de usuarios
@endsection

@section("bg")
    bg-users relative bg-cover bg-center after:content-[''] after:absolute
    after:w-full after:h-full after:bg-[rgba(26,50,91,0.5)] after:z-30
@endsection

@section("content")
    <div>
        <div class="overflow-x-auto mt-70 mx-6 ">
            <div class="bg-white p-3 rounded-md">
                <div class="py-3 flex justify-between">
                    <div>
                        <span class="text-gray-500 p-1">Lista de usuarios</span>
                    </div>
                    <form action="{{route("users.show")}}" method="GET">
                        <div class="relative p-1">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input value="{{request('find')}}" name="find" type="text" id="table-search-users" class="outline-0 block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 " placeholder="Buscar...">
                            <button class="hidden" type="submit"></button>
                        </div>
                    </form>
                </div>
                <table class="min-w-full rounded-md">
                    <thead class="bg-gray-50 whitespace-nowrap">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">
                            <div class="flex items-center">
                                <i class="bi bi-person text-lg mr-1"></i>
                                Nombre
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">
                            <div class="flex items-center">
                                <i class="bi bi-envelope text-lg mr-1"></i>
                                Correo
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">
                            <div class="flex items-center">
                                <i class="bi bi-person-exclamation text-lg mr-1"></i>
                                Rol
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">
                            <div class="flex items-center">
                                <i class="bi bi-exclamation-circle text-lg mr-1"></i>
                                Estatus
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">
                            <div class="flex items-center">
                                <i class="bi bi-calendar3 text-lg mr-1"></i>
                                Fecha alta
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">
                            <div class="flex items-center">
                                <i class="bi bi-bullseye text-lg mr-1"></i>
                                Accion
                            </div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="whitespace-nowrap divide-y divide-gray-200">
                        @foreach($users as $user)
                                <td class="px-4 py-3 text-sm text-slate-900 font-medium">
                                    <div class="flex items-center cursor-pointer w-max">
                                        <img src='/images/user-img.jpg' alt="team-1" class="w-9 h-9 rounded-full shrink-0" />
                                        <div class="ml-2">
                                            <p>
                                                {{$user->name}} {{$user->last_name}}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600 font-medium">
                                    <a href="mailto:timj1456@gmail.com" class="underline">
                                        {{$user->email}}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600 font-medium">
                                    {{$user->roles[0]->name}}
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600 font-medium">
                              <span class="inline-flex items-center border border-gray-200 gap-2 px-2 py-1 rounded-lg">
                                <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                Active
                              </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600 font-medium">
                                    {{$user->created_at}}
                                </td>
                                <td class="flex gap-3 px-4 py-3 text-sm font-medium">
                                    <a href="{{route("profile.show", $user->id)}}" type="button" class="flex items-center gap-2 rounded-lg text-blue-600 bg-blue-50 border border-gray-200 px-3 py-1 cursor-pointer">
                                        <i class="bi bi-pen"></i>
                                        Editar
                                    </a>
                                    <button type="button" class="flex items-center gap-2 rounded-lg text-red-600 bg-red-50 border border-gray-200 px-3 py-1 cursor-pointer">
                                        <i class="bi bi-trash"></i>
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:flex m-4 bg-white p-2 rounded-md w">
                <p class="text-sm text-slate-600 flex-1">
                    Mostrando {{ $users->firstItem() }} de {{ $users->lastItem() }} of {{ $users->total() }} paginas
                </p>

                <div class="flex items-center max-md:mt-4">

                    <ul class="flex space-x-3 justify-center">
                        <li class="flex items-center justify-center shrink-0 w-9 h-9 rounded-md {{ $users->onFirstPage() ? 'bg-gray-100' : 'bg-white border border-gray-300 hover:border-blue-500' }}">
                            <a href="{{ $users->previousPageUrl() }}" class="{{ $users->onFirstPage() ? 'pointer-events-none' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 {{ $users->onFirstPage() ? 'fill-gray-400' : 'fill-gray-600' }}" viewBox="0 0 55.753 55.753">
                                    <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                                </svg>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="flex items-center justify-center shrink-0 border cursor-pointer text-sm font-medium h-9 rounded-md px-[13px]
                    @if ($users->currentPage() == $i)
                        bg-blue-500 border-blue-500 text-white
                    @else
                        bg-white border-gray-300 hover:border-blue-500 text-slate-900
                    @endif">
                                <a href="{{ $users->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="flex items-center justify-center shrink-0 w-9 h-9 rounded-md {{ $users->onLastPage() ? 'bg-gray-100' : 'bg-white border border-gray-300 hover:border-blue-500' }}">
                            <a href="{{ $users->nextPageUrl() }}" class="{{ $users->onLastPage() ? 'pointer-events-none' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 rotate-180 {{ $users->onLastPage() ? 'fill-gray-400' : 'fill-gray-600' }}" viewBox="0 0 55.753 55.753">
                                    <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
