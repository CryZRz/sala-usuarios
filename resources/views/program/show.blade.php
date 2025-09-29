@extends("layouts.mainLayout")

@section("module")
    Programas
@endsection

@section("title")
    Programas
@endsection

@section("content")
    <section class="mx-7 mt-10" x-data="{showRemove: false, programRemove: 0}">
        <x-modal-confirm-component :id="'showRemove'" message="Deseas eliminar el programa">
            <x-slot name="confirmButton">
                <form action="{{route("program.destroy")}}" method="post" class="inline w-auto">
                    @csrf
                    @method("DELETE")
                    <input name="id" type="hidden" :value="programRemove">
                    <button class="bg-brand-alert p-2 text-white text-sm rounded-md cursor-pointer">Eliminar</button>
                </form>
            </x-slot>
        </x-modal-confirm-component>
        <div class="rounded-lg bg-white shadow-sm border border-slate-200 p-3 w-full">
            <div class="flex justify-between items-center w-full">
                <div>
                    <h1 class="text-gray-500 text-lg font-semibold my-5">Listado de Programas</h1>
                </div>
                <div>
                    <form action="{{route("program.show")}}" method="get">
                        <div class="w-full md:w-72 h-10 flex justify-center items-center">
                            <div class="relative  w-5/6">
                                <input
                                    class="peer h-full w-full rounded-bl-md rounded-tl-md border border-gray-400 bg-transparent px-3 py-2.5 !pr-9 font-sans text-sm font-normal text-blue-gray-700 outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-gray-600 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                                    placeholder=" " name="textFind" value="{{request("textFind")}}"/>
                                <label
                                    class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-gray-900 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-gray-900 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                    Buscar
                                </label>
                            </div>
                            <div class="h-full w-2/6">
                                <button class="w-full h-full bg-brand-primary rounded-tr-md rounded-br-md cursor-pointer">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <a class="bg-brand-primary w-full block rounded-md text-white text-center p-1" href="{{route("program.create")}}">Agregar programa</a>
            </div>
            <nav class="flex min-w-[240px] flex-col gap-1 p-1.5">
                @foreach($programs as $program)
                    <div
                        role="button"
                        class="text-slate-800 flex w-full items-center rounded-md p-2 pl-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                    >
                        <div>
                            <span class="block">Nombre: {{$program->name}}</span>
                            <i class="block text-sm">Version: {{$program->version}}</i>
                        </div>
                        <div class="ml-auto flex place-items-center justify-self-end">
                            <button @click="showRemove = true; programRemove = {{$program->id}}" class="cursor-pointer rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-slate-600 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                                <i class="bi bi-trash text-xl"></i>
                            </button>
                            <a href="{{route('program.edit', $program->id)}}" class="cursor-pointer rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-slate-600 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                                <i class="bi bi-pen text-xl"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </nav>
            <div class="flex items-center justify-between p-4">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    Pagina {{ $programs->currentPage() }} de {{ $programs->lastPage() }}
                </p>
                <div class="flex gap-2">
                    @if ($programs->onFirstPage())
                        <a
                            class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @else
                        <a
                            href="{{ $programs->previousPageUrl() }}"
                            class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Anterior
                        </a>
                    @endif
                    @if ($programs->hasMorePages())
                        <a
                            href="{{ $programs->nextPageUrl() }}"
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
        </div>
    </section>
@endsection
