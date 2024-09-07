@extends('layouts.authLayout')

@section('title')
    Tipos de uso
@endsection

@section('main')
    <main>
        <section class="container d-flex flex-column">
            <a
                class="btn btn-primary fw-bold col-12 mb-2 m-0 "
                href="{{ route('computer.createUse') }}">
                Agregar tipo de uso
            </a>
            <section>
                <ol class="list-group list-group-numbered">
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
                                <a
                                    href="{{ route('computer.editUse', $uso->id) }}"
                                    class="btn btn-primary">
                                    Editar
                                </a>
                                <form action="{{ route('computer.destroyUse', $uso->id) }}" method="POST">
                                    @csrf
                                    @method("delete")
                                    <button class="btn btn-danger" type="submit">
                                        Eliminar
                                    </button>
                                </form>
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
