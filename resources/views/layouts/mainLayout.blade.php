<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <title>
        @yield("title")
    </title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-gray-100">
<x-loading-component/>
<main class="relative w-full" x-data="logout()">

    <x-modal-confirm-component :id="'showConfirmLogout'" message="Todas las sesiones sin finalizar seran finalizadas">
        <x-slot name="confirmButton">
            <button @click="confirmLogout()" class="cursor-pointer bg-brand-primary text-white text-sm p-2 rounded-md">
                Terminar
            </button>
        </x-slot>
    </x-modal-confirm-component>

    <section class="absolute section-bg w-full z-10">
        <div class="h-72 @yield('bg', 'bg-[#1a325b]')"></div>
    </section>
    <section class="absolute z-20 w-full flex">
        <section class="w-1/5"></section>
        <section class="w-1/5 fixed">
            <!--Navbar -->
            <div class="bg-white w-11/12 mx-auto rounded-md mt-4 shadow-md relative">
                <!--Header Navbar -->
                <div class="w-full border-bottom border-black h-20 flex justify-center items-center my-2 gap-2">
                    <div class="w-14 h-14">
                        <img src="/images/logoITL2.png" alt="logo del instituto tecnologico de leon">
                    </div>
                    <div>
                        <a href="{{route("dashboard.show")}}" class="font-bold">SALA USUARIOS</a>
                    </div>
                </div>

                <div class="h-0.5 my-2 bg-gray-300 mx-10 rounded-2xl"></div>

                <div class="px-4 text-sm">
                    <div class="flex justify-start items-center">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#999999"><path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
                        </div>
                        <div>
                            <a class="text-sm" href="{{route("dashboard.show")}}">Dashboard</a>
                        </div>
                    </div>
                </div>

                <!--Body Navbar -->
                <div class="px-4 text-sm text-gray-600 h-96 overflow-y-auto">
                    @yield("options")
                    <!-- Body item-->
                    <div class="text-start my-4">
                        <span class="text-sm text-gray-400 font-bold">PAGINAS</span>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1A436C"><path d="M320-120v-80h80v-80H160q-33 0-56.5-23.5T80-360v-400q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v400q0 33-23.5 56.5T800-280H560v80h80v80H320ZM160-360h640v-400H160v400Zm0 0v-400 400Z"/></svg>
                        </div>
                        <div>
                            <a href="{{route("session.show")}}">Sesiones</a>
                        </div>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fb6340"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/></svg>
                        </div>
                        <div>
                            <a href="{{route("student.showAll")}}">Estudiantes</a>
                        </div>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#3498DB"><path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/></svg>
                        </div>
                        <div>
                            <a href="{{route("incidence.show")}}">Incidencias</a>
                        </div>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#28a745"><path d="M480-540ZM80-160v-80h400v80H80Zm120-120q-33 0-56.5-23.5T120-360v-360q0-33 23.5-56.5T200-800h560q33 0 56.5 23.5T840-720H200v360h280v80H200Zm600 40v-320H640v320h160Zm-180 80q-25 0-42.5-17.5T560-220v-360q0-25 17.5-42.5T620-640h200q25 0 42.5 17.5T880-580v360q0 25-17.5 42.5T820-160H620Zm100-300q13 0 21.5-9t8.5-21q0-13-8.5-21.5T720-520q-12 0-21 8.5t-9 21.5q0 12 9 21t21 9Zm0 60Z"/></svg>
                        </div>
                        <div>
                            <a href="{{route("computer.show")}}">Equipos</a>
                        </div>
                    </div>

                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <i class="bi bi-hdd-rack text-lg text-orange-400"></i>
                        </div>
                        <div>
                            <a href="{{route("program.show")}}">Programas</a>
                        </div>
                    </div>

                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <i class="bi bi-at text-xl text-green-500"></i>
                        </div>
                        <div>
                            <a href="{{route("computer.showUses")}}">Usos</a>
                        </div>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <i class="bi bi-person-rolodex text-lg text-gray-500"></i>
                        </div>
                        <div>
                            <a href="{{route("roleManager.show")}}">Roles</a>
                        </div>
                    </div>

                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <i class="bi bi-person-lines-fill text-lg text-purple-400"></i>
                        </div>
                        <div>
                            <a href="{{route("users.show")}}">Usuarios</a>
                        </div>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F39C12"><path d="m234-480-12-60q-12-5-22.5-10.5T178-564l-58 18-40-68 46-40q-2-13-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T222-820l12-60h80l12 60q12 5 22.5 10.5T370-796l58-18 40 68-46 40q2 13 2 26t-2 26l46 40-40 68-58-18q-11 8-21.5 13.5T326-540l-12 60h-80Zm40-120q33 0 56.5-23.5T354-680q0-33-23.5-56.5T274-760q-33 0-56.5 23.5T194-680q0 33 23.5 56.5T274-600ZM592-40l-18-84q-17-6-31.5-14.5T514-158l-80 26-56-96 64-56q-2-18-2-36t2-36l-64-56 56-96 80 26q14-11 28.5-19.5T574-516l18-84h112l18 84q17 6 31.5 14.5T782-482l80-26 56 96-64 56q2 18 2 36t-2 36l64 56-56 96-80-26q-14 11-28.5 19.5T722-124l-18 84H592Zm56-160q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Z"/></svg>
                        </div>
                        <div>
                            <a href="{{route("utils.index")}}">Herramientas</a>
                        </div>
                    </div>

                    <div class="text-start my-4">
                        <sapn class="text-sm text-gray-400 font-bold">CUENTA</sapn>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#666666"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                        </div>
                        <div>
                            <a class="text-sm" href="{{route("profile.show", \Auth::user()->id)}}">Perfil</a>
                        </div>
                    </div>

                    <!-- Body item-->
                    <div class="flex justify-start items-center my-6">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                        </div>
                        <div>
                            <button @click="logout()" class="cursor-pointer">Cerrar sesion</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-4 px-4 w-4/5">
            <!--Header left section-->
            <div class="flex justify-between">
                <div>
                    <h1 class="text-white font-extralight">
                        @yield("module")
                    </h1>
                </div>
                <div>
                    <button @click="logout()" class="text-white text-base font-bold cursor-pointer">Cerrar sesion</button>
                </div>
            </div>

            @yield("content")

            <footer class="mt-10 mb-2">
                    <span class="text-gray-500 text-md py-4">
                        © 2025, Todos los Derechos Reservados
                        <span class="font-bold">Instituto Tecnológico de León</span>
                    </span>
                <p class="text-gray-500 font-extralight">
                    Proudly Design By Christian Ramos
                </p>
            </footer>
        </section>

    </section>
</main>
</body>
</html>
