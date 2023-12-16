@extends("layouts.authLayout")

@section("title")
    @isset ($program)
        Editar Programa
    @else
        Crear programa
    @endisset
@endsection

@section("main")
    <main>
        {{$errors}}
        <form 
            action=@isset($program) {{route("program.update")}} @else {{route("program.store")}} @endisset 
            method="POST"
        >
            @csrf
            @isset($program)
                @method("PUT")
                <input name="id" type="hidden" value="{{$program->id}}">
            @endisset
            <label for="name">Nombre</label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                placeholder="Nombre del programa" 
                required
                value=@isset ($program) {{$program->name}} @endisset
            >
            <label for="version">Version</label>
            <input 
                id="version" 
                type="text" 
                name="version" 
                placeholder="Version del programa" 
                required
                value=@isset ($program) {{$program->version}} @endisset
            >
            @isset($program)
                <button>Editar</button>
            @else
                <button>Guardar</button>
            @endisset
        </form>
    </main>
@endsection