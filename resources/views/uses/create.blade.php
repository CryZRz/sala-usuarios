@extends('layouts.authLayout')

@section('title')
    Crear Uso
@endsection

@section('main')
    <main>
        <section class="container p-3">
            <p class="h3 fw-bold">Crear tipo de uso</p>
            <form action="{{route('computer.storeUse')}}" method="POST">
                @csrf
                <section class="mb-2">
                    <div class="mb-2 mx-auto">
                        <label class="my-1" for="name">Nombre</label>
                        <input class="col-12 p-1" name="nombre" type="text"
                            placeholder="Nombre del tipo de uso" required>
                    </div>
                    <section>
                        <button class="btn btn-primary col-12 my-2 fw-bold" type="submit" id="btn-send">Registrar tipo de uso</button>
                    </section>
                </section>
            </form>
        </section>
    </main>
@endsection
