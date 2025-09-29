@extends("layouts.mainLayout")

@section("title")
    Ediar incidencia
@endsection

@section("module")
    Edicion de incidencia
@endsection

@section("content")
    <div class="w-full mt-20 flex justify-center" x-data="{confirmModal: false}">

        <x-modal-confirm-component message="Deseas cambiar el estatus de la incidencia" :id="'confirmModal'">
            <x-slot name="confirmButton">
                <form action="{{route("incidence.destroy", $incidence->id)}}" x-ref="confirmForm" method="POST">
                    @method("DELETE")
                    @csrf
                    <input type="hidden" value="{{$incidence->id}}">
                </form>
                <button @click="$refs.confirmForm.submit()" type="button" class="cursor-pointer text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Si
                </button>
            </x-slot>
        </x-modal-confirm-component>

        <div class="bg-white rounded-md w-4/5 shadow-md p-3">
            <div class="p-3">
                <h3 class="text-gray-700 font-medium">Editar Incidencia</h3>
            </div>
            <div>
                <form action="{{route("incidence.update", $incidence->id)}}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="flex mx-4">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                  <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                                  </svg>
                                </span>
                        <input value="{{$incidence->studentUpdate->controlNumber}}" type="text" readonly id="website-admin" class="bg-gray-200 cursor-not-allowed outline-0 rounded-none bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="Numero de control">
                        <button disabled class="bg-brand-primary w-14 rounded-tr-md rounded-br-md">
                            <i class="bi bi-search text-white text-md"></i>
                        </button>
                    </div>
                    <div class="flex mx-4 gap-6 mt-4">
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="name">Nombres</label>
                            <input value="{{$incidence->student->name}}" readonly id="name" class="bg-gray-200 border mt-1 w-full border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="text" name="name" placeholder="Nombres">
                            @error("name")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="lastName">Apellidos</label>
                            <input value="{{$incidence->student->lastName}}" readonly id="lastName" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="text" name="lastName" placeholder="Apellidos">
                            @error("lastName")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex mx-4 gap-6 mt-4">
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="controlNumber">Num.Control</label>
                            <input value="{{$incidence->studentUpdate->controlNumber}}" readonly id="controlNumber" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="text" name="controlNumber" placeholder="Numero de Control">
                            @error("controlNumber")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="semester">Semestre</label>
                            <input value="{{$incidence->studentUpdate->semester}}" readonly id="semester" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed" type="number" name="semester" placeholder="Semestre">
                            @error("semester")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mx-4 mt-4">
                        <label class="block text-xs text-gray-800 font-semibold" for="career">Plan estudios</label>
                        <input value="{{$incidence->studentUpdate->career}}" readonly placeholder="Plan estudios" id="career" name="career" class="bg-gray-200 border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary cursor-not-allowed"/>
                        @error("career")
                        <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mt-4 mx-4">
                        <label class="block text-xs text-gray-800 font-semibold" for="description">
                            Descripcion
                        </label>
                        <textarea name="description" placeholder="Descripcion" class="mt-1 w-full border border-gray-300 rounded-md p-1 outline-0 text-sm focus:border-brand-primary">{{$incidence->description}}</textarea>
                    </div>
                    <div class="mx-4 mt-8 flex gap-3 justify-end p-4">
                        @canUse("$module.delete")
                            <button @click.prevent="confirmModal = true" class="bg-brand-alert cursor-pointer p-2 rounded-md text-white text-xs font-bold">
                                Finalizar
                            </button>
                        @else
                            <button  @click.prevent="" title="No tienes permisos" class="bg-red-300 cursor-not-allowed p-2 rounded-md text-white text-xs font-bold">
                                Finalizar
                            </button>
                        @endcanUse
                        <button type="submit" class="bg-brand-primary cursor-pointer p-2 rounded-md text-white text-xs font-bold">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
