@extends("layouts.mainLayout")

@section("title")
    @isset ($program)
        Editar Programa
    @else
        Crear programa
    @endisset
@endsection

@section("content")
    <div class="mx-10 mt-10 flex justify-center">
        <div class="bg-white rounded-md w-4/5 shadow-md p-3">
            <div class="py-3">
                <h3 class="text-gray-700 font-medium">Nuevo Programa</h3>
            </div>
            <section>
                <form
                    action=@isset($program) {{route("program.update")}} @else {{route("program.store")}} @endisset
                    method="POST"
                    class="col-md-12"
                >
                    @csrf
                    @isset($program)
                        @method("PUT")
                        <input name="id" type="hidden" value="{{$program->id}}">
                    @endisset

                    <div class="mb-3">
                        <label for="name" class="m-0 block text-sm text-gray-700">Nombre</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="w-full border border-gray-400 rounded-md p-1 outline-0 text-gray-600  @error('name') border-red-400 @enderror"
                            placeholder="Nombre del programa"

                            value=@isset ($program) {{$program->name}} @endisset
                        >
                        @error('name')
                            <p class="text-xs text-red-500 mt-0.5">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="version" class="m-0 block text-sm text-gray-700">Version</label>
                        <input
                            id="version"
                            type="text"
                            name="version"
                            class="w-full border border-gray-400 rounded-md p-1 outline-0 text-gray-600 @error('version') border-red-400 @enderror"
                            placeholder="Version del programa"

                            value=@isset ($program) {{$program->version}} @endisset
                        >
                        @error('version')
                        <p class="text-xs text-red-500 mt-0.5">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="justify-end flex mt-3 gap-1">
                        @isset($program)
                            <div class="col-lg-6 mb-2">
                                <button class="bg-brand-primary p-2 text-white rounded-md cursor-pointer text-sm">Editar</button>
                            </div>
                        @else
                            <button class="bg-brand-primary p-2 text-white rounded-md cursor-pointer text-sm">Guardar</button>
                        @endisset
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
