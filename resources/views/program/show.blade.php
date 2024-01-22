@extends("layouts.authLayout")

@section("title")
    Programas
@endsection

@section("main")
    <main class="container">
        <section>
            <section>
                <a class="btn btn-primary col-12 my-3" href="{{route("program.create")}}">Agregar programa</a>
            </section>
            <section>
                <ol class="list-group list-group-numbered">
                    @forelse ($programs as $program)
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
                    @empty
                        <li class="alert alert-danger p-2 ">No hay programas</li>
                    @endforelse
                </ol>
            </section>
        </section>
        <section class="mt-3">
            {{ $programs->links() }}
        </section>
    </main>
@endsection
