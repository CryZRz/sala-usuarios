@extends('layouts.authLayout')

@section('title')
    Importar alumnos
@endsection

@section('vite')
    @vite(['resources/js/import/bindColumns.js'])
@endsection

@section('main')
    <main>
        <div class="container mt-4 text-center">
            @if (session("duplicate") != null)
                <div class="alert alert-danger col-6 mx-auto py-1">
                    <p>{{session("duplicate")}}</p>
                </div>
            @endif
            <div class="col-6 mx-auto">
                <section class="bg-black rounded-top-2">
                    <div class="col-md-2 mx-auto p-1">
                        <img src="/images/logoITL.png" alt="logo itl" class="img-fluid m-2">
                    </div>
                </section>

                <section class="border border-black rounded-bottom-2">
                    <form action="{{route("import.upload", $id)}}" class="mt-2" id="formImport" method="post">
                        @csrf
                        <div>
                            <input type="checkbox" id="cancelInput" hidden name="cancel">
                        </div>
                        <div class="col-12 d-flex p-2">
                            <div class="col-6">
                                <span>NumControl: </span>
                            </div>
                            <div class="col-6">
                                <select class="select-header" name="controlNumber">
                                    @foreach($headers as $header)
                                        <option value="{{$header}}" selectId="{{$header}}">
                                            {{$header}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex p-2">
                            <div class="col-6">
                                <span>Nombres: </span>
                            </div>
                            <div class="col-6">
                                <select id="selectName" class="select-header" name="name">
                                    @foreach($headers as $header)
                                        <option value="{{$header}}" selectId="{{$header}}">
                                            {{$header}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex p-2">
                            <div class="col-6">
                                <span>Apellidos: </span>
                            </div>
                            <div class="col-6">
                                <select class="select-header" name="lastName">
                                    @foreach($headers as $header)
                                        <option value="{{$header}}" selectId="{{$header}}">
                                            {{$header}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex p-2">
                            <div class="col-6">
                                <span>Carrera: </span>
                            </div>
                            <div class="col-6">
                                <select class="select-header" name="career">
                                    @foreach($headers as $header)
                                        <option value="{{$header}}" selectId="{{$header}}">
                                            {{$header}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex p-2">
                            <div class="col-6">
                                <span>Semestre: </span>
                            </div>
                            <div class="col-6">
                                <select class="select-header" name="semester">
                                    @foreach($headers as $header)
                                        <option class="p-1 rounded-2" value="{{$header}}" selectId="{{$header}}">
                                            {{$header}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 mx-auto col-11 ">
                            <div class="mb-2">
                                <button class="text-black btn btn-yw-primary col-12 p-1 border-black">
                                    Importar
                                </button>
                            </div>

                            <div class="mb-2">
                                <button id="cancelImportBtn" class="text-black btn btn-yw-primary col-12 p-1 border-black">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
    <script>
        const headers = @json($headers);
    </script>
@endsection
