@extends("layouts.mainLayout")

@section("title")
    Importar Alumno
@endsection

@section("module")
    Importacion de Alumnos
@endsection

@section("content")
    <main class="mx-10 mt-15">
        @if(!isset($valid))
            <section id="section-loading"></section>
            <div class="relative min-h-80 w-full flex flex-col justify-center items-center my-6 bg-white shadow-sm border border-slate-200 rounded-lg p-2">
                <div class="p-3 text-center w-full">
                    <div class="flex justify-center mb-1 text-brand-primary">
                        <i class="bi bi-cloud-arrow-up-fill text-4xl"></i>
                    </div>
                    <div class="flex justify-center mb-2">
                        <h5 class="text-slate-800 text-2xl font-semibold">
                            Importar alumnos
                        </h5>
                    </div>
                    <div class="w-full">
                        <p class="mx-auto block text-slate-600 leading-normal font-light mb-4 max-w-xl">
                            Sube el archivo excel que contiene los registros de los alumnos,
                            aquellos que ya se encontraban registrados se les actualizarán sus datos.

                        </p>
                    </div>
                    </p>
                    @if(session("error") != null)
                        <div class="bg-red-300 my-2 text-white p-2">
                            <span class="text-red-500">
                               {{session("error")}}
                            </span>
                        </div>
                    @endif
                    <div class="text-center w-full">
                        <form id="form-import" action="{{ route('import.uploadPending') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="w-full py-9 bg-gray-50 rounded-2xl border border-gray-300 gap-3 grid border-dashed">
                                <div class="grid gap-1">
                                    <i class="bi bi-filetype-xlsx text-brand-primary text-4xl"></i>
                                    <h2 class="text-center text-gray-400   text-xs leading-4">XLSX, CSV, menor a 15MB</h2>
                                </div>
                                <div class="grid gap-2">
                                    <h4 class="text-center text-gray-900 text-sm font-medium leading-snug">Arrastra y Suelta tu archivo aqui</h4>
                                    <div class="flex items-center justify-center">
                                        <label>
                                            <input name="file" type="file" hidden />
                                            <div class="flex w-28 h-9 px-2 flex-col bg-brand-primary rounded-full shadow text-white text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">
                                                Seleccionar
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="w-full flex justify-end p-3">
                    <button @click="$store.loader.show()" type="submit" form="form-import" class="bg-brand-primary rounded-md shadow text-white text-xs font-semibold p-3 cursor-pointer">
                        Importar
                    </button>
                </div>
            </div>
        @else
            <x-show-alert-component
                text="La carga de alumnos ya se ha realizado para el periodo {{$period->name}}"
            />
        @endif
    </main>
@endsection
