@extends("layouts.authLayout")

@section("title")
    Programas
@endsection

@section("main")
    <main class="container">
        <a class="btn btn-primary col-12 my-3" href="{{route("program.create")}}">Agregar programa</a>
        <ol class="list-group list-group-numbered">
            @foreach ($programs as $program)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">{{$program->name}}</div>
                    version: {{$program->version}}
                  </div>
                  <a 
                    href="{{route('program.edit', $program->id)}}" 
                    class="badge bg-primary rounded-pill ">
                    <i class=" bi bi-pencil-square" style="font-size: 1rem"></i>
                  </a>
                </div>
            </li>
            @endforeach
        </ol>
        <section class="mt-3">
            {{ $programs->links() }}
        </section>
    </main>
@endsection