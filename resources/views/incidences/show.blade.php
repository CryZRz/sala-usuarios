@extends("layouts.mainLayout")

@section("title")
    Incidencias
@endsection

@section("module")
    Administracion de incidencias
@endsection

@section("content")
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-20 mx-6">
        <div class="bg-white p-4">
            <div class="p-2">
                <h5
                    class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                    Incidencias
                </h5>
            </div>
            <div class="mt-6">
                <form x-ref="formFind" class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4" action="">
                    <div class="flex gap-3">
                        <select @change="$refs.formFind.submit()" name="active" class="bg-gray-100 border border-gray-300 rounded-md p-1 text-sm outline-0">
                            <option value="1" @if((request('active') ?? 1) == 1) selected @endif>Pendientes</option>
                            <option value="0" @if((request('active') ?? 1) == 0) selected @endif>Finalizadas</option>
                        </select>
                        <a href="{{route("incidence.create")}}" class="bg-brand-secondary p-2 w-24 text-center block rounded-md text-sm text-white">
                            Añadir
                        </a>
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <i class="bi bi-search"></i>
                        </div>
                        <input value="{{request('find')}}" name="find" type="text" id="table-search-users" class="outline-0 block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar...">
                        <button class="hidden" type="submit"></button>
                    </div>
                </form>
            </div>
        </div>

        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">Alumno</th>
                <th scope="col" class="px-6 py-3">Descripcion</th>
                <th scope="col" class="px-6 py-3">Estatus</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Estatus</th>
            </tr>
            </thead>
            <tbody>
            @foreach($incidences as $incidence)
                <tr class="bg-white border-b border-b-gray-200 hover:bg-gray-50">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                        <img class="w-10 h-10 rounded-full" src="/images/user-img.jpg" alt="Jese image">
                        <div class="ps-3">
                            <div class="text-sm text-gray-600 font-extralight">
                                {{$incidence->student->fullName}}
                            </div>
                            <div class="font-normal text-gray-500">
                                {{$incidence->studentUpdate->controlNumber}}
                            </div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        @if(strlen($incidence->description) >= 10)
                            {{substr($incidence->description,0 ,10)}}
                        @else
                            {{$incidence->description}}
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($incidence->status)
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                Resuelta
                            @else
                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                Pendiente
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{$incidence->created_at}}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1">
                            <a href="{{route("incidence.showOne", $incidence->id)}}" class="font-medium text-brand-primary hover:underline">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>
                            <a
                                href="@if(request('active') != '0') {{route("incidence.edit", $incidence->id)}} @endif"
                                class="mx-1 @if(request('active') == '0') cursor-not-allowed" @endif">
                                <i class="bi bi-pen"></i>
                            </a>
                            <form
                                class="block"
                                @if((request('active') ?? 1) != 0) action="{{ route('incidence.destroy', $incidence->id) }}" @endif
                                method="POST"
                            >
                                @method("DELETE")
                                @csrf
                                <button @if((request('active') ?? 1) == 0) @click.prevent @endif>
                                    <i class="bi bi-trash cursor-pointer @if((request('active') ?? 1) == 0) cursor-not-allowed @endif"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between p-4 bg-white">
            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                Pagina {{ $incidences->currentPage() }} de {{ $incidences->lastPage() }}
            </p>
            <div class="flex gap-2">
                @if ($incidences->onFirstPage())
                    <a
                        class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button">
                        Anterior
                    </a>
                @else
                    <a
                        href="{{ $incidences->previousPageUrl() }}"
                        class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button">
                        Anterior
                    </a>
                @endif
                @if ($incidences->hasMorePages())
                    <a
                        href="{{ $incidences->nextPageUrl() }}"
                        class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button">
                        Siguiente
                    </a>
                @else
                    <button
                        class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button">
                        Siguiente
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
