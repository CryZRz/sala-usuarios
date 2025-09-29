@extends("layouts.mainLayout")

@section("title")
    Incidencia {{$incidence->id}}
@endsection

@section("module")
    Detalle Incidencia {{$incidence->id}}
@endsection

@section("content")
    <div class="w-full flex justify-center mt-10">
        <div class="w-[50rem]">
            <div class="w-full bg-brand-primary p-2 rounded-tr-md rounded-tl-md">
                <img class="w-20 mx-auto" src="/images/tecnmLGW.png" alt="logo del tecnm color blanco">
            </div>
            <div class="bg-white p-4">
                <div>
                    <h3 class="text-gray-600 text-lg">Incidencia</h3>
                </div>
                <div class="mt-4">
                    <div class="mt-1">
                        <span class="text-gray-500 font-bold text-base">Numero de incidencia: </span>
                        <span class="text-gray-500 ml-1">{{$incidence->id}}</span>
                    </div>
                    <div class="mt-1">
                        <span class="text-gray-500 font-bold text-base">Fecha de alta: </span>
                        <span class="text-gray-500 ml-1">{{$incidence->created_at}}</span>
                    </div>
                    <div class="mt-1">
                        <span class="text-gray-500 font-bold text-base">Fecha actulizacion: </span>
                        <span class="text-gray-500 ml-1">{{$incidence->updated_at}}</span>
                    </div>
                    <div class="mt-1">
                        <span class="text-gray-500 font-bold text-base">Estatus: </span>
                        <span class="text-gray-500 ml-1">{{$incidence->statusText}}</span>
                    </div>
                    <div class="mt-1">
                        <span class="block text-gray-500 font-bold text-base">Descripcion: </span>
                        <span class="text-gray-500">{{$incidence->description}}</span>
                    </div>
                </div>
                <div class="flex mt-5 border-t border-t-gray-200">
                    <div class="w-full mt-2">
                        <div>
                            <h3 class="text-gray-600 text-lg">Alumno</h3>
                        </div>
                        <div>
                            <div class="mt-1">
                                <span class="text-gray-500 font-bold text-base">Numero de control: </span>
                                <span class="text-gray-500 block">{{$incidence->studentUpdate->controlNumber}}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-gray-500 font-bold text-base">Nombre: </span>
                                <span class="text-gray-500 block">{{$incidence->student->fullName}}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-gray-500 font-bold text-base">Plan de estudios: </span>
                                <span class="block text-gray-500">{{$incidence->studentUpdate->career}}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-gray-500 font-bold text-base">Semestre: </span>
                                <span class="text-gray-500 ml-1">{{$incidence->studentUpdate->semester}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-2">
                        <div>
                            <h3 class="text-gray-600 text-lg">Creado Por: </h3>
                        </div>
                        <div>
                            <div class="mt-1">
                                <span class="text-gray-500 font-bold text-base">Nombre: </span>
                                <span class="text-gray-500 block">{{$incidence->owner->name}}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-gray-500 font-bold text-base">Correo: </span>
                                <span class="text-gray-500 block">{{$incidence->owner->email}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full text-center bg-brand-primary p-2 rounded-br-md rounded-bl-md">
                <span class="text-white text-md font-bold">
                     Instituto Tecnológico de León
                </span>
            </div>
        </div>
    </div>
@endsection
