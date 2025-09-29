@extends("layouts.mainLayout")

@section("title")
    Sesiones
@endsection

@section("module")
    Sesiones de prestamos
@endsection

@section("content")
    @vite(["resources/js/session/counterManager.js"])
    <div class="mt-10 mx-6" x-data="counterManager({{$sesiones}})">

        <x-modal-component :id="'modalExtendTime'" title="Extender Tiempo">
            <x-slot name="body">
                <form action="{{route("session.changeTime")}}" x-ref="formChangeTime" method="post">
                    @csrf
                    <input type="hidden" name="idSession" x-model="sessionChangeTime">
                    <input type="hidden" name="timeSession" x-ref="timeAssigment">
                    <div class="flex gap-2">
                        <div class="w-full">
                            <label for="" class="text-xs font-bold">Horas</label>
                            <input x-model="hoursSession" type="number" min="0" x-model="horas" placeholder="Horas" class="border w-full border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" />
                        </div>
                        <div class="w-full">
                            <label for="" class="text-xs font-bold">Minutos</label>
                            <input x-model="minutesSession" type="number" min="0" max="59" x-model="minutos" placeholder="Minutos" class="border w-full border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" />
                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="confirmButton">
                <button @click="confirmChangeTime($event)" id="save-btn" type="button" class="cursor-pointer text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-brand-primary">
                    Extender
                </button>
            </x-slot>
        </x-modal-component>

        <!-- Modal para terminar sesion -->
        <x-modal-confirm-component message="Deseas terminar la sesion" :id="'modalEndSession'">
            <x-slot name="confirmButton">
                <form action="{{route("session.destroy")}}" x-ref="confirmFormEndSession" method="POST">
                    @method("DELETE")
                    @csrf
                    <input type="hidden" x-model="sessionEndId" name="sessionId">
                </form>
                <button @click="$refs.confirmFormEndSession.submit()" type="button" class="cursor-pointer text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Si
                </button>
            </x-slot>
        </x-modal-confirm-component>

        <!--Modal para el cambio de equipo-->
        <x-modal-component :id="'modalChangeComputer'" title="Reasignar equipo de computo">
            <x-slot name="body">
                <form action="{{route("session.reassign")}}" method="POST" x-ref="refModalChangeComp">
                    <div>
                        @csrf
                        <div class="relative w-full group">
                            <label class="text-xs block">Equpo:</label>
                            <input @click.outside="showListComputerChange = false" @focus="showListComputerChange = true" name="computerNumber" @input="findComputerByNum" x-model="textFindComputer" id="find-period" class="w-full text-sm border p-1 mt-1 border-gray-400 rounded-sm outline-0" type="text" value="">
                            <input type="hidden" name="sessionId" x-model="sessionChangeComputerId">
                            <div x-show="showListComputerChange" id="periods-container" class="absolute top-full left-0 w-full border border-gray-400 bg-white rounded-sm z-10  group-focus-within:pointer-events-auto">
                                <template x-if="!loadingFetchPrograms">
                                    <template x-for="computer in computersAvaiable">
                                        <div @click="selectComputerChange(computer)" class="p-1 hover:bg-gray-200 cursor-pointer rounded-md text-sm">
                                            <span x-text="computer.computer_number"></span>
                                        </div>
                                    </template>
                                </template>

                                <template x-if="loadingFetchPrograms">
                                    <div class="w-full p-1">
                                        <div role="status" class="text-center">
                                            <svg aria-hidden="true" class="mx-auto w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                            </svg>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="confirmButton">
                <button @click="confirmChangeComputer($event)" id="save-btn" type="button" class="cursor-pointer text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-brand-primary">
                    Reasignar
                </button>
            </x-slot>
        </x-modal-component>

        <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
            <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white rounded-none bg-clip-border">
                <div class="flex items-center justify-between gap-8 mb-8">
                    <div>
                        <h5
                            class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                            Lista de Sesiones
                        </h5>
                        <p class="block mt-1 font-sans text-base antialiased font-normal leading-relaxed text-gray-700">
                            Ver detalles de todas las sesiones
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
                        <a
                            href="{{route("session.show")}}"
                            class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Ver todas
                        </a>
                        <a href="{{route("reports.show")}}" class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                            Reportes
                        </a>
                        <a href="{{route("session.history")}}" class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                            Historial
                        </a>
                        <a
                            href="{{route("session.new")}}"
                            class="cursor-pointer flex select-none items-center gap-3 rounded-lg bg-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                 stroke-width="2" class="w-4 h-4">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                </path>
                            </svg>
                            Añadir sesion
                        </a>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                    <div></div>
                    <div class="w-full md:w-72">
                        <form action="{{route("session.show")}}" method="GET">
                            <div class="relative h-10 w-full min-w-[200px]">
                                <div class="absolute grid w-5 h-5 top-2/4 right-3 -translate-y-2/4 place-items-center text-blue-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" aria-hidden="true" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                    </svg>
                                </div>
                                <input
                                    class="peer h-full w-full rounded-[7px] border border-blue-gray-200 bg-transparent px-3 py-2.5 !pr-9 font-sans text-sm font-normal text-blue-gray-700 outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-gray-900 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                                    placeholder=" "
                                    name="find"
                                />
                                <label
                                    class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-gray-900 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-gray-900 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                    Buscar
                                </label>
                            </div>
                        </form>
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
                                Tiempo Restante
                            </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Herramientas
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($sesiones as $session)
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-3">
                                        <img src="/images/user-img.jpg"
                                             alt="Imagen de usuario por defecto" class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
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
                                        <div
                                            @extend-session="modalExtendTime = true; sessionChangeTime = {{$session->id}}"
                                            class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap ">
                                            <span class="" id="timeAssigment" sessionId="{{ $session->id }}">
                                                {{$session->remainingTime}}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <button @click="changeTime({{$session}})" class="cursor-pointer">
                                        <i class="bi bi-alarm"></i>
                                    </button>
                                    <button @click="endSession({{$session}})" class="cursor-pointer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button @click="changeComputer({{$session}})" class="cursor-pointer">
                                        <i class="bi bi-pc-display"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between p-4">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    Pagina {{ $sesiones->currentPage() }} de {{ $sesiones->lastPage() }}
                </p>
                <div class="flex gap-2">
                    @if ($sesiones->onFirstPage())
                        <a
                            class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @else
                        <a
                            href="{{ $sesiones->previousPageUrl() }}"
                            class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @endif
                    @if ($sesiones->hasMorePages())
                        <a
                            href="{{ $sesiones->nextPageUrl() }}"
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
