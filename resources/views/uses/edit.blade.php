@extends('layouts.authLayout')

@section('titulo')
    Editar Uso
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main')
    <main>
        <section id="section-loading"></section>
        <section class="container d-flex flex-column text-center gap-2">
            <p class="h3 fw-bold">Editar tipo de uso</p>
            <form action="{{route('computer.updateUse')}}" method="POST">
                @csrf
                <section class="row mb-2">
                    <input name="id" type="text" value="{{$uso->id}}" hidden>
                    <div class="col-md-6 mb-2 mx-auto">
                        <label class="h5" for="nombre">Nombre:</label>
                        <input class="col-12 text-center" name="nombre" type="text"
                            placeholder="Nombre del tipo de uso" required value="{{ $uso->name }}">
                    </div>
                    <section>
                        <button class="btn btn-turquesa fw-bold my-2" type="submit" id="btn-send">Guardar cambios</button>
                    </section>
                </section> 
            </form>
        </section>
    </main>
@endsection
