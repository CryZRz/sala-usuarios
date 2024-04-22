@extends('layouts.authLayout')

@section('titulo')
    Crear Uso
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main')
    <main>
        <section id="section-loading"></section>
        <section class="container d-flex flex-column text-center gap-2">
            <p class="h3 fw-bold">Crear tipo de uso</p>
            <form action="{{route('computer.storeUse')}}" method="POST">
                @csrf
                <section class="row mb-2">
                    <div class="col-md-6 mb-2 mx-auto">
                        <label class="h5" for="name">Nombre</label>
                        <input class="col-12 text-center" name="nombre" type="text"
                            placeholder="Nombre del tipo de uso" required>
                    </div>
                    <section>
                        <button class="btn btn-turquesa my-2 fw-bold" type="submit" id="btn-send">Registrar tipo de uso</button>
                    </section>
                </section> 
            </form>
        </section>
    </main>
@endsection
