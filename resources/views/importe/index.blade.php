@extends('layouts.authLayout')

@section('title')
    Importar alumnos
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/importe/show.js'])
@endsection

@section('main')
    <main>
        <section id="section-loading"></section>
        <section class="container d-flex flex-column text-center gap-2">
            <p class="h3 fw-bold">Importar alumnos</p>
            <p class="fs-5">Sube el archivo excel que contiene los registros de los alumnos. <br>
                A aquellos que ya se encontraban registrados se les actualizarán sus datos.</p>
            <p class="fs-6">Los encabezados de los registros deben ser los siguientes, en cualquier orden: <br>
                <span class="fw-bold">NControl | Apellidos | Nombre | Carrera | Semestre</span>
            </p>
            <form id="form-importar" action="{{ route('importe.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <section class="row mb-2">
                    <div class="col-md-6 mb-2 mx-auto">
                        <label class="form-label" for="archivo">Archivo:</label>
                        <input class="form-control" name="archivo" type="file" placeholder="Nombre del tipo de uso"
                            accept=".xlsx,.csv" required>
                    </div>
                    <section>
                        <button class="btn btn-turquesa my-2 fw-bold" type="submit">Importar</button>
                    </section>
                </section>
            </form>
            @if (session('message') > 0)
                <span class="fs-5 fw-bold d-block alert text-success p-1 mb-0 mt-1">{{ session('message') . " alumnos modificados en la base de datos."}}</span>
            @endif
        </section>
    </main>
@endsection
