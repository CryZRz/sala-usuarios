@extends("layouts.mainLayout")

@section("title")
    Crear computadora
@endsection

@section("module")
    Creacion Equipo de Computo
@endsection

@section("content")
    <div class="mt-10 mx-8" x-data="editComputer({{$computer->id}})">

        <x-modal-component :id="'createModal'" title="Crear Puerto">
            <x-slot name="body">
                <form action="">
                    <div>
                        <label class="block text-sm text-gray-800 font-bold" for="input-port-type">Puerto: </label>
                        <input x-model="createPort.type" class="border border-gray-400 rounded-md p-1 w-full outline-0 mt-1" id="input-port-type" name="type" type="text" placeholder="USB, HDMI, ...">
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm text-gray-800 font-bold" for="input-port-amount">Cantidad: </label>
                        <input x-model="createPort.amount" class="border border-gray-400 rounded-md p-1 w-full outline-0 mt-1" id="input-port-amount" name="amount" type="number" placeholder="1, 2, ...">
                    </div>
                </form>
            </x-slot>
            <x-slot name="confirmButton">
                <button @click="savePort()" id="save-btn" data-modal-hide="default-modal" type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-brand-primary">
                    Guardar
                </button>
            </x-slot>
        </x-modal-component>

        <x-modal-component :id="'editModal'" title="Editar Puerto">
            <x-slot name="body">
                <form action="">
                    <div>
                        <label class="block text-sm text-gray-800 font-bold" for="input-port-type">Puerto: </label>
                        <input x-model="portEdit.type" class="border border-gray-400 rounded-md p-1 w-full outline-0 mt-1" id="input-port-type" name="type" type="text" placeholder="USB, HDMI, ...">
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm text-gray-800 font-bold" for="input-port-amount">Cantidad: </label>
                        <input x-model="portEdit.amount" class="border border-gray-400 rounded-md p-1 w-full outline-0 mt-1" id="input-port-amount" name="amount" type="number" placeholder="1, 2, ...">
                    </div>
                </form>
            </x-slot>
            <x-slot name="confirmButton">
                <button @click="confirmEditPort()" data-modal-hide="default-modal" type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-brand-primary">
                    Guardar
                </button>
            </x-slot>
        </x-modal-component>

        <x-modal-component :id="'addProgram'" title="Agregar programa">
            <x-slot name="body">
                <template x-if="programsSelectToAdd.length > 0">
                    <div class="flex gap-1 flex-wrap overflow-y-auto h-10">
                        <template x-for="programToAdd in programsSelectToAdd">
                            <div class="bg-brand-primary rounded-md p-2 text-white text-sm">
                                <span x-text="programToAdd.name"></span>
                                <i @click="removeProgramFlag(programToAdd)" class="bi bi-x-lg cursor-pointer"></i>
                            </div>
                        </template>
                    </div>
                </template>
                <div id="dropdownSearch" class="z-10 bg-white rounded-lg shadow-sm w-full">
                    <div class="p-3">
                        <label for="input-group-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="input-group-search"
                                class="outline-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                placeholder="Buscar programa"
                                x-model="textFindProgramToAdd"
                                @input="findProgramToAdd()"
                            >
                        </div>
                    </div>
                    <ul @scroll.passive="($el.scrollHeight - $el.scrollTop <= $el.clientHeight +1) && loadMoreProgramsToAdd()" class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700">
                        <template x-if="!isFindProgramsToAdd">
                            <template x-for="programAdd in programsToAdd">
                                <li>
                                    <div class="flex items-center p-2 rounded-sm hover:bg-gray-100">
                                        <input :checked="verifyInclude(programAdd)" @change="addProgramSelect($event, programAdd)" id="checkbox-item-11" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                        <label x-text="programAdd.name" for="checkbox-item-11" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm"></label>
                                    </div>
                                </li>
                            </template>
                        </template>
                        <template x-if="isFindProgramsToAdd">
                            <x-loading-spin-component/>
                        </template>
                        <template x-if="isGettingMorePrograms">
                            <li>
                                <x-loading-spin-component styles="h-5 w-5"/>
                            </li>
                        </template>
                    </ul>
                </div>
            </x-slot>
            <x-slot name="confirmButton">
                <button @click="confirmAddPrograms()" data-modal-hide="default-modal" type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-brand-primary">
                    Guardar
                </button>
            </x-slot>
        </x-modal-component>

        <div class="w-full p-6 bg-white rounded-md">
            <div class="w-full  mt-0">
                <div>
                    <form class="flex justify-evenly gap-2" action="{{route("computer.update", $computer->id)}}" method="POST" id="mainForm">
                        @csrf
                        <div class="w-full">
                            <label class="block text-sm text-gray-700 font-semibold" for="computerNumber">Num. Equipo</label>
                            <input value="{{$computer->computer_number}}" id="computerNumber" name="computerNumber" type="text" class="text-sm outline-0 w-full border border-gray-400 rounded-md p-1">
                            @error("computerNumber")
                            <p class="text-red-400 text-sm mt-2">
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-sm text-gray-700 font-semibold" for="cpu">CPU</label>
                            <input value="{{$computer->cpu}}" id="cpu" name="cpu" type="text" class="text-sm outline-0 w-full border border-gray-400 rounded-md p-1">
                            @error("cpu")
                            <p class="text-red-400 text-sm mt-2">
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-sm text-gray-700 font-semibold" for="ram">RAM</label>
                            <input value="{{$computer->ram}}" id="ram" type="number" name="ram" class="text-sm outline-0 w-full border border-gray-400 rounded-md p-1">
                            @error("ram")
                            <p class="text-red-400 text-sm mt-2">
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-6">
                <div class="flex gap-4">
                    <div class="w-1/2">

                        <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-full">
                            <div class="p-4">
                                <div class="mb-4 flex items-center justify-between">
                                    <h5 class="text-slate-800 text-lg font-semibold">
                                        Programas
                                    </h5>
                                    <button @click="addProgram = true" class="bg-brand-secondary rounded-md p-2 text-sm text-white cursor-pointer">
                                        Añadir
                                    </button>
                                </div>
                                <div class="w-full">
                                    <div class="relative">
                                        <input
                                            x-model="textFindProgram"
                                            @input="findProgram()"
                                            class="bg-white w-full pr-11 h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                            placeholder="Buscar programa"
                                        />
                                        <button
                                            class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
                                            type="button"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="divide-y divide-slate-200 mt-3">
                                    <template x-for="program in programs">
                                        <div class="flex items-center justify-between pb-3 pt-3 last:pb-0">
                                            <div class="flex items-center gap-x-3">
                                                <div class="relative inline-block h-8 w-8 rounded-full object-cover object-center">
                                                    <i class="bi bi-motherboard text-2xl"></i>
                                                </div>
                                                <div>
                                                    <h6 x-text="program.name" class="text-slate-800 font-semibold">

                                                    </h6>
                                                    <p x-text="`Version: ${program.version}`" class="text-slate-600 text-sm">

                                                    </p>
                                                </div>
                                            </div>
                                            <h6 class="text-slate-600 font-medium">
                                                <button @click="deleteProgram(program)" class="cursor-pointer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <a :href="`{{ route('program.edit', ':id') }}`.replace(':id', program.id)" class="cursor-pointer">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </h6>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="w-1/2">

                        <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-full">
                            <div class="p-4">
                                <div class="mb-4 flex items-center justify-between">
                                    <h5 class="text-slate-800 text-lg font-semibold">
                                        Puertos
                                    </h5>
                                    <button @click="createModal = true" class="bg-brand-secondary rounded-md p-2 text-sm text-white cursor-pointer">
                                        Añadir
                                    </button>
                                </div>
                                <div class="w-full">
                                    <div class="relative">
                                        <input
                                            x-model="textFindPort"
                                            @input="findPort()"
                                            class="bg-white w-full pr-11 h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                            placeholder="Buscar puerto"
                                        />
                                        <button
                                            class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
                                            type="button"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="divide-y divide-slate-200 mt-3">
                                    <template x-for="port in ports">
                                        <div class="flex items-center justify-between pb-3 pt-3 last:pb-0">
                                            <div class="flex items-center gap-x-3">
                                                <div class="relative inline-block h-8 w-8 rounded-full object-cover object-center">
                                                    <i class="bi bi-usb-symbol text-2xl"></i>
                                                </div>
                                                <div>
                                                    <h6 x-text="port.type" class="text-slate-800 font-semibold">

                                                    </h6>
                                                    <p x-text="`Cantidad: ${port.amount}`" class="text-slate-600 text-sm">

                                                    </p>
                                                </div>
                                            </div>
                                            <h6 class="text-slate-600 font-medium">
                                                <button @click="deletePort(port)" class="cursor-pointer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button @click="prepareEdit(port)" class="cursor-pointer">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </h6>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full justify-end mt-3">
                    <a href="{{url()->previous()}}" class="block p-2 border-gray-300 border rounded-md mx-1 text-sm">
                        Atras
                    </a>
                    <button @click="validateData($event)" type="submit" form="mainForm" class="bg-brand-secondary p-2 text-sm text-white rounded-md cursor-pointer">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
