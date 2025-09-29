@extends("layouts.mainLayout")

@section("title")
    Computadoras
@endsection

@section("module")
    Equipos de computo
@endsection

@section("content")
    <div class="bg-white p-5 rounded-md mt-10">
        <div class="">
            <h5
                class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                Equipos de Computo
            </h5>
        </div>
        <div class="w-full flex justify-between mt-6">
            <div>
                <x-action-link
                    can="{{ $module }}.create"
                    href="{{ route('computer.create') }}"
                    style="block text-center cursor-pointer p-2 bg-brand-secondary rounded-md text-white text-sm font-bold w-28"
                >
                    Agregar
                </x-action-link>
            </div>
            <div>
                <form action="{{route("computer.show")}}" method="get">
                    <input value="{{ request('find') }}" name="find" type="text" class="bg-white rounded-md p-2 text-gray-600 outline-0 border border-gray-300" placeholder="Buscar">
                </form>
            </div>
        </div>
    </div>
    <div class="w-full flex gap-4 mt-6 flex-wrap">
        @foreach($computers as $computer)
            <div class="bg-white w-64 rounded-md shadow-md">
                <div class="flex items-center justify-center p-4">
                    <div>
                        <i class="bi bi-pc-display text-6xl text-gray-700"></i>
                    </div>
                </div>
                <div class="p-2">
                    <div>
                        <span class="text-base text-gray-600 font-bold">Numero: </span>
                        <span class="text-base text-gray-500">{{$computer->computer_number}}</span>
                    </div>
                    <div>
                        <span class="text-base text-gray-600 font-bold">CPU: </span>
                        <span class="text-base text-gray-500">{{$computer->cpu}}</span>
                    </div>
                    <div>
                        <span class="text-base text-gray-600 font-bold">RAM: </span>
                        <span class="text-base text-gray-500">{{$computer->ram}} GB</span>
                    </div>
                    <div class="mt-2">
                        <x-action-link
                            can="{{ $module }}.update"
                            href="{{ route('computer.edit', $computer->id) }} "
                            style="block bg-brand-secondary  rounded-md text-white text-center p-0.5"
                        >
                            <i class="bi bi-pencil-square text-sm"></i>
                            <span class="text-sm">Editar</span>
                        </x-action-link>
                        <a href="" class="block bg-brand-primary p-1 rounded-md text-white mt-2 text-center">
                            <i class="bi bi-file-text-fill text-sm"></i>
                            <span class="text-sm">Detalle</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        <div class="flex items-center justify-between p-4 bg-white rounded-md shadow-md">
            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                Pagina {{ $computers->currentPage() }} de {{ $computers->lastPage() }}
            </p>
            <div class="flex gap-2">
                @if ($computers->onFirstPage())
                    <a
                        class="opacity-50 cursor-not-allowed select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button">
                        Anterior
                    </a>
                @else
                    <a
                        href="{{ $computers->previousPageUrl() }}"
                        class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button">
                        Anterior
                    </a>
                @endif
                @if ($computers->hasMorePages())
                    <a
                        href="{{ $computers->nextPageUrl() }}"
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
@endsection
