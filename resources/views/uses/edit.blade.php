@extends('layouts.authLayout')

@section('titulo')
    Editar Uso
@endsection

@section('main')
    <main>
        <section id="section-loading"></section>
        <section class="container d-flex flex-column gap-2">
            <p class="h3 fw-bold">Editar tipo de uso</p>
            <form action="{{route('computer.updateUse')}}" method="POST">
                @csrf
                <section class="row mb-2">
                    <input name="id" type="text" value="{{$uso->id}}" hidden>
                    <div class="col-12 mb-2 mx-auto">
                        <label class="" for="nombre">Nombre:</label>
                        <input
                            class="col-12 p-1"
                            name="nombre"
                            type="text"
                            placeholder="Nombre del tipo de uso"
                            required
                            value="{{ $uso->name }}"
                        >
                    </div>
                    <section>
                        <button class="btn btn-primary fw-bold my-2 col-12" type="submit" id="btn-send">Guardar cambios</button>
                    </section>
                </section>
            </form>
        </section>
    </main>
@endsection
