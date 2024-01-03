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
        <section class="container mt-2">
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
              @isset($program)
                <legend>Editar programa</legend>
              @else
                <legend>Crear programa</legend>
              @endisset
              
              <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    class="col-12 @error('name') form-control is-invalid @enderror"
                    placeholder="Nombre del programa" 
                    required
                    value=@isset ($program) {{$program->name}} @endisset
                >
              </div>
              <div class="mb-3">
                <label for="version">Version</label>
                <input 
                    id="version" 
                    type="text" 
                    name="version" 
                    class="col-12 p-1 @error('version') form-control is-invalid @enderror" 
                    placeholder="Version del programa" 
                    required
                    value=@isset ($program) {{$program->version}} @endisset
                >
              </div>
              <div class="row">
                @isset($program)
                    <div class="col-lg-6 mb-2">
                      <button class="btn btn-success col-12">Editar</button>
                    </div>
                    <div class="col-lg-6 mb-2">
                      <button class="btn btn-danger col-12">Eliminar</button>
                    </div>
                @else
                    <button class="btn btn-primary col-12">Guardar</button>
                @endisset
              </div>
            </fieldset>
          </form>
        </section>
    </main>
@endsection