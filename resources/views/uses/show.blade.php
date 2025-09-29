@extends('layouts.mainLayout')

@section("module")
    Tipos de usos
@endsection

@section('title')
    Tipos de uso
@endsection

@section('content')
    <section class="mx-3 mt-10" x-data="{showRemove: false, useRemove: 0}">

        <x-modal-confirm-component :id="'showRemove'" message="Deseas eliminar el programa">
            <x-slot name="confirmButton">
                <form action="{{route("computer.destroyUse")}}" method="post" class="inline w-auto">
                    @csrf
                    @method("DELETE")
                    <input name="idUse" type="hidden" :value="useRemove">
                    <button class="bg-brand-alert p-2 text-white text-sm rounded-md cursor-pointer">Eliminar</button>
                </form>
            </x-slot>
        </x-modal-confirm-component>

        <section class="w-full bg-white p-3 rounded-md">
            <section>
                <a
                    class="mb-2 m-0 bg-brand-primary w-full p-1 text-white rounded-md block text-center text-base"
                    href="{{ route('computer.createUse') }}">
                    Agregar tipo de uso
                </a>
            </section>
            <section>
                <nav class="flex min-w-[240px] flex-col gap-1 p-1.5">
                    @forelse ($usos as $uso)
                        <div
                            role="button"
                            class="text-slate-800 flex w-full items-center rounded-md p-2 pl-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                        >
                            <div>
                                <span class="block">Nombre: {{$uso->name}}</span>
                                <i class="block text-sm">Version: {{$uso->version}}</i>
                            </div>
                            <div class="ml-auto flex place-items-center justify-self-end">
                                <button @click="showRemove = true; useRemove = {{$uso->id}}" class="cursor-pointer rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-slate-600 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                                    <i class="bi bi-trash text-xl"></i>
                                </button>
                                <a href="{{ route('computer.editUse', $uso->id) }}" class="cursor-pointer rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-slate-600 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                                    <i class="bi bi-pen text-xl"></i>
                                </a>
                            </div>
                        </div>
                </nav>
                    @empty
                        <span class="alert alert-danger p-2 mt-2">
                            No hay tipos de uso
                        </span>
                    @endforelse
            </section>
            <div class="flex items-center justify-between p-4">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    Pagina {{ $usos->currentPage() }} de {{ $usos->lastPage() }}
                </p>
                <div class="flex gap-2">
                    @if ($usos->onFirstPage())
                        <a
                            class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @else
                        <a
                            href="{{ $usos->previousPageUrl() }}"
                            class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @endif
                    @if ($usos->hasMorePages())
                        <a
                            href="{{ $usos->nextPageUrl() }}"
                            class="cursor-pointer select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Siguiente
                        </a>
                    @else
                        <button
                            class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Siguiente
                        </button>
                    @endif
                </div>
            </div>

        </section>
    </section>
@endsection
