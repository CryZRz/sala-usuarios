@extends('layouts.authLayout')

@section('titulo')
    Editar Equipo
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/computer/edit.js'])
@endsection

@section('main')
    <main>
        <section id="section-loading"></section>
        <section class="container">
            <h1>Editar equipo de cómputo</h1>
            <form action="" method="POST">
                <section class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <label for="cpu">CPU</label>
                        <input
                            id="input-name"
                            class="col-12 p-1"
                            name="cpu"
                            type="text"
                            placeholder="Nombre del procesador"
                            required
                            value="{{ $computer->cpu }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ram">RAM</label>
                        <input
                            id="input-ram"
                            class="col-12 p-1"
                            name="ram"
                            type="number"
                            placeholder="Ingresa la ram en GB"
                            required
                            value="{{ $computer->ram }}">
                    </div>
                </section>
                <section class="border-top border-secondary border-1 pt-3 mb-4" id="ports-section">
                    <label class="h5" for="">Puertos</label>
                    <button class="btn btn-warning text-white col-12 mb-2" id="btn-add-port">Agregar</button>
                    <div class="mb-2" id="list-prots"></div>
                    <div id="list-ports-editable">
                        <label class="h5" for="">Puertos del equipo</label>
                        @forelse ($computer->ports as $port)
                            <div class="" id="li-port-editable" port="{{ $port->id }}">
                                <section class="row g-3 mb-2">
                                    <div class="col-lg-4">
                                        <input class="col-12 p-1" type="text" value="{{ $port->type }}" id="port-type-editable">
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="col-12 p-1" type="text" value="{{ $port->amount }}" id="port-ammount-editable">
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-success col-12" type="text" id="btn-edit-port-editable" port="{{ $port->id }}">
                                            Editar
                                        </button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-danger col-12" id="btn-remove-port-editable" port="{{ $port->id }}">
                                            Eliminar
                                        </button>
                                    </div>
                                </section>
                            </div>
                        @empty
                            <p class="mb-3 mx-3 text-danger fw-bold">El equipo no tiene puertos</p>
                        @endforelse
                    </div>
                </section>
                <section class="border-top border-secondary border-1 pt-3 mb-3" id="programs-section">
                    <label class="h5" for="">Programas disponibles</label>
                    <ol class="list-group list-group-numbered" id="list-programs-available">

                    </ol>
                    <div id="btn-show-more">

                    </div>
                    <x-create-program-component/>
                </section>
                <section class="border-top border-secondary border-1 pt-3 mb-2">
                    <label class="h5" for="">Programas del equipo</label>
                    <ol class="list-group list-group-numbered" id="section-programs-computer">
                        @forelse ($computer->programs as $programComp)
                        <li
                            class="list-group-item d-flex justify-content-between align-items-start"
                            id="li-program-computer" program="{{ $programComp->id }}"
                            >
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $programComp->program->name }}</div>
                                version: {{ $programComp->program->version }}
                              </div>
                              <input id="btn-remove-program" type="checkbox" checked program="{{ $programComp->id }}">
                            </div>
                        </li>
                        @empty
                            <p class="mb-3 mx-3 text-danger fw-bold">El equipo no tiene programas</p>
                        @endforelse
                    </ol>
                </section>
                <section>
                    <button class="btn btn-primary col-12 my-2" id="btn-send">Editar Computadora</button>
                </section>
                <section>
                    <form action="{{route("computer.destroy", $computer->id)}}" method="POST">
                        @csrf
                        @method("delete")
                        <button class="btn btn-danger col-12 mb-2">Eliminar equipo</button>
                    </form>
                </section>
            </form>
        </section>
    </main>
    <script>
        const idComputer = {{ $computer->id }}
    </script>
@endsection
