@extends('layouts.authLayout')

@section('title')
    Importar alumnos
@endsection

@section('vite')
    @vite(['resources/js/import/show.js'])
@endsection

@section('main')
    <main>
        @if(!isset($valid))
            <section id="section-loading"></section>
            <section class="container d-flex flex-column text-center gap-2">
                <p class="h3 fw-bold">Importar alumnos</p>
                <p class="fs-5">Sube el archivo excel que contiene los registros de los alumnos. <br>
                    A aquellos que ya se encontraban registrados se les actualizarán sus datos.</p>
                <p class="fs-6">Los encabezados de los registros deben ser los siguientes, en cualquier orden: <br>
                    <span class="fw-bold">NControl | Apellidos | Nombre | Carrera | Semestre</span>
                </p>
                <form id="form-import" action="{{ route('import.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section class="row mb-2">
                        <div class="col-md-6 mb-2 mx-auto">
                            <label class="form-label" for="archivo">Archivo:</label>
                            <input
                                class="form-control"
                                name="file"
                                type="file"
                                placeholder="Nombre del tipo de uso"
                                accept=".xlsx,.csv"
                                required
                            >
                        </div>
                        <section>
                            <button class="btn btn-turquesa my-2 fw-bold" type="submit">Importar</button>
                        </section>
                    </section>
                </form>
            </section>
        @else
            <x-show-alert-component
                text="La carga de alumnos ya se ha realizado para el periodo {{$period->name}}"
            />
        @endif
    </main>
@endsection
