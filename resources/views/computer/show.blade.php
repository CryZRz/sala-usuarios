@extends('layouts.authLayout')

@section('title')
    Equipos
@endsection

@section('main')
    <main>
        <section class="container">
            <a class="btn btn-success col-12 mb-2" href="{{ route('computer.create') }}">
                Agregar computadora
            </a>
            <section>
                <ol class="list-group list-group-numbered">
                    @forelse ($computers as $computer)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="d-flex">
                                    <div>
                                        <i class="bi bi-pc-display-horizontal" style="font-size: 3rem"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center m-2">
                                        <div>
                                            CPU:
                                            <span class="fw-bold">{{ $computer->cpu }}</span>
                                        </div>
                                        <div>
                                            RAM:
                                            <span class="fw-bold"> {{ $computer->ram }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('computer.edit', $computer->id) }}" class="badge bg-primary rounded-pill ">
                                <i class=" bi bi-pencil-square" style="font-size: 1rem"></i>
                            </a>
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
        <section class="mt-3">
            {{ $computers->links() }}
        </section>
    </main>
@endsection
