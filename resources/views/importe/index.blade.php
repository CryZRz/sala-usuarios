@extends('layouts.authLayout')

@section('titulo')
    Importar alumnos
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main')
    <main>
        <section id="section-loading"></section>
        <section class="container d-flex flex-column text-center gap-2">
            <p class="h3 fw-bold">Importar alumnos</p>
            <p class="fs-5">Sube el archivo excel que contiene los registros de los alumnos. <br>
                A aquellos que ya se encontraban registrados se les actualizarán sus datos.</p>
            <p class="fs-5">Los encabezados de los registros deben ser los siguientes, en cualquier orden: <br>
                NControl | Apellidos | Nombre | Carrera | Semestre 
            </p>
            <form action="{{ route('computer.storeUse') }}" method="POST">
                @csrf
                <section class="row mb-2">
                    <div class="col-md-6 mb-2 mx-auto">
                        <label class="form-label" for="cpu">Archivo:</label>
                        <input class="form-control" name="nombre" type="file"
                            placeholder="Nombre del tipo de uso" accept=".xslx" required>
                    </div>
                    <section>
                        <button class="btn btn-turquesa my-2 fw-bold" type="submit">Importar</button>
                    </section>
                </section>
            </form>
        </section>
    </main>
@endsection
