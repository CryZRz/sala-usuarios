@extends("layouts.mainLayout")

@section("title")
    Dashbaord
@endsection

@section("module")
    Dashbaord
@endsection

@section("content")
    <!-- Section principals -->
    <div class="mt-8 flex gap-4 justify-content-evenly">
        <!-- Card -->
        <a href="{{route("session.show")}}" class="bg-white rounded-xl flex w-full p-2 justify-between">
            <div>
                <div>
                                <span class="text-gray-600 font-medium">
                                    Sesiones
                                </span>
                </div>
                <div>
                                <span class="font-bold text-lg text-gray-700">
                                    {{$activeSessions}}
                                </span>
                </div>
                <div class="mt-6">
                    <p class="text-sm text-gray-500">
                        Detalles de <br>Sesión y Control
                    </p>
                </div>
            </div>
            <div>
                <div class="bg-[#F39C12] rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M480-540ZM80-160v-80h400v80H80Zm120-120q-33 0-56.5-23.5T120-360v-360q0-33 23.5-56.5T200-800h560q33 0 56.5 23.5T840-720H200v360h280v80H200Zm600 40v-320H640v320h160Zm-180 80q-25 0-42.5-17.5T560-220v-360q0-25 17.5-42.5T620-640h200q25 0 42.5 17.5T880-580v360q0 25-17.5 42.5T820-160H620Zm100-300q13 0 21.5-9t8.5-21q0-13-8.5-21.5T720-520q-12 0-21 8.5t-9 21.5q0 12 9 21t21 9Zm0 60Z"/></svg>
                </div>
            </div>
        </a>

        <!-- Card -->
        <a href="{{route("incidence.show")}}" class="bg-white rounded-xl flex w-full p-2 justify-between">
            <div>
                <div>
                    <span class="text-gray-600 font-medium">Incidencias</span>
                </div>
                <div>
                    <span class="font-bold text-lg text-gray-700">
                        {{$activeIncidences}}
                    </span>
                </div>
                <div class="mt-6">
                    <p class="text-sm text-gray-500">
                        Reporte y Estado <br>de Incidencias
                    </p>
                </div>
            </div>
            <div>
                <div class="bg-[#3498DB] rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M200-200v-560 179-19 400Zm80-240h221q2-22 10-42t20-38H280v80Zm0 160h157q17-20 39-32.5t46-20.5q-4-6-7-13t-5-14H280v80Zm0-320h400v-80H280v80Zm-80 480q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v258q-14-26-34-46t-46-33v-179H200v560h202q-1 6-1.5 12t-.5 12v56H200Zm480-200q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM480-120v-56q0-24 12.5-44.5T528-250q36-15 74.5-22.5T680-280q39 0 77.5 7.5T832-250q23 9 35.5 29.5T880-176v56H480Z"/></svg>
                </div>
            </div>
        </a>

        <!-- Card -->
        <a href="{{route("student.showAll")}}" class="bg-white rounded-xl flex w-full p-2 justify-between">
            <div>
                <div>
                                <span class="text-gray-600 font-medium">
                                    Estudiantes
                                </span>
                </div>
                <div>
                                <span class="font-bold text-lg text-gray-700">
                                    {{$students}}
                                </span>
                </div>
                <div class="mt-6">
                    <p class="text-sm text-gray-500">
                        Directorio de <br>alumnos
                    </p>
                </div>
            </div>
            <div>
                <div class="bg-[#fb6340] rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/></svg>
                </div>
            </div>
        </a>

        <!-- Card -->
        <a href="{{route("profile.show", \Auth::user()->id)}}" class="bg-white rounded-xl flex w-full p-2 justify-between">
            <div>
                <span class="text-gray-600 font-medium">Perfil</span>
            </div>
            <div>
                <div class="bg-[#28a745] rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                </div>
            </div>
        </a>

    </div>

    <div class="flex mt-10 gap-4 h-[30rem]" x-data="dashboard()">
        <div class="w-3/4 h-full rounded-2xl bg-white shadow-md ">
            <div class="p-4 h-1/5">
                <span class="text-gray-600 font-semibold">Usos Por Dìa</span>
                <p class="text-sm text-gray-500 mt-2">Detalle de usos de equipos por dia</p>
            </div>
            <div class="p-2 h-4/5 w-full">
                <canvas class="w-full mx-auto" x-ref="graphic"></canvas>
            </div>
        </div>
        <div class="w-1/2 h-full">
            <template x-if="!isLoadingNotices">
                <div class="w-full h-full relative">
                    <div id="change-img" class="absolute bg-[rgba(0,0,0,0.6)] w-full h-full rounded-2xl flex items-start flex-col justify-between">
                        <div class="w-full flex items-end justify-end">
                            <div class="m-2 gao-1 flex">
                                <div @click="prevNotice()" id="prev-notice-btn" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#99a1af"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg>
                                </div>
                                <div @click="nextNotice()" id="next-notice-btn" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#99a1af"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span x-text="listNotices[activeIndex].title" id="title-notice" class="text-white m-4 mb-0 text-xl font-bold">

                            </span>
                            <p class="text-white text-sm text-start m-4 mt-0">
                                <a id="link-notice" :href="listNotices[activeIndex].link" target="_blank">Ver Detalle</a>
                            </p>
                        </div>
                    </div>
                    <div class="w-full h-full">
                        <img id="img-notice" class="w-full h-full object-cover rounded-2xl" :src="listNotices[activeIndex].image" alt="">
                    </div>
                </div>
            </template>
            <template x-if="isLoadingNotices">
                <div role="status" class="flex items-center justify-center h-full w-full bg-gray-300 rounded-lg animate-pulse">
                    <svg class="w-10 h-10 text-gray-200" aria-hidden="true" fill="currentColor" viewBox="0 0 16 20">
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                        <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM9 13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2Zm4 .382a1 1 0 0 1-1.447.894L10 13v-2l1.553-1.276a1 1 0 0 1 1.447.894v2.764Z"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </template>
        </div>
    </div>

    <div class="mt-10">
        <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-lg rounded-xl bg-clip-border">
            <div class="m-4">
                <span class="py-4 text-gray-600 font-bold">Ultimas Sesiones</span>
            </div>
            <div class="overflow-scroll">
                <table class="w-full text-left table-auto min-w-max">
                    <thead>
                    <tr>
                        <th class="p-4">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Usuario
                            </p>
                        </th>
                        <th class="p-4 ">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Detalle
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Estatus
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Fecha
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <td class="p-4 ">
                                <div class="flex items-center gap-3">
                                    <img src="/images/user-img.jpg"
                                         alt="Imagen usuario por defecto" class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
                                    <div class="flex flex-col">
                                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                            {{$session->student->fullName}}
                                        </p>
                                        <p
                                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                            {{$session->student->latestStudentUpdate->controlNumber}}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{$session->application->name}}
                                    </p>
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{$session->timeAssigment}}
                                    </p>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="w-max">
                                    <div
                                        class="relative flex items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap bg-blue-gray-500/20 text-blue-gray-900">
                                        @if(!$session->isEnded())
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                            {{$session->isEnded}}
                                        @else
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                            {{$session->isEnded}}
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{$session->startTime}}
                                </p>
                            </td>
                            <td class="p-4">
                                <button
                                    class="cursor-pointer relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button"
                                >
                                    <i class="bi bi-pen text-base"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
