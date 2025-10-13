@extends("layouts.mainLayout")

@section("title")
    Sesiones
@endsection

@section("module")
    Sesiones de prestamos
@endsection

@section("options")
    <div class="w-full bg-white rounded-md">
        <div>
            <div class="py-2">
                <span>Filtros</span>
            </div>
            <form action="" method="get">
                <div>
                    <label for="" class="block text-xs text-gray-600 font-bold">Estudiante</label>
                    <input name="student"
                           class="text-sm text-gray-500 border border-gray-300 p-1 rounded-md w-full mt-1 outline-0"
                           type="text"
                           placeholder="Nombre o numero de control"
                           value="{{ request('student') }}"
                    >
                </div>
                <div class="mt-3">
                    <label for="" class="block text-xs text-gray-600 font-bold">Administrador</label>
                    <input name="admin"
                           class="text-sm text-gray-500 border border-gray-300 p-1 rounded-md w-full mt-1 outline-0"
                           type="text"
                           value="{{ request('admin') }}"
                           placeholder="Nombre"
                    >
                </div>
                <div class="mt-3">
                    <label for="" class="block text-xs text-gray-600 font-bold">Num Equipo</label>
                    <input
                        name="computerNumber"
                        class="text-sm text-gray-500 border border-gray-300 p-1 rounded-md w-full mt-1 outline-0"
                        type="number"
                        placeholder="Numero de equipo"
                        value="{{ request('computerNumber') }}"
                    >
                </div>
                <div class="mt-3">
                    <label for="" class="block text-xs text-gray-600 font-bold">Uso</label>
                    <select name="application" class="text-sm text-gray-500 border border-gray-300 p-1 rounded-md w-full mt-1 outline-0" id="">
                        <option value="">Todos</option>
                        @foreach($applications as $application)
                            <option value="{{$application->id}}" @if(request('application') == $application->id) selected @endif>
                                {{$application->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label for="" class="block text-xs text-gray-600 font-bold">Fecha</label>
                    <input
                        name="createdAt"
                        class="text-sm text-gray-500 border border-gray-300 p-1 rounded-md w-full mt-1 outline-0"
                        type="date"
                        placeholder="Numero de equipo"
                        value="{{request('createdAt')}}"
                    >
                </div>
                <div class="mt-3">
                    <label for="" class="block text-xs text-gray-600 font-bold">Carrera</label>
                    <select name="career" class="text-sm text-gray-500 border border-gray-300 p-1 rounded-md w-full mt-1 outline-0" id="">
                        <option value="">Todas</option>
                        @foreach($careers as $career)
                            <option value="{{$career->id}}" @if(request("career") == $career->id) selected @endif>
                                {{$career->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label for="" class="block text-xs text-gray-600 font-bold">Semestre</label>
                    <select name="semester" class="text-sm text-gray-500 border border-gray-300 p-1 rounded-md w-full mt-1 outline-0" id="">
                        <option value="">Todos</option>
                        @foreach(range(1,13) as $semester)
                            <option value="{{$semester}}" @if(request("semester") == $semester) selected @endif>
                                {{$semester}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button class="text-sm text-white p-1 bg-brand-secondary rounded-md w-full mt-4 cursor-pointer">Aplicar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("content")
    <div class="mt-10 mx-6">
        <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
            <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white rounded-none bg-clip-border">
                <div class="flex items-center justify-between gap-8 mb-8">
                    <div>
                        <h5
                            class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                            Historial de Sesiones
                        </h5>
                        <p class="block mt-1 font-sans text-base antialiased font-normal leading-relaxed text-gray-700">
                            Ver detalles del historial de sesiones
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
                        <a href="{{route("session.show")}}" class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                            Sesiones
                        </a>
                    </div>
                </div>
            </div>
            <div class="p-6 px-0 overflow-scroll">
                <table class="w-full mt-4 text-left table-auto min-w-max">
                    <thead>
                    <tr>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Alumno
                            </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Detalle
                            </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Horario
                            </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Tiempo Asignado
                            </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Fecha
                            </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Creado por
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <td class="p-4 border-b border-blue-gray-50">
                                <div class="flex items-center gap-3">
                                    <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
                                         alt="John Michael" class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
                                    <div class="flex flex-col">
                                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                            {{$session->student->fullName}}
                                        </p>
                                        <p
                                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                            {{$session->studentUpdate->controlNumber}}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <div class="flex flex-col">
                                    <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        Uso: {{$session->application->name}}
                                    </p>
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        Nº Equipo: {{$session->computer->computer_number}}
                                    </p>
                                </div>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{$session->timeInterval}}
                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{$session->timeAssigment}}
                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <div class="w-max">
                                    <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{$session->startTime}}
                                    </p>
                                </div>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    Nombre: {{$session->owner->name}}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                    Correo: {{$session->owner->email}}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between p-4">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    Pagina {{ $sessions->currentPage() }} de {{ $sessions->lastPage() }}
                </p>
                <div class="flex gap-2">
                    @if ($sessions->onFirstPage())
                        <a
                            class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @else
                        <a
                            href="{{ $sessions->previousPageUrl() }}"
                            class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @endif
                    @if ($sessions->hasMorePages())
                        <a
                            href="{{ $sessions->nextPageUrl() }}"
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
