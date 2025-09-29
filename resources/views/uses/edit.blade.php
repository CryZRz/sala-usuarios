@extends('layouts.mainLayout')

@section("module")
    Tipos de usos
@endsection

@section('title')
    Editar Uso
@endsection

@section('content')
    <div class="mx-10 mt-10 flex justify-center">
        <div class="bg-white rounded-md w-4/5 shadow-md p-3">
            <div class="py-3">
                <h3 class="text-gray-700 font-medium">Nuevo tipo de uso</h3>
            </div>
            <section>
                <form action="{{route('computer.updateUse')}}" method="POST">
                    @csrf
                    <section class="mt-3">
                        <input name="idUso" type="text" value="{{$uso->id}}" hidden>
                        <div class="col-12 mb-2 mx-auto">
                            <label class="text-sm text-gray-700 block" for="nombre">Nombre:</label>
                            <input
                                class="w-full border border-gray-400 rounded-md p-1 text-gray-500 outline-0"
                                name="name"
                                type="text"
                                placeholder="Nombre del tipo de uso"
                                required
                                value="{{ $uso->name }}"
                            >
                        </div>
                        @error("name")
                            <p class="text-xs text-red-500">{{$message}}</p>
                        @enderror
                        <section>
                            <button class="bg-brand-primary w-full rounded-md p-1 text-white mt-3 cursor-pointer" type="submit" id="btn-send">
                                Editar
                            </button>
                        </section>
                    </section>
                </form>
            </section>
        </div>
    </div>
@endsection
