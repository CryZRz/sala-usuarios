@extends("layouts.mainLayout")

@section("title")
    Manejo de roles
@endsection

@section("module")
    Administracion de roles
@endsection

@section("content")
    <div class="p-3 overflow-scroll text-gray-700 bg-white shadow-md mt-15 mx-8 rounded-md">

        <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">
                    Gestion de roles
                </h3>
                <p class="text-slate-500">
                    Administracion de los roles
                </p>
            </div>
            <div class="ml-3">
                <div class="flex gap-2 justify-center items-center max-w-sm min-w-[200px] relative">
                    <div>
                        <a href="{{route("roleManager.create")}}" class="p-2 rounded-md bg-brand-primary text-white text-xs font-bold ">
                            <i class="bi bi-file-earmark-plus"></i>
                            Crear
                        </a>
                    </div>
                    <div class="relative">
                        <form action="{{route("roleManager.show")}}" method="get">
                            <input
                                name="find"
                                class="bg-white w-full pr-11 h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                placeholder="Buscar rol"
                                value="{{@request("find")}}"
                            />
                            <button
                                class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
                                type="button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="w-full text-left table-auto mt-8">
            <thead>
            <tr>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                    <p class="block text-sm font-normal leading-none text-slate-500">
                        Nombre
                    </p>
                </th>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                    <p class="block text-sm font-normal leading-none text-slate-500">
                        Descripcion
                    </p>
                </th>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                    <p class="block text-sm font-normal leading-none text-slate-500">
                        Creado a
                    </p>
                </th>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                    <p class="block text-sm font-normal leading-none text-slate-500">
                        Actualizado a
                    </p>
                </th>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                    <p class="block text-sm font-normal leading-none text-slate-500">
                        Opciones
                    </p>
                </th>
            </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 border-b border-slate-200 py-5">
                            <p class="block font-semibold text-sm text-slate-800">
                                {{$role->name}}
                            </p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-5">
                            <p class="text-sm text-slate-500">
                                {{substr($role->description, 0, 20)}}...
                            </p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-5">
                            <p class="text-sm text-slate-500">
                                {{$role->createdAt}}
                            </p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-5">
                            <p class="text-sm text-slate-500">
                                {{$role->createdAt}}
                            </p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-5">
                            <a href="{{route("roleManager.edit", $role->id)}}">
                                <i class="bi bi-pen"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="md:flex m-4 bg-white p-2 rounded-md w">
            <p class="text-sm text-slate-600 flex-1">
                Mostrando {{ $roles->firstItem() }} de {{ $roles->lastItem() }} paginas
            </p>

            <div class="flex items-center max-md:mt-4">

                <ul class="flex space-x-3 justify-center">
                    <li class="flex items-center justify-center shrink-0 w-9 h-9 rounded-md {{ $roles->onFirstPage() ? 'bg-gray-100' : 'bg-white border border-gray-300 hover:border-blue-500' }}">
                        <a href="{{ $roles->previousPageUrl() }}" class="{{ $roles->onFirstPage() ? 'pointer-events-none' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 {{ $roles->onFirstPage() ? 'fill-gray-400' : 'fill-gray-600' }}" viewBox="0 0 55.753 55.753">
                                <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                            </svg>
                        </a>
                    </li>

                    @for ($i = 1; $i <= $roles->lastPage(); $i++)
                        <li class="flex items-center justify-center shrink-0 border cursor-pointer text-sm font-medium h-9 rounded-md px-[13px]
                    @if ($roles->currentPage() == $i)
                        bg-brand-primary border-brand-primary text-white
                    @else
                        bg-white border-gray-300 hover:border-blue-500 text-slate-900
                    @endif">
                            <a href="{{ $roles->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="flex items-center justify-center shrink-0 w-9 h-9 rounded-md {{ $roles->onLastPage() ? 'bg-gray-100' : 'bg-white border border-gray-300 hover:border-blue-500' }}">
                        <a href="{{ $roles->nextPageUrl() }}" class="{{ $roles->onLastPage() ? 'pointer-events-none' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 rotate-180 {{ $roles->onLastPage() ? 'fill-gray-400' : 'fill-gray-600' }}" viewBox="0 0 55.753 55.753">
                                <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
