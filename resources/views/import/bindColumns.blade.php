@extends('layouts.mainLayout')

@section('title')
    Importar alumnos
@endsection
@section("module")
    Seleccion de columnas
@endsection

@section('content')
    <div class="w-full mt-15 flex justify-center">
        @vite('resources/js/import/bindColumns.js')
        <div class="bg-white rounded-md w-4/5 shadow-md p-3">
            @if (session("duplicate") != null)
                <div class="bg-red-200 text-red-400 p-1">
                    <p>{{session("duplicate")}}</p>
                </div>
            @endif
            @foreach($errors->all() as $error)
                    <div class="bg-red-200 text-red-400 p-1">
                        <p>{{$error}}</p>
                    </div>
            @endforeach
            <div class="p-3">
                <h3 class="text-gray-700 font-medium">
                    Enlazar encabezados
                </h3>
            </div>
            <div class="p-3">
                <form action="{{route("import.upload", $id)}}" class="mt-2" id="formImport" method="post">
                    @csrf
                    <div>
                        <input type="checkbox" id="cancelInput" hidden name="cancel">
                    </div>
                    <div class="mt-4">
                        <div>
                            <label class="text-xs font-bold block text-start text-gray-700" for="controlNumber">Numero de control: </label>
                            <select id="controlNumber" class="select-header mt-1 w-full rounded-md border border-gray-300 outline-0 p-1 text-gray-500" name="controlNumber">
                                @foreach($headers as $header)
                                    <option value="{{$header}}" selectId="{{$header}}">
                                        {{$header}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div>
                            <label class="text-xs font-bold block text-start text-gray-700" for="selectName">Nombres: </label>
                            <select id="selectName" class="select-header mt-1 w-full rounded-md border border-gray-300 outline-0 p-1 text-gray-500" name="name">
                                @foreach($headers as $header)
                                    <option value="{{$header}}" selectId="{{$header}}">
                                        {{$header}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div>
                            <label class="text-xs font-bold block text-start text-gray-700" for="lastName">Apellidos: </label>
                            <select class="select-header mt-1 w-full rounded-md border border-gray-300 outline-0 p-1 text-gray-500" name="lastName" id="lastName">
                                @foreach($headers as $header)
                                    <option value="{{$header}}" selectId="{{$header}}">
                                        {{$header}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div>
                            <label class="text-xs font-bold block text-start text-gray-700" for="career">Carrera: </label>
                            <select class="select-header mt-1 w-full rounded-md border border-gray-300 outline-0 p-1 text-gray-500" name="careerName" id="career">
                                @foreach($headers as $header)
                                    <option value="{{$header}}" selectId="{{$header}}">
                                        {{$header}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div>
                            <label class="text-xs font-bold block text-start text-gray-700" for="career">Clave carrera: </label>
                            <select class="select-header mt-1 w-full rounded-md border border-gray-300 outline-0 p-1 text-gray-500" name="careerKey" id="career">
                                @foreach($headers as $header)
                                    <option value="{{$header}}" selectId="{{$header}}">
                                        {{$header}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div>
                            <label class="text-xs font-bold block text-start text-gray-700" for="semester">Semestre: </label>
                            <select class="select-header mt-1 w-full rounded-md border border-gray-300 outline-0 p-1 text-gray-500" name="semester" id="semester">
                                @foreach($headers as $header)
                                    <option class="p-1 rounded-2" value="{{$header}}" selectId="{{$header}}">
                                        {{$header}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div>
                            <label class="text-xs font-bold block text-start text-gray-700" for="curp">Curp: </label>
                            <select class="select-header mt-1 w-full rounded-md border border-gray-300 outline-0 p-1 text-gray-500" name="curp" id="curp">
                                @foreach($headers as $header)
                                    <option class="p-1 rounded-2" value="{{$header}}" selectId="{{$header}}">
                                        {{$header}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="w-full flex justify-end p-1 gap-3">
                            <button id="cancelImportBtn" class="cursor-pointer text-sm bg-brand-alert p-1.5 text-white rounded-md">
                                Cancelar
                            </button>
                            <button @click="$store.loader.show()" class="text-white bg-brand-primary rounded-md p-1.5 cursor-pointer text-sm">
                                Importar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const headers = @json($headers);
    </script>
@endsection
