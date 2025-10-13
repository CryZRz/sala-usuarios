@extends("layouts.mainLayout")

@section("title")
    Estudiantes
@endsection

@section("module")
    Estudiantes
@endsection

@section("content")
    <div class="mx-4">
        <div class="mt-12 relative flex flex-col w-full h-full text-gray-700 bg-white shadow-lg rounded-xl bg-clip-border">
            <div class="relative mx-4 mt-4 text-gray-700 bg-white rounded-none bg-clip-border">
                <div class="flex items-center justify-between gap-8 mb-8 p-4">
                    <div>
                        <h5
                            class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                            Alumnos
                        </h5>
                        <p class="block mt-1 font-sans text-base antialiased font-normal leading-relaxed text-gray-700">
                            Ver informaciòn sobre los alumnos
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
                        <a
                            href="{{route("import.show")}}"
                            class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            <i class="bi bi-file-earmark-arrow-up text-lg"></i>
                            Importar
                        </a>
                        <a
                            class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            href="{{route("students.export.xlsx", request()->query())}}"
                        >
                            <i class="bi bi-file-earmark-spreadsheet text-lg"></i>
                            Exportar
                        </a>
                        <a
                            href="{{route("student.show")}}"
                            class="flex cursor-pointer select-none items-center gap-3 rounded-lg bg-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                 stroke-width="2" class="w-4 h-4">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                </path>
                            </svg>
                            Añadir Alumno
                        </a>
                    </div>
                </div>
                <form action="{{route("student.showAll")}}" x-ref="formFindStudents">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row mt-10">
                        <div class="block w-full md:w-max">
                            <div class="flex-column gap-2">
                                <div class="flex gap-2">
                                    <div>
                                        <label class="text-xs block font-bold" for="">Semestre</label>
                                        <select @change="$refs.formFindStudents.submit()" class="border rounded-sm border-gray-400 outline-0 px-3 mt-1.5" name="semester">
                                            <option value="-1" @if($semester === -1) selected @endif>
                                                Todos
                                            </option>
                                            @foreach(range(0,13) as $i)
                                                <option value="{{$i}}" @if($semester == $i) selected @endif>{{$i}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <div class="relative w-48 group">
                                            <x-select-periods-component name="periodId"></x-select-periods-component>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="text-xs block font-bold" for="career">Carrera</label>
                                    <select @change="$refs.formFindStudents.submit()" id="career" name="career" class="w-72 p-0.5 border rounded-sm border-gray-400 outline-0 px-2 mt-1.5">
                                        <option value="-1" @if($career == -1) selected @endif>Todas</option>
                                        @foreach(\App\Models\Career::all() as $career)
                                            <option value="{{$career->id}}" @if($career->id == @request("career")) selected @endif>
                                                {{$career->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-72 h-10 flex justify-center items-center">
                            <div class="relative  w-5/6">
                                <input
                                    class="peer h-full w-full rounded-bl-md rounded-tl-md border border-gray-400 bg-transparent px-3 py-2.5 !pr-9 font-sans text-sm font-normal text-blue-gray-700 outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-gray-600 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                                    placeholder=" " name="textFind" value="{{request("textFind")}}"/>
                                <label
                                    class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-gray-900 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-gray-900 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                    Buscar
                                </label>
                            </div>
                            <div class="h-full w-2/6">
                                <button class="w-full h-full bg-gray-900 rounded-tr-md rounded-br-md cursor-pointer">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-6 px-0 overflow-scroll mt-2">
                <table class="w-full mt-4 text-left table-auto min-w-max">
                    <thead>
                    <tr>
                        <th class="p-4 border-y border-gray-400">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Alumno
                            </p>
                        </th>
                        <th class="p-4 border-y border-gray-400">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Semestre
                            </p>
                        </th>
                        <th class="p-4 border-y border-gray-400">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Carrera
                            </p>
                        </th>
                        <th class="p-4 border-y border-gray-400">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Activo
                            </p>
                        </th>
                        <th class="p-4 border-y border-gray-400">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $studentU)
                        <tr>
                            <td class="p-4 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <img src="/images/user-img.jpg"
                                         alt="Imagen de perfil por defecto" class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
                                    <div class="flex flex-col">
                                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                            {{$studentU->student->fullName}}
                                        </p>
                                        <p
                                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                            {{$studentU->controlNumber}}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-gray-100">
                                <div class="flex flex-col">
                                    <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{$studentU->semester}}
                                    </p>
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">

                                    </p>
                                </div>
                            </td>
                            <td class="p-4 border-b border-gray-100">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                    {{$studentU->career->name}}
                                </p>
                            </td>
                            <td class="p-4 border-b border-gray-100 items-center flex gap-1">
                                @if($studentU->active)
                                    <div class="w-3 h-3 bg-green-800 rounded-full"></div>
                                    <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        Activo
                                    </p>
                                @else
                                    <div class="w-3 h-3 bg-red-800 rounded-full"></div>
                                    <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        Inactivo
                                    </p>
                                @endif
                            </td>
                            <td class="p-4 border-b border-gray-100">
                                <a
                                    href="{{route("student.edit", $studentU->controlNumber)}}"
                                    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button">
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                         class="w-4 h-4">
                                      <path
                                          d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                  </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between p-4">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    Pagina {{ $students->currentPage() }} de {{ $students->lastPage() }}
                </p>
                <div class="flex gap-2">
                    @if ($students->onFirstPage())
                        <a
                            class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @else
                        <a
                            href="{{ $students->previousPageUrl() }}"
                            class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @endif
                        @if ($students->hasMorePages())
                            <a
                                href="{{ $students->nextPageUrl() }}"
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
    </div>
@endsection
