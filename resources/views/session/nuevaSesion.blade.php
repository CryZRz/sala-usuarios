@extends("layouts.mainLayout")

@section("title")
    Crear sesion
@endsection

@section("module")
    Craear sesion
@endsection

@section("content")
    <div x-data="createSession()" class="w-full mt-20 flex justify-center">
        <div class="bg-white rounded-md w-4/5 shadow-md p-3">
            <div class="p-3">
                <h3 class="text-gray-700 font-medium">Nueva Sesion</h3>
            </div>
            <div>
                <form action="{{route("session.store")}}" method="post" x-ref="formNewSession">
                    @csrf
                    <div class="flex mx-4">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                  <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                                  </svg>
                                </span>
                        <input autofocus name="controlNumber" x-model="controlNumberFind" type="text" id="website-admin" class="outline-0 rounded-none bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="Numero de control">
                        <button @click="findStudent($event)" class="cursor-pointer bg-brand-primary w-14 rounded-tr-md rounded-br-md">
                            <i class="bi bi-search text-white text-md"></i>
                        </button>
                    </div>
                    <div class="flex mx-4 gap-6 mt-4">
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="name">Nombres</label>
                            <input :value="studentData.name" readonly id="name" class="bg-gray-200 border mt-1 w-full border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="text" name="name" placeholder="Nombres">
                            @error("name")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="lastName">Apellidos</label>
                            <input :value="studentData.lastName" readonly id="lastName" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="text" name="lastName" placeholder="Apellidos">
                            @error("lastName")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex mx-4 gap-6 mt-4">
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="controlNumber">Num.Control</label>
                            <input :value="studentData.controlNumber" readonly id="controlNumber" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="text" name="controlNumber" placeholder="Numero de Control">
                            @error("controlNumber")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="semester">Semestre</label>
                            <input :value="studentData.semester" readonly id="semester" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="number" name="semester" placeholder="Semestre">
                            @error("semester")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mx-4 mt-4">
                        <label class="block text-xs text-gray-800 font-semibold" for="career">Plan estudios</label>
                        <input :value="studentData.career.name" readonly placeholder="Plan estudios" id="career" name="career" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed"/>
                        @error("career")
                        <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                        @enderror
                    </div>
                    <template x-if="!isDisabled">
                        <div class="flex mx-5 mt-4 gap-4">
                            <div class="relative w-full group mt-1">
                                <label class="block text-xs text-gray-800 font-semibold">Equpo:</label>
                                <input @click.outside="showListComputerChange = false" @focus="showListComputerChange = true" name="computer" @input="findComputerByNum" x-model="textFindComputer" id="find-period" class="border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" type="text" value="">
                                <div @scroll.passive="($el.scrollHeight - $el.scrollTop <= $el.clientHeight+2) && loadMore()" x-show="showListComputerChange" id="periods-container" class="h-22 overflow-y-auto absolute top-full left-0 w-full border border-gray-400 bg-white rounded-sm z-10">
                                    <template x-if="!loadingFetchPrograms">
                                        <template x-for="computer in computersAvaiable">
                                            <div @click="selectComputerChange(computer)" class="p-1 hover:bg-gray-200 cursor-pointer rounded-md text-sm">
                                                <span x-text="computer.computer_number"></span>
                                            </div>
                                        </template>
                                    </template>
                                    <template x-if="isLoadingMorePrograms">
                                        <x-loading-spin-component styles="h-6 w-6 py-1"/>
                                    </template>

                                    <template x-if="loadingFetchPrograms">
                                        <x-loading-spin-component/>
                                    </template>
                                </div>
                            </div>
                            <div class="w-full">
                                <input type="hidden" name="timeAssigment" x-ref="timeAssigmentInput"/>
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
                            </div>
                            <div class="w-full mt-1">
                                <label class="block text-xs text-gray-800 font-semibold" for="typeUse">Tipo de uso</label>
                                <select class="border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" name="application" id=typeUse"">
                                    @foreach($usesPrograms as $useProgram)
                                        <option value="{{$useProgram->id}}">
                                            {{$useProgram->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </template>
                    <div class="mx-4 mt-8 flex gap-3 justify-end p-4">
                        <a href="{{url()->previous()}}" class="bg-gray-100  shadow-sm p-3 text-sm rounded-md text-gray-600 font-bold">Atras</a>
                        <button type="submit" @click="validateSession($event)" class="bg-brand-primary cursor-pointer p-2 rounded-md text-white text-sm font-bold">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
