@extends('layouts.authLayout')

@section('title')
    Tipos de uso
@endsection

@section('main')
    <main>
        <section class="container d-flex flex-column">
            <a class="btn btn-turquesa fw-bold col-12 mb-2 w-auto mx-auto" href="{{ route('computer.createUse') }}">
                Agregar tipo de uso
            </a>
            <section>
                <ol class="list-group list-group-numbered w-50 mx-auto">
                    @forelse ($usos as $uso)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="d-flex">
                                    <div class="d-flex flex-column justify-content-center m-2">
                                        <div>
                                            <span class="fw-bold">{{ $uso->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-row gap-1">
                                <a href="{{ route('computer.editUse', $uso->id) }}" class="btn text-light badge bg-primary rounded-pill text-decoration-none">
                                    <span class="h6 fw-bold">Editar</span>
                                </a>
                                <form action="{{ route('computer.destroyUse', $uso->id) }}" method="POST">
                                    @csrf
                                    @method("delete")
                                    <button class="badge bg-danger rounded-pill text-decoration-none" type="submit">
                                        <span class="h6 fw-bold">Eliminar</span>
                                    </button>
                                </form>
                            </div>
                            </div>
                        </li>
                    @empty
                        <span class="alert alert-danger p-2 mt-2">
                            No hay computadoras
                        </span>
                    @endforelse
                </ol>
            </section>
        </section>
    </main>
@endsection
