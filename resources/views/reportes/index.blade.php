@extends("layouts.mainLayout")

@section("title")
    Reportes
@endsection

@section("module")
    Generacion de reportes
@endsection

@section("content")
    <div class="w-full mt-15 flex justify-center">
        <div class="bg-white rounded-md w-4/5 shadow-md p-3">
            <div class="p-3">
                <h3 class="text-gray-700 font-medium">
                    Listado de reportes
                </h3>
            </div>

            <div class="p-3">
                <div class="border-b border-slate-200" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-2 text-slate-800">
                        <span>
                            Reporte tiempo de uso del centro de cómputo
                        </span>
                        <div x-show="!open" x-transition>
                            <i class="bi bi-arrow-up-short text-2xl"></i>
                        </div>
                        <div x-show="open" x-transition>
                            <i class="bi bi-arrow-down-short text-2xl"></i>
                        </div>
                    </button>
                    <div x-show="open" x-transition id="content-1" class="transition-all duration-300 ease-in-out">
                        <div>
                            <form action="{{route('report1')}}" method="get">
                                <div class="mb-2">
                                    <label for="" class="mb-1 block text-xs font-semibold text-gray-600">Carrera</label>
                                    <select class="border border-gray-300 rounded-md p-1 w-full text-sm" name="career" id="career" required>
                                        @foreach($careers as $career)
                                            <option value="{{$career->id}}">{{$career->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex gap-3">
                                    <div class="mb-2 w-full">
                                        <label for="semester" class="block mb-1 text-xs font-semibold text-gray-600">Semestre</label>
                                        <select class="outline-0 border border-gray-300 text-sm rounded-md w-full p-1" name="semester" id="semester">
                                            @foreach(range(1,13) as $i)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <x-select-periods-component name="periodId"></x-select-periods-component>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <button type="submit" class="cursor-pointer text-sm w-full p-1 bg-brand-primary text-white rounded-md">Generar reporte</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="border-b border-slate-200 mt-3" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-2 text-slate-800">
                        <span>
                            Reporte tiempo de uso del centro de cómputo por carrera
                        </span>
                        <div x-show="!open" x-transition>
                            <i class="bi bi-arrow-up-short text-2xl"></i>
                        </div>
                        <div x-show="open" x-transition>
                            <i class="bi bi-arrow-down-short text-2xl"></i>
                        </div>
                    </button>
                    <div x-show="open" x-transition id="content-1" class="transition-all duration-300 ease-in-out">
                        <div class="pb-5 text-sm text-slate-500">
                            <form action="{{route('report2')}}" method="get">
                                <div class="mb-2">
                                    <x-select-periods-component name="periodId"></x-select-periods-component>
                                </div>
                                <div class="py-2">
                                    <button class="cursor-pointer text-sm w-full p-1 bg-brand-primary text-white rounded-md">Generar reporte</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="border-b border-slate-200 mt-3" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-2 text-slate-800">
                        <span>
                            Reporte de tiempo de uso del centro de cómputo por carrera (detallado)
                        </span>
                        <div x-show="!open" x-transition>
                            <i class="bi bi-arrow-up-short text-2xl"></i>
                        </div>
                        <div x-show="open" x-transition>
                            <i class="bi bi-arrow-down-short text-2xl"></i>
                        </div>
                    </button>
                    <div x-show="open" x-transition id="content-1" class="transition-all duration-300 ease-in-out">
                        <div class="pb-5 text-sm text-slate-500">
                            <form action="{{route('report3')}}" method="get">
                                <div class="mb-2">
                                    <x-select-periods-component name="periodId"></x-select-periods-component>
                                </div>
                                <div>
                                    <button class="cursor-pointer text-sm w-full p-1 bg-brand-primary text-white rounded-md">Generar reporte</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="border-b border-slate-200 mt-3" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-2 text-slate-800">
                        <span>
                            Reporte de cantidad de usos de los equipos por carrera
                        </span>
                        <div x-show="!open" x-transition>
                            <i class="bi bi-arrow-up-short text-2xl"></i>
                        </div>
                        <div x-show="open" x-transition>
                            <i class="bi bi-arrow-down-short text-2xl"></i>
                        </div>
                    </button>
                    <div x-show="open" x-transition id="content-1" class="transition-all duration-300 ease-in-out">
                        <div class="pb-5 text-sm text-slate-500">
                            <form action="{{route('report4')}}" method="get">
                                <div class="mb-2">
                                    <x-select-periods-component name="periodId"></x-select-periods-component>
                                </div>
                                <div>
                                    <button class="cursor-pointer text-sm w-full p-1 bg-brand-primary text-white rounded-md">Generar reporte</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="border-b border-slate-200 mt-3" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-2 text-slate-800">
                        <span>
                            Reporte de cantidad de tipos de uso por carrera
                        </span>
                        <div x-show="!open" x-transition>
                            <i class="bi bi-arrow-up-short text-2xl"></i>
                        </div>
                        <div x-show="open" x-transition>
                            <i class="bi bi-arrow-down-short text-2xl"></i>
                        </div>
                    </button>
                    <div x-show="open" x-transition id="content-1" class="transition-all duration-300 ease-in-out">
                        <div class="pb-5 text-sm text-slate-500">
                            <form action="{{route('report5')}}" method="get">
                                <div class="mb-2">
                                    <x-select-periods-component name="periodId"></x-select-periods-component>
                                </div>
                                <div>
                                    <button class="cursor-pointer text-sm w-full p-1 bg-brand-primary text-white rounded-md">Generar reporte</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
